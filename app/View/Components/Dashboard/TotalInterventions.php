<?php

namespace App\View\Components\Dashboard;

use App\Models\Intervention;

class TotalInterventions extends WidgetCard
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        parent::__construct(
            title: __('dashboard.total_interventions_made_by_me'),
            value: $this->getData(),
            subtitle: '- ' . __('dashboard.made_by_me'),
            icon: 'wrench',
            color: 'success'
        );
    }

    private function getData()
    {
        return Intervention::where('user_id', auth()->id())
            ->count();
    }
}
