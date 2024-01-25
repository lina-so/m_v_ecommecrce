<?php

namespace App\View\Components\nav;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;

class SidebarNavAdmin extends Component
{
    public $items , $active;
    public function __construct()
    {
        $this->items = config('sidebarAdmin');
        $this->active = Route::currentRouteName();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.nav.sidebar-nav-admin');
    }
}
