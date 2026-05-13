<?php

namespace App\Console\Commands;

use App\Models\Task;
use App\Notifications\TaskDeadline;
use Illuminate\Console\Command;

class SendDeadlineNotifications extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'app:send-deadline-notifications';

    /**
     * The console command description.
     */
    protected $description = 'Send push notifications for upcoming task deadlines';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $tasks = Task::where('status', '!=', 'done')
            ->whereDate('deadline', '<=', now()->addDay())
            ->whereDate('deadline', '>=', now())
            ->with('assignee')
            ->get();

        foreach ($tasks as $task) {
            if ($task->assignee) {
                $task->assignee->notify(new TaskDeadline($task));
            }
        }

        $this->info('Deadline notifications sent successfully.');
    }
}