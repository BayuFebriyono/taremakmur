<?php

namespace App\Livewire\Customer;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.customer')]
#[Title('Order Page')]
class Order extends Component
{
    public function render()
    {
        return view('livewire.customer.order');
    }
}
