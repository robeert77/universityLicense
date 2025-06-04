<?php

namespace App\View\Components\Dashboard;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Support\Facades\Blade;

class MyUpcomingTasks extends WidgetTableCard
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        parent::__construct(
            title: __('dashboard.upcoming_tasks'),
            headers: $this->getHeaders(),
            tableData: $this->getData(),
            columns: $this->getColumns(),
            icon: 'clipboard-pulse',
        );
    }

    private function getData() : array
    {
            return Task::where('user_id', auth()->id())
            ->where('scheduled_date', '>', Carbon::today())
            ->orderBy('scheduled_date')
            ->limit(5)
            ->get(['id', 'title', 'status', 'scheduled_date'])
            ->toArray();
    }

    private function getHeaders(): array
    {
        return [
            '#',
            __('tasks.title'),
            __('tasks.status'),
            __('tasks.scheduled_date'),
        ];
    }

    private function getColumns(): array
    {
        return [
            ['type' => 'counter'],
            [
                'field' => 'title',
                'type' => 'link',
                'route' => 'tasks.show',
                'route_param' => 'id'
            ],
            [
                'type' => 'custom',
                'template' => function($item) {
                    $taskStatusesArr = Task::getStatuses();
                    $html = $taskStatusesArr[$item['status']] ?? 'Unknown Status';

                    if ($item['status'] === Task::STATUS_COMPLETED) {
                        $html .= Blade::render(
                            '<span style="cursor: context-menu;" class="btn py-0">
                                <x-icon name="{{ $iconName }}" size="{{ $size }}" color="{{ $color }}"></x-icon>
                            </span>',
                            [
                                'iconName' => 'check-circle-fill',
                                'size' => 5,
                                'color' => 'success',
                            ]
                        );
                    } elseif (-1 * Carbon::parse($item['scheduled_date'])->diffInDays(now()) <= 2) {
                        $color = Carbon::parse($item['scheduled_date'])->lt(now()->startOfDay()) ? 'danger' : 'warning';
                        $html .= Blade::render(
                            '<span style="cursor: context-menu;" class="btn py-0">
                                <x-icon name="{{ $iconName }}" size="{{ $size }}" color="{{ $color }}"></x-icon>
                            </span>',
                            [
                                'iconName' => 'exclamation-circle-fill',
                                'size' => 5,
                                'color' => $color,
                            ]
                        );
                    } elseif ($item['status'] === Task::STATUS_IN_PROGRESS) {
                        $html .= Blade::render(
                            '<span style="cursor: context-menu;" class="btn py-0">
                                <x-icon name="{{ $iconName }}" size="{{ $size }}" color="{{ $color }}"></x-icon>
                            </span>',
                            [
                                'iconName' => 'play-circle-fill',
                                'size' => 5,
                                'color' => 'warning',
                            ]
                        );
                    } elseif ($item['status'] === Task::STATUS_ON_HOLD) {
                        $html .= Blade::render(
                            '<span style="cursor: context-menu;" class="btn py-0">
                                <x-icon name="{{ $iconName }}" size="{{ $size }}" color="{{ $color }}"></x-icon>
                            </span>',
                            [
                                'iconName' => 'pause-circle-fill',
                                'size' => 5,
                                'color' => 'warning',
                            ]
                        );
                    } elseif ($item['status'] === Task::STATUS_ACTIVE) {
                        $html .= Blade::render(
                            '<span style="cursor: context-menu;" class="btn py-0">
                                <x-icon name="{{ $iconName }}" size="{{ $size }}" color="{{ $color }}"></x-icon>
                            </span>',
                            [
                                'iconName' => 'circle-fill',
                                'size' => 5,
                                'color' => 'success',
                            ]
                        );
                    }

                    return $html;
                }
            ],
            [
                'field' => 'scheduled_date',
                'type' => 'date',
                'format' => 'd.m.Y'
            ]
        ];
    }
}
