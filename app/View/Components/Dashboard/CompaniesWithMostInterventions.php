<?php

namespace App\View\Components\Dashboard;

use App\Models\Intervention;
use Illuminate\Support\Facades\DB;

class CompaniesWithMostInterventions extends WidgetTableCard
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        parent::__construct(
            title: __('dashboard.most_interventions'),
            headers: $this->getHeaders(),
            tableData: $this->getData(),
            columns: $this->getColumns(),
            icon: 'graph-up',
            color: 'success',
        );
    }

    private function getData() : array
    {
        return Intervention::select('company_id',
            DB::raw('COUNT(id) AS nr_interventions'),
            DB::raw('SUM(TIMESTAMPDIFF(MINUTE, start_time, end_time)) AS total_duration'))
            ->groupBy('company_id')
            ->orderByDesc('nr_interventions')
            ->orderByDesc('total_duration')
            ->limit(5)
            ->get()
            ->map(function ($intervention) {
                $hours = floor($intervention->total_duration / 60);
                $minutes = floor($intervention->total_duration % 60);

                return [
                    'id'                  => $intervention->company->id,
                    'company_name'        => $intervention->company->name,
                    'total_interventions' => $intervention->nr_interventions,
                    'total_duration'      => [
                        'h' => $hours,
                        'm' => $minutes,
                    ],
                ];
            })
            ->toArray();
    }

    private function getHeaders(): array
    {
        return [
            '#',
            __('companies.company_name'),
            __('interventions.nr_interventions'),
            __('interventions.duration'),
        ];
    }

    private function getColumns(): array
    {
        return [
            ['type' => 'counter'],
            [
                'field' => 'company_name',
                'type' => 'link',
                'route' => 'companies.show',
                'route_param' => 'id'
            ],
            [
                'field' => 'total_interventions',
            ],
            [
                'type' => 'custom',
                'template' => function($item) {
                    return __('interventions.duration_parameter', [
                        'hours' => $item['total_duration']['h'] ?? 0,
                        'minutes' => $item['total_duration']['m'] ?? 0
                    ]);
                },
            ],
        ];
    }
}
