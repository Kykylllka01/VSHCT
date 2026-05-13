<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;

class ProjectPolicy
{
    public function viewAny(User $user): bool
    {
        return true; // все могут видеть список проектов
    }

    public function view(User $user, Project $project): bool
    {
        return true; // все могут видеть проект
    }

    public function create(User $user): bool
    {
        return $user->isTeacher() || $user->isAdmin();
    }

    public function update(User $user, Project $project): bool
    {
        return $user->id === $project->teacher_id || $user->isAdmin();
    }

    public function delete(User $user, Project $project): bool
    {
        return $user->id === $project->teacher_id || $user->isAdmin();
    }

    // Для управления командой и задачами – те же права, что и update
    public function manageTeam(User $user, Project $project): bool
    {
        return $user->id === $project->teacher_id || $user->isAdmin();
    }

    public function manageTasks(User $user, Project $project): bool
    {
        return $user->id === $project->teacher_id || $user->isAdmin();
    }

    
}