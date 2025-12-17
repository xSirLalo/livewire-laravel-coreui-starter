<?php

namespace App\Livewire\Admin\Profile;

use App\Models\User;
use App\Traits\HasBreadcrumb;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProfileEdit extends Component
{
    use HasBreadcrumb;
    use WithFileUploads;

    public $module_name = 'profile';
    public $module_action = 'Edit';

    // Profile Information
    public string $name = '';
    public string $email = '';
    public $photo;

    // Password Update
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    // Delete Account
    public string $delete_password = '';
    public bool $showDeleteModal = false;

    // Status messages
    public string $profileStatus = '';
    public string $passwordStatus = '';

    public function mount(): void
    {
        $admin = Auth::user();
        $this->name = $admin->name;
        $this->email = $admin->email;
    }

    public function updateProfileInformation(): void
    {
        $admin = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($admin->id),
            ],
            'photo' => ['nullable', 'image', 'max:10240'], // 10MB Max
        ]);

        if ($this->photo) {
            $admin->updateProfilePhoto($this->photo);
        }

        $admin->fill($validated);

        if ($admin->isDirty('email')) {
            $admin->email_verified_at = null;
        }

        $admin->save();

        // Reset photo after saving
        $this->reset('photo');

        $this->profileStatus = 'profile-updated';
        $this->dispatch('saved');
    }

    public function deleteProfilePhoto(): void
    {
        $admin = Auth::user();
        $admin->deleteProfilePhoto();

        $this->dispatch('saved');
    }

    public function sendEmailVerification(): void
    {
        $admin = Auth::user();

        if ($admin->hasVerifiedEmail()) {
            $this->redirect(route('admin.profile.edit'));

            return;
        }

        $admin->sendEmailVerificationNotification();

        session()->flash('status', 'verification-link-sent');
    }

    public function updatePassword(): void
    {
        $validated = $this->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
            'password_confirmation' => ['required'],
        ]);

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        $this->reset(['current_password', 'password', 'password_confirmation']);
        $this->passwordStatus = 'password-updated';
    }

    public function openDeleteModal(): void
    {
        $this->showDeleteModal = true;
        $this->delete_password = '';
    }

    public function closeDeleteModal(): void
    {
        $this->showDeleteModal = false;
        $this->delete_password = '';
        $this->resetErrorBag('delete_password');
    }

    public function deleteAccount(): void
    {
        $this->validate([
            'delete_password' => ['required', 'current_password'],
        ]);

        $admin = Auth::user();

        Auth::logout();

        $admin->delete();

        session()->invalidate();
        session()->regenerateToken();

        $this->redirect('/');
    }

    public function render()
    {
        return view('livewire.admin.profile.profile-edit');
    }
}
