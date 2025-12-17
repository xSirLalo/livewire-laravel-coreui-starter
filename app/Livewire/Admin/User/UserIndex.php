<?php

namespace App\Livewire\Admin\User;

use App\Traits\HasBreadcrumb;
use Livewire\Component;

class UserIndex extends Component
{
    use HasBreadcrumb;

    public $module_name = 'user';
    public $module_name_plural = 'users';
    public $module_icon = 'fas fa-users';
    public $module_action = 'List';

    public function render()
    {
        return view('livewire.admin.user.user-index');
    }
}
