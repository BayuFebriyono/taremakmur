<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Logout extends Component
{
    public function render()
    {
        return <<<'HTML'
        <div>
        <li class="nav-item">
            <span role="button" wire:click="logout" class="nav-link">
                <i class="mdi mdi-exit-to-app"></i>
                <span class="menu-title">Logout</span>
            </span>
        </li>
        </div>
        HTML;
    }

    public function logout(){
        Auth::logout();
        Auth::guard('customer')->logout();
        return $this->redirect('/', true);
    }
}
