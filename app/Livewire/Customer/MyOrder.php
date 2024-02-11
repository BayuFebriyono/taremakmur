<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\HeaderPenjualan;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.customer')]
#[Title('My Order')]
class MyOrder extends Component
{
    public $perPage = 10;
    public $search = '';
    public function render()
    {
        $penjualans = HeaderPenjualan::with('customer')
            ->where('no_invoice', 'like', '%' . $this->search . '%')
            ->where('customer_id', Auth::guard('customer')->user()->id)
            ->latest()->paginate($this->perPage);
        return view('livewire.customer.my-order', ['penjualans'=> $penjualans]);
    }
}
