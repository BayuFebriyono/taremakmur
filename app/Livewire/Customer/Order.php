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
    public $dataPenjualan;

    public function mount()
    {
        $this->barangs = Barang::all();
        $this->barang = collect();
        $this->dataPenjualan = collect();
    }
    public function render()
    {
        return view('livewire.customer.order');
    }

    public function addBarang()
    {
        $this->validate([
            'barang' => 'required'
        ]);

        // cek stock dulu
        if ($this->cekStock()) {
            $this->dataPenjualan->push([
                'id' => uniqid(),
                'kode_barang' => $this->barang->kode_barang,
                'nama_barang' => $this->barang->nama_barang,
                'jenis' => $this->jenisPembelian,
                'qty' => $this->qty,
                'aktual' => $this->qty,
                'harga_satuan' => $this->hargaSatuan,
                'harga' => $this->harga,
                'diskon' => $this->barang->diskon ?? 0,
                'remark' => null,
                'status' => 'CUSTOMER'
            ]);
        } else {
            session()->flash('error-top', 'stok tidak mencukupi silahkan hubungi admin');
        }
    }

    public function hapus($id)
    {
        $this->dataPenjualan = $this->dataPenjualan->reject(function ($item) use($id){
            return $item['id'] == $id;
        });
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

            $this->harga = ((int)$this->qty * (int)$this->hargaSatuan) - (int)$this->barang->diskon;
        } catch (Exception $e) {
            $this->harga = 0;
            $this->hargaSatuan = 0;
        }
    }

    private function cekStock(): bool
    {
        if ($this->jenisPembelian == 'dus') {
            $jumlah = (int)$this->barang->jumlah_renteng * (int)$this->qty;

            if ($this->barang->stock_renteng < $jumlah) return false;
            return true;
        } else {
            if ($this->barang->stock_renteng < $this->qty) return false;
            return true;
        }
    }
}
