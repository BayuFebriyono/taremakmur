<?php

namespace App\Livewire\Admin;

use App\Models\Barang;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.sidebar')]
#[Title('Stok Barang')]
class StockBarang extends Component
{
    public $search = '';
    public function render()
    {
        $barangs = Barang::where('nama_barang', 'like', '%' . $this->search.'%')->get();
        return view('livewire.admin.stock-barang', [
            'barangs' => $barangs
        ]);
    }
}
