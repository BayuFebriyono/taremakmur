<?php

namespace App\Livewire\Admin\Transaksi\Pembelian;

use App\Models\Barang;
use App\Models\Pembelian;
use App\Models\Suplier;
use Livewire\Attributes\On;
use Livewire\Component;

class AddPembelian extends Component
{
    // utils
    public $pembelians;
    public $showModal = false;
    public $supliers;
    public $serachSuplier = '';
    public $namaBarang = '';
    public $excel = false;
    // Remark Utils;
    public $showRemarkId = '';
    public $remark;
    // Aktual Utils
    public $showAktualId = '';
    public $aktual;


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
        $this->pembelians = Pembelian::whereNot('status', 'SAVED')
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
            'aktual' => $this->quantity,
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

    public function showRemark($id)
    {
        $this->showRemarkId = $id;
    }

    public function saveRemark()
    {
        Pembelian::find($this->showRemarkId)->update([
            'remark' => $this->remark
        ]);
        $this->showRemarkId = '';
    }

    public function showExcel()
    {

        $this->excel = true;
    }

    #[On('cancel-excel')]
    public function cancelExcel($message = '')
    {
        $this->excel = false;
        if ($message) {
            session()->flash('success', $message);
        }
    }

    public function showAktual($id)
    {
        $this->showAktualId = $id;
    }

    public function saveAktual()
    {
        Pembelian::find($this->showAktualId)->update([
            'aktual' => $this->aktual
        ]);

        $this->showAktualId = '';
    }

    public function confirmed($id)
    {
        Pembelian::find($id)->update([
            'status' => 'CONFIRMED'
        ]);
    }

    public function confirmAll()
    {
        Pembelian::whereIn('id', $this->pembelians->pluck('id')->toArray())
            ->update([
                'status' => 'CONFIRMED'
            ]);
    }

    public function save()
    {
        // Update balance(stock) barang
        $pembelians = $this->pembelians->where('status', 'CONFIRMED');
        foreach ($pembelians as $pembelian) {
            $barang = Barang::where('kode_barang', $pembelian->kode_barang)->first();
            $barang->update([
                'balance' => $barang->balance += $pembelian->aktual
            ]);
        }

        // Update status saved ke DB
        Pembelian::where('status', 'CONFIRMED')
            ->update([
                'status' => 'SAVED'
            ]);
    }

    public function delete()
    {
        Pembelian::whereIn('id', $this->pembelians->pluck('id')->toArray())
            ->delete();
    }

    public function waiting($id)
    {
        Pembelian::find($id)->update([
            'status' => 'WAITING'
        ]);
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
