<?php

namespace Database\Seeders;

use App\Models\Idea;
use App\Models\User;
use Illuminate\Database\Seeder;

class IdeaSeeder extends Seeder
{
    public function run(): void
    {
        // Создадим несколько пользователей, если их ещё нет
        $users = User::factory()->count(5)->create();

        $statuses = ['published', 'published', 'published', 'approved', 'draft'];

        $ideas = [
            [
                'title' => 'Платформа для отслеживания дедлайнов',
                'problem' => 'Студенты забывают о сроках сдачи отчётов по проектам.',
                'solution' => 'Создать портал с push-уведомлениями и календарём задач.',
                'expected_result' => 'Снижение просрочек на 70%',
                'required_resources' => 'Сервер, команда из 3 разработчиков, дизайнер.',
                'technology_stack' => 'Laravel, Vue.js, MySQL, FCM',
                'status' => 'published',
            ],
            [
                'title' => 'Чат с командой внутри портала',
                'problem' => 'Команды вынуждены использовать сторонние мессенджеры, что снижает концентрацию.',
                'solution' => 'Встроить мессенджер в рабочее пространство платформы.',
                'expected_result' => 'Повышение вовлечённости и упрощение коммуникации.',
                'required_resources' => 'WebSocket-сервер, фронтенд-разработчик.',
                'technology_stack' => 'Laravel Reverb, React, PostgreSQL',
                'status' => 'published',
            ],
            [
                'title' => 'Реестр студенческих инициатив',
                'problem' => 'Нет единого места для подачи идей студентами.',
                'solution' => 'Разработать модуль для подачи и обсуждения идей.',
                'expected_result' => 'Увеличение числа инновационных проектов.',
                'required_resources' => '1 бэкенд-разработчик, 1 фронтенд.',
                'technology_stack' => 'Laravel, Blade, Tailwind',
                'status' => 'published',
            ],
            [
                'title' => 'Профиль с компетенциями и портфолио',
                'problem' => 'Преподаватели не видят полную картину навыков студентов.',
                'solution' => 'Создать личный профиль с тегами навыков и примерами работ.',
                'expected_result' => 'Упрощение подбора студентов в проектные команды.',
                'required_resources' => 'Дизайнер, fullstack-разработчик.',
                'technology_stack' => 'Laravel, Livewire, MySQL',
                'status' => 'approved',
            ],
            [
                'title' => 'Автоматическое формирование отчётов',
                'problem' => 'Руководители тратят много времени на ручную сборку отчётов.',
                'solution' => 'Сделать генератор отчётов на основе данных о задачах и коммитах.',
                'expected_result' => 'Экономия 10 часов в неделю.',
                'required_resources' => 'API GitHub, библиотека генерации PDF.',
                'technology_stack' => 'Python, FastAPI, WeasyPrint',
                'status' => 'draft',
            ],
        ];

        foreach ($ideas as $index => $data) {
            Idea::create([
                'user_id' => $users[$index % count($users)]->id,
                'title' => $data['title'],
                'problem' => $data['problem'],
                'solution' => $data['solution'],
                'expected_result' => $data['expected_result'],
                'required_resources' => $data['required_resources'],
                'technology_stack' => $data['technology_stack'],
                'status' => $data['status'],
            ]);
        }
    }
}