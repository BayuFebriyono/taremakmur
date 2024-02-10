<?php

namespace App\Livewire\Admin\Pembelian;

use App\Models\Barang;
use App\Models\DetailPembelian;
use App\Models\HeaderPembelian;
use App\Models\Report;
use App\Models\Suplier;
use Exception;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.sidebar')]
#[Title('Invoice Pembelian')]
class Invoice extends Component
{
    public $showForm = false;
    public $dataPembelian;
    public $aktualId = '';
    public $remarkId = '';
    public $supliers = [];
    public $namaSuplier = '';
    public $noInvoice = '';
    public $barangs = [];
    public $cariBarang = '';
    public $barang;


    public $namaBarang;
    public $kodeBarang = '';
    public $diskon = 0;
    public $qty;
    public $harga;
    public $aktual;
    public $remark;
    public $suplierId;

    public function mount()
    {
        $this->dataPembelian = collect();
        $this->supliers = Suplier::all();
        $this->barangs = Barang::all();
    }

    public function render()
    {
        
        return view('livewire.admin.pembelian.invoice');
    }

    public function add()
    {
        $this->showForm = true;
    }

    public function addBarang()
    {
        $this->validate([
            'kodeBarang' => 'required'
        ]);

        $this->dataPembelian->push([
            'id' => uniqid(),
            'kode_barang' => $this->kodeBarang,
            'nama_barang' => $this->barang->nama_barang,
            'qty' => $this->qty,
            'aktual' => $this->qty,
            'harga' => $this->harga,
            'diskon' => $this->diskon,
            'remark' => null,
            'status' => 'WAITING'
        ]);
    }

    public function simpan()
    {
        $this->validate([
            'suplierId' => 'required'
        ]);

        if ($this->dataPembelian->count() > 0) {
            $no = HeaderPembelian::where('suplier_id', $this->suplierId)->latest()->first() ?? 0;
            $arrno = explode('/', $no->no_invoice);
            $no = $arrno[0];
            $noInvoice = (int)$no + 1 . '/' .  Suplier::find($this->suplierId)->nama . '/' . now()->isoFormat('MM') . '/' . now()->isoFormat('YY');
            HeaderPembelian::create([
                'user_id' => auth()->user()->id,
                'suplier_id' => $this->suplierId,
                'no_invoice' => $noInvoice
            ]);

            // Menata collection sebelum di looping
            $confirmedBarang = $this->dataPembelian->where('status', 'CONFIRMED')
                ->map(function ($item) use ($noInvoice) {
                    unset($item['id']);
                    unset($item['nama_barang']);
                    $item['no_invoice'] = $noInvoice;
                    return $item;
                });
            // looping update ke database
            $confirmedBarang->each(function ($item) {
                $barang = Barang::where('kode_barang', $item['kode_barang'])->first();
                // $barang->update([
                //     'stock_renteng' => $barang->stock_renteng + ($item['qty'] * $barang->jumlah_renteng)
                // ]);
                DetailPembelian::create($item);
                // Report::create([
                //     'kode_barang' => $item['kode_barang'],
                //     'in' => $item['qty'] * $barang->jumlah_renteng,
                //     'harga' => $item['harga'],
                //     'stock' => $barang->stock_sto
                // ]);
            });
            session()->flash('success-top', "Berhasil dibuat dengan no invoice {$noInvoice}");
            $this->showForm = false;
            $this->dataPembelian = collect();
        } else {
            session()->flash('error', 'Tambahkan barang terlebih dulu');
        }
    }

    public function cancel()
    {
        $this->showForm = false;
    }

    public function confirmed($id)
    {
        $this->dataPembelian->transform(function ($item, $key) use ($id) {
            if ($item['id'] === $id) $item['status'] = 'CONFIRMED';

            return $item;
        });
    }

    public function confirmAll()
    {
        $this->dataPembelian->transform(function ($item, $key) {
            $item['status'] = 'CONFIRMED';
            return $item;
        });
    }

    public function waiting($id)
    {
        $this->dataPembelian->transform(function ($item, $key) use ($id) {
            if ($item['id'] === $id) $item['status'] = 'WAITING';
            return $item;
        });
    }

    public function showAktual($id)
    {
        $this->aktualId = $id;
    }

    public function updateAktual()
    {
        $this->dataPembelian->transform(function ($item, $key) {
            if ($item['id'] === $this->aktualId) $item['aktual'] = $this->aktual;
            return $item;
        });

        $this->aktualId = '';
    }

    public function cancelAktual()
    {
        $this->aktualId = '';
    }

    public function showRemark($id)
    {
        $this->remarkId = $id;
    }

    public function updateRemark()
    {
        $this->dataPembelian->transform(function ($item, $key) {
            if ($item['id'] === $this->remarkId) $item['remark'] = $this->remark;
            return $item;
        });

        $this->remarkId = '';
    }

    public function cancelRemark()
    {
        $this->remarkId = '';
    }

    public function searchBarang()
    {
        $this->barangs = Barang::where('nama_barang', 'like', '%' . $this->cariBarang . '%')->get();
    }

    #[On('set-invoice')]
    public function setNoInvoice($noInvoice)
    {
        $this->noInvoice = $noInvoice;
    }

    public function cariSuplier()
    {
        $this->supliers = Suplier::where('nama', 'like', '%' . $this->namaSuplier . '%')->get();
    }

    public function pilihBarang()
    {
        try{
            $this->barang = Barang::where('kode_barang', $this->kodeBarang)->first();
            $this->harga = $this->barang->harga_beli_dus;
        }catch(Exception $e){
            $this->barang = collect();
        }
    }
}
