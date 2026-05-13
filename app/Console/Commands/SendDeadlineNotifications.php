<?php

namespace App\Console\Commands;

use App\Models\Task;
use App\Notifications\TaskDeadline;
use Illuminate\Console\Command;

class SendDeadlineNotifications extends Command
{
    protected $signature = 'notifications:deadlines';
    protected $description = 'Уведомить исполнителей о задачах, дедлайн которых через 24 часа';

    public function handle(): void
    {
        $now = now();
        $target = now()->addHours(24);

        // Задачи со статусом todo или in_progress, дедлайн которых наступает ровно через 24 часа (± 30 минут)
        $tasks = Task::whereIn('status', ['todo', 'in_progress'])
            ->whereNotNull('deadline')
            ->whereNotNull('assigned_to')
            ->whereBetween('deadline', [
                $target->copy()->subMinutes(30),
                $target->copy()->addMinutes(30),
            ])
            ->with('assignee', 'project')
            ->get();

        foreach ($tasks as $task) {
            $task->assignee->notify(new TaskDeadline($task));
        }

        $this->info("Отправлено {$tasks->count()} уведомлений о дедлайнах.");
    }
}