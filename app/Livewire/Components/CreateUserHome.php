<?php

namespace App\Livewire\Components;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreateUserHome extends Component
{

    #[Validate('required|min:6|unique:users,name')]
    public $name = '';
    #[Validate('required|email|unique:users,email')]
    public $email = '';
    #[Validate('required|min:5')]
    public $password = '';


    public function render()
    {
        return view('livewire.components.create-user-home');
    }

    public function store()
    {
        $this->validate();

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt($this->password),
            'role' => RoleEnum::PENGAWAS
        ]);

        $this->dispatch('success-notif', message: 'User berhasil ditambahkan silahkan login');


        if (Auth::attempt([
            'email' => $this->email,
            'password' => $this->password
        ])) {
            $this->name = '';
            $this->email = '';
            $this->password = '';
            return redirect()->intended('/admin');
        } else {
            $this->dispatch('error-notif', message: 'Gagal login, silahkan coba login secara manual');
        }
    }
}
