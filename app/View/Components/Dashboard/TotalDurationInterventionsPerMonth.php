<?php

namespace App\View\Components\Dashboard;

use App\Models\Intervention;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class TotalDurationInterventionsPerMonth extends WidgetCard
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $totalDurationArr = $this->getData();

        parent::__construct(
            title: __('dashboard.interventions_duration_this_month'),
            value: __('interventions.duration_parameter', ['hours' => $totalDurationArr['h'], 'minutes' => $totalDurationArr['m']]),
            subtitle: '- ' . __('dashboard.made_by_me'),
            icon: 'clock',
            color: 'success'
        );
    }

    private function getData() : array
    {
        return Intervention::getDurationForMonthForUser(Carbon::now());
    }
}
