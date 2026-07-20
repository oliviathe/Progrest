<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskCollaboration;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $menu = [
            [
                'navigations' => [
                    ['name' => 'Dashboard', 'path' => '/dashboard'],
                    ['name' => 'Projects', 'path' => '/projects'],
                    ['name' => 'Collab', 'path' => '/collab'],
                    ['name' => 'Profiles', 'path' => '/profile'],
                ],
            ],
        ];

        $user = Auth::user();

        $projects = $user->projects()
            ->with('tasks')
            ->latest()
            ->get();

        return view('dashboard.index', [
            'menu' => $menu,
            'user' => $user,
            'projects' => $projects,
            'statistics' => $this->accountStatistics($user, $projects),
            'contribution' => $this->contributionStatistics($user),
            'taskReminders' => $this->taskReminders($user),

            'notifications' => $user->notifications()
                ->latest()
                ->take(10)
                ->get(),

            'unreadNotifications' => $user->unreadNotifications()
                ->count(),
        ]);
    }

    private function accountStatistics($user, $projects): array
    {
        $projectsCompleted = $projects->filter(function ($project) {
            return $project->tasks->count() > 0
                && $project->tasks->every(fn ($task) => $task->is_completed);
        })->count();

        $collabsCompleted = $user->taskCollaborations()
            ->where('status', 'completed')
            ->count();

        return [
            'login_streak' => [
                'current' => $user->current_streak ?? 0,
                'best' => $user->best_streak ?? 0,
            ],
            'projects_completed' => $projectsCompleted,
            'collabs_completed' => $collabsCompleted,
            'points' => [
                // Live balance and the all-time peak, both stored on the user.
                'current' => (int) ($user->points ?? 0),
                'highest' => (int) ($user->highest_points ?? 0),
            ],
        ];
    }

    private function contributionStatistics($user): array
    {
        return [
            'weekly' => $this->buildSeries($user, 7, 'day'),
            'monthly' => $this->buildSeries($user, 6, 'month'),
            'annually' => $this->buildSeries($user, 5, 'year'),
        ];
    }

    private function buildSeries($user, int $count, string $unit): array
    {
        $now = Carbon::now();
        $buckets = [];

        for ($i = $count - 1; $i >= 0; $i--) {
            $start = match ($unit) {
                'day' => $now->copy()->subDays($i)->startOfDay(),
                'month' => $now->copy()->subMonths($i)->startOfMonth(),
                'year' => $now->copy()->subYears($i)->startOfYear(),
            };

            $buckets[] = [
                'start' => $start,
                'end' => match ($unit) {
                    'day' => $start->copy()->endOfDay(),
                    'month' => $start->copy()->endOfMonth(),
                    'year' => $start->copy()->endOfYear(),
                },
                'label' => match ($unit) {
                    'day' => $start->format('D'),
                    'month' => $start->format('M'),
                    'year' => $start->format('Y'),
                },
                'value' => 0,
            ];
        }

        $rangeStart = $buckets[0]['start'];
        $rangeEnd = $buckets[count($buckets) - 1]['end'];

        // Two queries for the whole range, then bucket in PHP. This keeps the
        // page at a fixed query count and avoids database-specific date grouping.
        $dates = $user->tasks()
            ->where('tasks.is_completed', true)
            ->whereBetween('tasks.completed_at', [$rangeStart, $rangeEnd])
            ->pluck('tasks.completed_at')
            ->merge(
                TaskCollaboration::where('user_id', $user->id)
                    ->where('status', 'completed')
                    ->whereBetween('completed_at', [$rangeStart, $rangeEnd])
                    ->pluck('completed_at')
            )
            ->filter();

        foreach ($dates as $date) {
            foreach ($buckets as $index => $bucket) {
                if ($date >= $bucket['start'] && $date <= $bucket['end']) {
                    $buckets[$index]['value']++;
                    break;
                }
            }
        }

        $values = array_column($buckets, 'value');

        return [
            'labels' => array_column($buckets, 'label'),
            'values' => $values,
            'max' => $this->axisMax(max($values ?: [0])),
        ];
    }

    /**
     * Round the peak up to a clean y-axis ceiling so the chart never clips.
     */
    private function axisMax(int $peak): int
    {
        if ($peak <= 5) {
            return 5;
        }

        $step = (int) pow(10, max(0, strlen((string) $peak) - 2));
        $step = max($step, 1) * 5;

        return (int) (ceil($peak / $step) * $step);
    }

    /**
     * Task Reminder cards: unfinished tasks on the user's projects that are
     * overdue or due within the next three days, most urgent first.
     */
    private function taskReminders($user, int $limit = 6): array
    {
        $today = Carbon::now()->startOfDay();
        $horizon = $today->copy()->addDays(3)->endOfDay();

        $tasks = Task::with('project')
            ->whereIn('project_id', $user->projects()->pluck('projects.id'))
            ->where('is_completed', false)
            ->where('status', '!=', 'cancelled')
            ->whereNotNull('deadline')
            ->where('deadline', '<=', $horizon)
            ->orderBy('deadline')
            ->take($limit)
            ->get();

        return $tasks->map(function (Task $task) use ($today) {
            $deadline = $task->deadline->copy()->startOfDay();
            // Carbon 3 returns a float here, so cast before comparing.
            $daysLate = (int) $deadline->diffInDays($today, false);

            if ($daysLate > 0) {
                $type = 'critical';
                $urgency = __('main.dash.overdue');
                $countdown = trans_choice('main.dash.days-late', $daysLate, ['count' => $daysLate]);
            } elseif ($daysLate === 0) {
                $type = 'warning';
                $urgency = __('main.dash.due-soon');
                $countdown = __('main.dash.due-today');
            } else {
                $days = abs($daysLate);
                $type = 'warning';
                $urgency = __('main.dash.due-soon');
                $countdown = trans_choice('main.dash.days-left', $days, ['count' => $days]);
            }

            return [
                'id' => $task->id,
                'title' => $task->title,
                'project_id' => $task->project_id,
                'project_name' => $task->project?->title ?? 'No project',
                'project_icon' => $task->project?->icon ?: 'folder',
                'project_accent' => $task->project?->accent ?? '#14452F',
                'priority' => strtolower($task->priority ?? 'low'),
                'type' => $type,
                'urgency' => $urgency,
                'countdown' => $countdown,
                // Matches the date format used by the task page cards.
                'due_date' => $deadline->format('d M Y'),
            ];
        })->all();
    }
}
