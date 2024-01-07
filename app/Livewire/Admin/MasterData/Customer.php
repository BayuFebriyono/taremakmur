<?php

namespace App\Livewire\Admin\MasterData;

use App\Models\Customer as ModelsCustomer;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.sidebar')]
#[Title('Master Data Customer')]
class Customer extends Component
{
    use WithPagination;

    public $active = 'customer';
    public $search = '';
    public function render()
    {
        $customers = ModelsCustomer::where('nama', 'like', '%'.$this->search.'%')
            ->orWhere('alamat', 'like', '%' . $this->search . '%')
            ->paginate(10);

        return view('livewire.admin.master-data.customer',[
            'customers' => $customers
        ]);
    }
}
