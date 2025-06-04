<?php

namespace App\View\Components\Dashboard;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class WidgetTableCard extends Component
{
    public string $title;
    public array $headers;
    public array $tableData;
    public array $columns;
    public string $icon;
    public string $color;

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $title,
        array $headers,
        array $tableData,
        array $columns,
        string $icon = 'table',
        string $color = 'info',
    ) {
        $this->title = $title;
        $this->headers = $headers;
        $this->tableData = $tableData;
        $this->columns = $columns;
        $this->icon = $icon;
        $this->color = $color;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dashboard.widget-table-card');
    }
}
