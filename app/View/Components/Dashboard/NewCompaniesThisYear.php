<?php

namespace App\View\Components\Dashboard;

use App\Models\Company;
use Carbon\Carbon;

class NewCompaniesThisYear extends WidgetTableCard
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        parent::__construct(
            title: __('dashboard.new_companies_this_year'),
            headers: $this->getHeaders(),
            tableData: $this->getData(),
            columns: $this->getColumns(),
            icon: 'person-fill-add',
        );
    }

    private function getData() : array
    {
        return Company::select('id', 'name', 'created_at')
            ->whereYear('created_at', Carbon::now()->year)
            ->orderByDesc('created_at')
            ->limit(5)
            ->get()
            ->toArray();
    }

    private function getHeaders(): array
    {
        return [
            '#',
            __('companies.company_name'),
            __('messages.created'),
        ];
    }

    private function getColumns(): array
    {
        return [
            ['type' => 'counter'],
            [
                'field' => 'name',
                'type' => 'link',
                'route' => 'companies.show',
                'route_param' => 'id'
            ],
            [
                'field' => 'created_at',
                'type' => 'date',
                'format' => 'd.m.Y'
            ]
        ];
    }
}
