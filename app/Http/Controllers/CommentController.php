<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Сохранить комментарий к идее
     */
    public function store(Request $request, Idea $idea)
    {
        $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        $idea->comments()->create([
            'user_id' => Auth::id(),
            'body' => $request->body,
        ]);

        return back()->with('status', 'Комментарий добавлен.');
    }

    /**
     * Удалить комментарий
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();

        return back()->with('status', 'Комментарий удалён.');
    }
}