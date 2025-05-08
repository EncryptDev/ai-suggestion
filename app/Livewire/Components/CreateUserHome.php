<?php

namespace App\Livewire\Components;

use App\Enums\RoleEnum;
use App\Models\User;
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

    public function store(){
        $this->validate();

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt($this->password),
            'role' => RoleEnum::PENGAWAS
        ]);
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->dispatch('success-notif', message: 'User berhasil ditambahkan silahkan login');
    }
}
