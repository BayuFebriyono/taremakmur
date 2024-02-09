<?php

namespace App\Livewire\Admin\Pembelian;

use App\Models\HeaderPembelian;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.sidebar')]
#[Title('History Pembelian')]
class History extends Component
{
    use WithPagination;
    public $perPage = 10;
    public $search ='';

    public function render()
    {
        $pembelians = HeaderPembelian::with(['user', 'suplier'])->latest()->paginate($this->perPage);
        return view('livewire.admin.pembelian.history',[
            'pembelians' => $pembelians
        ]);
    }
}
