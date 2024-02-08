<?php

namespace App\Livewire\Admin\Pembelian;

use App\Models\Barang;
use Exception;
use Livewire\Attributes\Layout;
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

    public $namaBarang;
    public $kodeBarang;
    public $diskon;
    public $qty;
    public $harga;
    public $aktual;
    public $remark;

    public function mount()
    {
        $this->dataPembelian = collect();
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
        $this->dataPembelian->push([
            'id' => uniqid(),
            'kode_barang' => $this->kodeBarang,
            'nama_barang' => $this->namaBarang,
            'qty' => $this->qty,
            'aktual' => $this->qty,
            'harga' => $this->harga,
            'diskon' => $this->diskon,
            'remark' => null,
            'status' => 'WAITING'
        ]);
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
        try {
            $this->namaBarang = Barang::where('kode_barang', $this->kodeBarang)->first()->nama_barang;
        } catch (Exception $e) {
            $this->namaBarang = '';
        }
    }
}
