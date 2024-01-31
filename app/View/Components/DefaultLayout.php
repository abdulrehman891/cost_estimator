<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;

class DefaultLayout extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Init layout file
        app(config('settings.KT_THEME_BOOTSTRAP.default'))->init();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $all_unread_notifications = "";
        $total_unread_notifications = Auth::user()->unreadNotifications->where('data.reminder_date', date('Y-m-d'))->count();
        if ($total_unread_notifications > 0) {
            $all_unread_notifications = Auth::user()->unreadNotifications->where('data.reminder_date', date('Y-m-d'));
        }
        // See also starterkit/app/Core/Bootstrap/BootstrapDefault.php
        return view(config('settings.KT_THEME_LAYOUT_DIR') . '._default', compact('total_unread_notifications', 'all_unread_notifications'));
    }
}
