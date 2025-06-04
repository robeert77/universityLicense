<?php

namespace App\View\Components\Dashboard;

use App\Models\Task;
use Carbon\Carbon;

class NrCompletedTasks extends WidgetCard
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        parent::__construct(
            title: __('dashboard.completed_tasks'),
            value: $this->getData(),
            icon: 'clipboard-check',
            color: 'success'
        );
    }

    private function getData() : int
    {
        return Task::where('user_id', auth()->id())
            ->where('status', Task::STATUS_COMPLETED)
            ->count();
    }
}
