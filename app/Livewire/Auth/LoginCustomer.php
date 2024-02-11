<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LoginCustomer extends Component
{
    public $name;
    public $password;

    public function render()
    {
        return view('livewire.auth.login-customer');
    }

    public function login(){
        $this->validate([
            'name' => 'required',
            'password' => 'required'
        ]);

        Auth::logout();
        if(Auth::guard('customer')->attempt(['nama' => $this->name, 'password' => $this->password])){
            return $this->redirect('/customer-order', true);
        }else{
            session()->flash('error', 'Nama atau password salah');
            return $this->redirect('/login-customer', true);
        }
    }
}
