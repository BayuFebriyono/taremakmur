<?php

namespace App\Livewire\Admin\Transaksi\Penjualan;

use App\Models\Barang;
use App\Models\Penjualan;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class AddPenjualan extends Component
{

    // utils
    public $showModal = false;
    public $namaBarang = '';
    public $barang;
    public $excel = false;
    // update utils
    public $remarkId;
    public $remark;
    public $aktualId;
    public $aktual;


    // Property Model Penjualan
    public $noNota;
    public $kodeBarang;
    public $quantity;
    public $harga;
    public $diskon;
    public $toko;

    public function mount()
    {
        $this->noNota = uniqid();
    }


    public function render()
    {
        return view('livewire.admin.transaksi.penjualan.add-penjualan', [
            'penjualans' => Penjualan::whereNot('status', 'SAVED')->get()
        ]);
    }

    public function store()
    {
        $this->validate([
            'namaBarang' => 'required',
            'noNota' => 'required',
            'kodeBarang' => 'required',
            'quantity' => 'required',
            'harga' => 'required',
            'diskon' => 'required',
            'toko' => 'required',
        ]);

        if ($this->cekStockBarang()) {
            Penjualan::create([
                'no_nota' => $this->noNota,
                'kode_barang' => $this->kodeBarang,
                'qty' => $this->quantity,
                'aktual' => $this->quantity,
                'harga' => $this->harga,
                'diskon' => $this->diskon,
                'toko' => $this->toko
            ]);

            // update balance barang
            // Barang::where('kode_barang', $this->kodeBarang)->update([
            //     'balance' => DB::raw('balance - ' . $this->quantity)
            // ]);

            session()->flash('success', 'Data berhasil ditambahkan');
        } else {
            session()->flash('error', 'Stock barang kurang');
        }
    }

    public function confirm($id)
    {
        Penjualan::find($id)
            ->update([
                'status' => 'CONFIRMED'
            ]);
    }

    public function confirmAll()
    {
        Penjualan::whereNot('status', 'SAVED')->update([
            'status' => 'CONFIRMED'
        ]);
    }

    public function save()
    {
        // update balance
        $penjualans = Penjualan::where('status', 'CONFIRMED')->get();
        foreach ($penjualans as $penjualan) {
            Barang::where('kode_barang', $penjualan->kode_barang)->update([
                'balance' => DB::raw('balance - ' . $penjualan->aktual)
            ]);
        }
        // update yang confirmed
        Penjualan::whereIn('id', $penjualans->pluck('id'))->update([
            'status' => 'SAVED'
        ]);
        // delete waiting
        Penjualan::where('status', 'WAITING')->delete();
        $this->dispatch('saved')->to(ListPenjualan::class);
    }

    public function waiting($id)
    {
        Penjualan::find($id)->update([
            'status' => 'WAITING'
        ]);
    }

    public function delete()
    {
        Penjualan::whereNot('status', 'SAVED')->delete();
    }

    public function cekBarang()
    {
        $barang = Barang::where('kode_barang', $this->kodeBarang)
            ->first();
        $this->barang = $barang;
        $this->namaBarang = $barang->nama_barang ?? '';
    }

    public function addRemark($id)
    {
        $this->remarkId = $id;
    }

    public function saveRemark()
    {
        Penjualan::find($this->remarkId)->update([
            'remark' => $this->remark
        ]);

        $this->remarkId = null;
    }

    public function saveAktual()
    {
        Penjualan::find($this->aktualId)->update([
            'aktual' => $this->aktual
        ]);

        $this->aktualId = null;
    }

    public function addAktual($id)
    {
        $this->aktualId = $id;
    }

    public function add()
    {
        $this->showModal = true;
    }

    public function cancel()
    {
        $this->showModal = false;
    }

    public function addExcel()
    {
        $this->excel = true;
    }

    #[On('cancel-excel')]
    public function cancelExcel($message = '', $type='success')
    {
        $this->excel = false;
        if($message){
            session()->flash($type, $message);
        }
    }

    private function cekStockBarang(): bool
    {
        $stockBarang = Barang::select('balance')->where('kode_barang', $this->kodeBarang)->first();

        if ($stockBarang->balance >= $this->quantity) return true;
        return false;
    }
}
