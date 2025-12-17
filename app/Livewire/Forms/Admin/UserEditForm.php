<?php

namespace App\Livewire\Forms\Admin;

use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UserEditForm extends Form
{
    public $id;

    #[Validate('required|string')]
    public $name;

    #[Validate('required|string')]
    public $email;

    #[Validate('nullable|string|min:8|confirmed')]
    public $password;
    public $password_confirmation;

    public function loadData($id)
    {
        $module_model = User::findOrFail($id);

        $this->id = $module_model->id;
        $this->name = $module_model->name;
        $this->email = $module_model->email;
    }

    public function save()
    {
        $this->validate();

        $module_model = User::findOrFail($this->id);

        $data = [
            'name' => $this->name,
            'email' => $this->email,
        ];

        if (!empty($this->password)) {
            $data['password'] = $this->password;
        }

        $module_model->update($data);

        $this->pull();
    }

    public function destroy($id)
    {
        $module_model = User::findOrFail($id);
        $module_model->delete();
    }
}
