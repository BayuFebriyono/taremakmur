<?php

namespace App\Livewire\Admin\Transaksi\Pembelian;

use App\Models\Pembelian;
use App\Models\Suplier;
use Livewire\Component;

class AddPembelian extends Component
{
    // utils
    public $pembelians;
    public $showModal = false;
    public $supliers;
    public $serachSuplier = '';

    public function mount()
    {
        $this->pembelians = Pembelian::where('status', 'WAITING')
            ->with('kode_barang')
            ->get();

        $this->supliers = Suplier::all();
    }
    public function render()
    {
        return view('livewire.admin.transaksi.pembelian.add-pembelian');
    }

    public function filterSuplier()
    {
        $this->supliers = Suplier::where('nama', 'like', '%' . $this->serachSuplier . '%')->get();
    }

    public function add()
    {
        $this->showModal = true;
    }

    public function cancel()
    {
        $this->showModal = false;
    }
}
