<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use Illuminate\Http\Request;

class IdeaController extends Controller
{
    public function index(Request $request)
    {
        $query = Idea::with('user')->whereNotIn('status', ['draft']);

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('problem', 'like', '%' . $request->search . '%')
                    ->orWhere('technology_stack', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $ideas = $query->latest()->paginate(10);

        return view('ideas.index', compact('ideas'));
    }

    public function create()
    {
        return view('ideas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'problem' => 'nullable|string',
            'solution' => 'nullable|string',
            'expected_result' => 'nullable|string',
            'required_resources' => 'nullable|string',
            'technology_stack' => 'nullable|string',
        ]);

        Idea::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'problem' => $request->problem,
            'solution' => $request->solution,
            'expected_result' => $request->expected_result,
            'required_resources' => $request->required_resources,
            'technology_stack' => $request->technology_stack,
            'status' => 'published',
        ]);

        return redirect()->route('ideas.index')->with('status', 'Идея успешно отправлена на рассмотрение!');
    }

    public function show(Idea $idea)
    {
        $idea->load('user', 'comments.user');
        return view('ideas.show', compact('idea'));
    }

    public function edit(Idea $idea)
    {
        $this->authorize('update', $idea);
        return view('ideas.edit', compact('idea'));
    }

    public function update(Request $request, Idea $idea)
    {
        $this->authorize('update', $idea);
        $request->validate([
            'title' => 'required|string|max:255',
            // ...
        ]);

        $idea->update($request->only([
            'title',
            'problem',
            'solution',
            'expected_result',
            'required_resources',
            'technology_stack'
        ]));

        return redirect()->route('ideas.show', $idea)->with('success', 'Обновлено.');
    }

    public function destroy(Idea $idea)
    {
        $this->authorize('delete', $idea);
        $idea->delete();
        return redirect()->route('ideas.index')->with('success', 'Удалено.');
    }
    
    public function updateStatus(Request $request, Idea $idea)
    {
        $this->authorize('update', $idea); // преподаватель или админ

        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $idea->update(['status' => $request->status]);

        $message = $request->status === 'approved' ? 'Идея одобрена!' : 'Идея отклонена.';
        return back()->with('status', $message);
    }
}