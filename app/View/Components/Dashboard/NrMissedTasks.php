<?php

namespace App\View\Components\Dashboard;

use App\Models\Task;
use Carbon\Carbon;

class NrMissedTasks extends WidgetCard
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        parent::__construct(
            title: __('dashboard.missed_deadlines'),
            value: $this->getData(),
            icon: 'clipboard-x',
            color: 'danger'
        );
    }

    private function getData() : int
    {
        return Task::where('user_id', auth()->id())
            ->where('scheduled_date', '<', Carbon::today())
            ->where('status', '!=', Task::STATUS_COMPLETED)
            ->count();
    }
}
