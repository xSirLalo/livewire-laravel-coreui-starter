<?php

namespace App\Livewire\Admin\User;

use App\Livewire\Forms\Admin\UserEditForm;
use App\Traits\HasBreadcrumb;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;
use ZxcvbnPhp\Zxcvbn;

class UserEdit extends Component
{
    use HasBreadcrumb;

    public $module_name = 'user';
    public $module_name_plural = 'users';
    public $module_icon = 'fas fa-users';
    public $module_action = 'Edit';
    public UserEditForm $form;

    public int $strengthScore = 0;
    public array $strengthLevels = [
        1 => 'Weak',
        2 => 'Fair',
        3 => 'Good',
        4 => 'Strong',
    ];

    public function updatedPassword($value)
    {
        $password = $value ?? '';
        $this->strengthScore = (new Zxcvbn())->passwordStrength($password)['score'];
    }

    public function updatePassword()
    {
        $this->updatedPassword($this->form->password);
    }

    public function generatePassword()
    {
        $password = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 10);
        $this->form->password = $password;
        $this->form->password_confirmation = $password;
        $this->updatedPassword($password);
    }

    public function update()
    {
        $this->form->save();
        session()->flash('success_message', trans_choice(
            '{0} ¡El :resource fue actualizado!|{1} ¡La :resource fue actualizada!',
            1,
            ['resource' => __(ucwords($this->module_name))]
        ));
        $this->redirect(UserIndex::class);
    }

    public function delete($id)
    {
        LivewireAlert::title(__('Are you sure?'))
            ->warning()
            ->withConfirmButton(__('Yes, Delete'))
            ->withCancelButton(__('Cancel'))
            ->onConfirm('deleteConfirmed', ['idToDelete' => $id])
            ->show();
    }

    public function deleteConfirmed($data)
    {
        $this->form->destroy($data['idToDelete']);
        $this->redirect(UserIndex::class);
    }

    public function mount($id)
    {
        $this->form->loadData($id);
    }

    public function render()
    {
        return view('livewire.admin.user.user-edit');
    }
}
