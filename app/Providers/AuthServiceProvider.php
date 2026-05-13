<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Project::class => ProjectPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Определяем шлюз 'admin', который проверяет, является ли пользователь администратором
        Gate::define('admin', function (User $user) {
            return $user->isAdmin();
        });

        // При необходимости можно добавить другие шлюзы, например:
        // Gate::define('teacher', fn(User $user) => $user->isTeacher());
    }
}