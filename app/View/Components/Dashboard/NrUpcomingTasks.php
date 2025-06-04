<?php

namespace App\View\Components\Dashboard;

use App\Models\Task;
use Carbon\Carbon;

class NrUpcomingTasks extends WidgetCard
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        parent::__construct(
            title: __('dashboard.upcoming_tasks'),
            value: $this->getData(),
            icon: 'clipboard-pulse',
            color: 'info'
        );
    }

    private function getData() : int
    {
        return Task::where('user_id', auth()->id())
            ->where('scheduled_date', '>', Carbon::today())
            ->where('status', '!=', Task::STATUS_COMPLETED)
            ->count();
    }
}
