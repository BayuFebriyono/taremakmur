<?php

namespace App\Livewire\Admin\Transaksi\Pembelian;

use App\Models\Barang;
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
    public $namaBarang = '';

    // Props addPembelian
    public $suplierId;
    public $noInvoice;
    public $kodeBarang;
    public $quantity;
    public $harga;
    public $diskon;


    public function mount()
    {


        $this->supliers = Suplier::all();

        $this->noInvoice = uniqid();
    }
    public function render()
    {
        $this->pembelians = Pembelian::where('status', 'WAITING')
            ->with(['barang', 'suplier'])
            ->get();
            // dd($this->pembelians);
        return view('livewire.admin.transaksi.pembelian.add-pembelian');
    }

    public function store()
    {
        $this->validate([
            'namaBarang' => 'required',
            'diskon' => 'numeric'
        ]);

        Pembelian::create([
            'suplier_id' => $this->suplierId,
            'no_invoice' => $this->noInvoice,
            'kode_barang' => $this->kodeBarang,
            'qty' => $this->quantity,
            'harga' => $this->harga,
            'diskon' => $this->diskon
        ]);
        $this->resetFields();
        session()->flash('success', 'Pembelian dicatat');
    }

    public function changeNamaBarang()
    {
        $this->namaBarang = Barang::select('nama_barang')->where('kode_barang', $this->kodeBarang)->first()->nama_barang;
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

    public function resetFields()
    {
        $this->suplierId = null;
        $this->noInvoice = uniqid();
        $this->kodeBarang = '';
        $this->quantity = null;
        $this->harga = null;
        $this->diskon = null;
    }
}
