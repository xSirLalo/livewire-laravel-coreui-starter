<?php

namespace App\Livewire\Admin\User;

use App\Models\User;
use App\Traits\HasBreadcrumb;
use Livewire\Component;

class UserShow extends Component
{
    use HasBreadcrumb;

    public $module_name = 'user';
    public $module_name_plural = 'users';
    public $module_icon = 'fas fa-cube';
    public $module_action = 'Detail';
    public $module_model;

    public function mount($id)
    {
        $this->module_model = User::find($id);
    }

    public function render()
    {
        return view('livewire.admin.user.user-show');
    }
}
