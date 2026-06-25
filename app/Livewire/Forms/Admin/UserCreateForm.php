<?php

namespace App\Livewire\Forms\Admin;

use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UserCreateForm extends Form
{
    #[Validate('required|string')]
    public $name;

    #[Validate('required|email|unique:users,email')]
    public $email;

    #[Validate('nullable|string|min:8|confirmed')]
    public $password;
    public $password_confirmation;

    public function save()
    {
        $this->validate();

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
        ]);

        $this->pull();
    }
}
