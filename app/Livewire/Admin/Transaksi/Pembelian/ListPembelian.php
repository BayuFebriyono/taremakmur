<?php

namespace App\Livewire\Admin\Transaksi\Pembelian;

use App\Models\Pembelian;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ListPembelian extends Component
{
    use WithPagination;

   
    public $perPage = 10;

  
    #[On('saved')]
    public function render()
    {
        return view('livewire.admin.transaksi.pembelian.list-pembelian',[
            'pembelians' => Pembelian::with(['barang', 'suplier'])->latest()->paginate($this->perPage)
        ]);
    }
}
