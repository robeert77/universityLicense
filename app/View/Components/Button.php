<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Button extends Component
{
    public string $type;
    public string $color;
    public bool $outline;

    /**
     * Create a new component instance.
     */
    public function __construct(string $type = 'submit', string $color = '', bool $outline = false)
    {
        $this->type = $type;
        $this->color = $color;
        $this->outline = $outline;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.button');
    }
}
