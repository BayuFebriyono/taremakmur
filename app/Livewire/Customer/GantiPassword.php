<?php

namespace App\Livewire\Customer;

use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.customer')]
#[Title('Ganti Password')]
class GantiPassword extends Component
{
    public $passwordLama;
    public $passwordBaru;

    public function render()
    {
        return view('livewire.customer.ganti-password');
    }

    public function gantiPassword()
    {
       
        if (Hash::check($this->passwordLama, Auth::guard('customer')->user()->password)) {

            Customer::find(Auth::guard('customer')->user()->id)->update([
                'password' => bcrypt($this->passwordBaru)
            ]);
            session()->flash('success', 'Password berhasil diganti');
        }else{
            session()->flash('error', 'Password Lama salah');
        }
    }
}
