<?php

namespace App\Livewire\Customer;

use App\Models\Barang;
use Exception;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.customer')]
#[Title('Order Page')]
class Order extends Component
{
    public $barangs = [];
    public $harga = 0;
    public $hargaSatuan = 0;
    public $keywordBarang = '';
    public $jenisPembelian = 'dus';
    public $metodePembayaran = 'cash';
    public $barang;
    public $kodeBarang;
    public $qty = 0;

    public function mount()
    {
        $this->barangs = Barang::all();
        $this->barang = collect();
    }
    public function render()
    {
        return view('livewire.customer.order');
    }

    public function cariBarang()
    {
        $this->barangs =  Barang::where('nama_barang', 'like', '%' . $this->keywordBarang . '%')->get();
    }

    public function pilihBarang()
    {
        $this->barang = Barang::where('kode_barang', $this->kodeBarang)->first();
        $this->setHarga();
    }

    public function setHarga()
    {
        try {
            if ($this->jenisPembelian == 'dus') {
                $this->hargaSatuan = $this->metodePembayaran == 'cash' ? $this->barang->cash_dus : $this->barang->kredit_dus;
            } else {
                $this->hargaSatuan = $this->metodePembayaran == 'cash' ? $this->barang->cash_pack : $this->barang->kredit_pack;
            }

            $this->harga = (int)$this->qty * (int)$this->hargaSatuan;
        } catch (Exception $e) {
            $this->harga = 0;
            $this->hargaSatuan = 0;
        }
    }
}
