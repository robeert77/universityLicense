<?php

namespace App\View\Components\Dashboard;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class WidgetCard extends Component
{
    public string $title;
    public string $subtitle;
    public string|int $value;
    public string $icon;
    public string $color;

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $title,
        string|int $value,
        string $subtitle = '',
        string $icon = 'wrench',
        string $color = 'primary',
    ) {
        $this->title = $title;
        $this->subtitle = $subtitle;
        $this->value = $value;
        $this->icon = $icon;
        $this->color = $color;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dashboard.widget-card');
    }
}
