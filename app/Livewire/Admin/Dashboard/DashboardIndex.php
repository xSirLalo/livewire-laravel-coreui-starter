<?php

namespace App\Livewire\Admin\Dashboard;

use Livewire\Component;

class DashboardIndex extends Component
{
    public $module_name = 'dashboard';

    public function render()
    {
        return view('livewire.admin.dashboard.dashboard-index');
    }
}
