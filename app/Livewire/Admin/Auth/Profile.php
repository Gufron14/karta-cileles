<?php

namespace App\Livewire\Admin\Auth;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

#[Title('Profil Admin')]
#[Layout('components.layouts.admin-layout')]
class Profile extends Component
{
    use WithFileUploads;

    public $name;
    public $email;
    public $phone;
    public $address;
    public $avatar;
    public $current_password;
    public $new_password;
    public $new_password_confirmation;
    public $showChangePassword = false;

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->address = $user->address;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'avatar' => 'nullable|image|max:2048', // 2MB max
        ];
    }

    public function passwordRules()
    {
        return [
            'current_password' => 'required|current_password',
            'new_password' => ['required', 'confirmed', Password::min(8)],
            'new_password_confirmation' => 'required',
        ];
    }

    public function updateProfile()
    {
        $this->validate();

        $user = Auth::user();
        
        // Handle avatar upload
        if ($this->avatar) {
            // Delete old avatar if exists
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            
            $avatarPath = $this->avatar->store('avatars', 'public');
        } else {
            $avatarPath = $user->avatar;
        }

        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'avatar' => $avatarPath,
        ]);

        $this->avatar = null;
        session()->flash('success', 'Profil berhasil diperbarui!');
    }

    public function changePassword()
    {
        $this->validate($this->passwordRules());

        Auth::user()->update([
            'password' => Hash::make($this->new_password)
        ]);

        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);
        $this->showChangePassword = false;
        
        session()->flash('success', 'Password berhasil diubah!');
    }

    public function toggleChangePassword()
    {
        $this->showChangePassword = !$this->showChangePassword;
        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);
    }

    public function render()
    {
        return view('livewire.admin.auth.profile');
    }
}
