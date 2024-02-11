<?php

namespace App\Livewire\Customer;

use Exception;
use App\Models\Barang;
use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\DetailPenjualan;
use App\Models\HeaderPenjualan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

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
                'status' => 'CONFIRMED'
            ]);
        } else {
            session()->flash('error-top', 'stok tidak mencukupi silahkan hubungi admin');
        }
    }

    public function simpan()
    {
        $noInvoice = $this->generateNota();
        HeaderPenjualan::create([
            'user_id' => User::first()->id,
            'customer_id' => Auth::guard('customer')->user()->id,
            'no_invoice' => $noInvoice,
            'status' => 'CUSTOMER'
        ]);
        // menata collection sebelum looping
        $confirmedBarang = $this->dataPenjualan->where('status', 'CONFIRMED')
            ->map(function ($item) use ($noInvoice) {
                unset($item['id']);
                unset($item['nama_barang']);
                $item['no_invoice'] = $noInvoice;
                return $item;
            });
        $confirmedBarang->each(function ($item) {
            DetailPenjualan::create($item);
        });
        session()->flash('success-top', "Berhasil dibuat dengan no invoice {$noInvoice}");
        $this->dataPenjualan = collect();
    }

    public function cancel()
    {
        $this->dataPenjualan = collect();
    }

    public function hapus($id)
    {
        $this->dataPenjualan = $this->dataPenjualan->reject(function ($item) use ($id) {
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

    private function generateNota()
    {
        // String awal
        $stringAwal = HeaderPenjualan::select('no_invoice')->latest()->first()->no_invoice ?? 'P0000000';

        // Mengekstrak nomor dari string
        $nomor = intval(substr($stringAwal, 1)); // Mengabaikan huruf 'P'

        // Menambahkan 1 ke nomor
        $nomorBaru = $nomor + 1;

        // Memformat nomor baru dengan 7 digit
        $nomorFormat = sprintf('%07d', $nomorBaru);

        // Menyusun kembali string dengan huruf 'P' dan nomor yang diformat
        $stringBaru = "P" . $nomorFormat;
        return $stringBaru;
    }
}
