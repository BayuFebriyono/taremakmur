<?php

namespace App\Livewire\Admin\MasterData;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.sidebar')]
class Customer extends Component
{
    public function render()
    {
        return view('livewire.admin.master-data.customer');
    }
}
