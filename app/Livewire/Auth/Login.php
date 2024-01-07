<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public $username;
    public $password;

    public function render()
    {
        return view('livewire.auth.login');
    }

    public function login(){
        $this->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if(Auth::attempt(['username' => $this->username, 'password' => $this->password])){
            return $this->redirect('/customer', true);
        }else{
            session()->flash('error', 'Username atau Password Salah');
            return $this->redirect('/', true);
        }
    }
}
