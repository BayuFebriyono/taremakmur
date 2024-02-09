<?php

namespace App\Livewire\Admin\Penjualan;

use App\Models\Barang;
use Exception;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.sidebar')]
#[Title('Penjualan')]
class Invoice extends Component
{

    public $showForm = false;
    public $customers = [];
    public $customerId;
    public $aktualId = '';
    public $remarkId = '';
    public $barang;
    public $jenis = 'dus';

    public $kodeBarang;
    public $hargaSatuan = 0;
    public $harga = 0;
    public $qty = 0;
    public $diskon = 0;


    public function render()
    {
        if ($this->barang) {
            $this->hargaSatuan = $this->jenis == 'dus' ? $this->barang->cash_dus : $this->barang->cash_pack;
            $this->harga = ((integer)$this->hargaSatuan * (integer)$this->qty) - (integer)$this->diskon;
            if($this->harga < 0) $this->harga = 0;

        }
        return view('livewire.admin.penjualan.invoice');
    }

    public function add()
    {
        $this->showForm = true;
    }

    public function cariBarang()
    {
        try {
            $this->barang = Barang::where('kode_barang', $this->kodeBarang)->first();
        } catch (Exception $e) {
            $this->barang = collect();
        }
    }
}
