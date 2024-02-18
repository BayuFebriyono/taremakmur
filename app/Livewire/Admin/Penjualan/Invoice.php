<?php

namespace App\Livewire\Admin\Penjualan;

use Exception;
use App\Models\Barang;
use App\Models\Report;
use Livewire\Component;
use App\Models\Customer;
use Livewire\Attributes\Title;
use App\Models\DetailPenjualan;
use App\Models\HeaderPenjualan;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

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
    public $dataPenjualan;
    public $namaCustomer = '';
    public $barangs = [];
    public $namaBarang = '';
    public $noInvoice = '';
    public $isEdit = false;

    public $kodeBarang;
    public $hargaSatuan = 0;
    public $harga = 0;
    public $qty = 0;
    public $diskon = 0;
    public $remark;
    public $aktual;


    public function mount()
    {
        $this->dataPenjualan = collect();
        $this->customers = Customer::all();
        $this->barangs = Barang::all();
    }

    public function render()
    {

        return view('livewire.admin.penjualan.invoice');
    }

    public function add()
    {
        $this->showForm = true;
    }

    public function store()
    {
        $this->validate([
            'barang' => 'required'
        ]);

        // cek stock dulu
        if ($this->cekStock()) {
            $this->dataPenjualan->push([
                'id' => uniqid(),
                'kode_barang' => $this->kodeBarang,
                'nama_barang' => $this->barang->nama_barang,
                'jenis' => $this->jenis,
                'qty' => $this->qty,
                'aktual' => $this->qty,
                'harga_satuan' => $this->hargaSatuan,
                'harga' => $this->harga,
                'diskon' => $this->diskon,
                'remark' => null,
                'status' => 'WAITING'
            ]);
        } else {
            session()->flash('error-top', 'stok tidak mencukupi');
        }
    }

    public function simpan()
    {
        $this->validate([
            'customerId' => 'required'
        ]);

        if ($this->dataPenjualan->count() > 0) {

            $noInvoice = $this->generateNota();
            HeaderPenjualan::create([
                'user_id' => auth()->user()->id,
                'customer_id' => $this->customerId,
                'no_invoice' => $noInvoice,
                'status' => 'WAITING'
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
                $barang = Barang::where('kode_barang', $item['kode_barang'])->first();
                if ($this->jenis == 'dus') {
                    $barang->update([
                        'stock_bayangan' => $barang->stock_bayangan - ($item['qty'] * $barang->jumlah_renteng)
                    ]);
                } else {
                    $barang->update([
                        'stock_bayangan' => $barang->stock_bayangan - ($item['qty'])
                    ]);
                }
                DetailPenjualan::create($item);
            });
            session()->flash('success-top', "Berhasil dibuat dengan no invoice {$noInvoice}");
            $this->dataPenjualan = collect();
            $this->showForm = false;
        } else {
            session()->flash('error', 'Tambahkan barang terlebih dulu');
        }
    }

    public function cariBarang()
    {
        try {
            $this->barang = Barang::where('kode_barang', $this->kodeBarang)->first();
            $this->hargaSatuan = $this->jenis == 'dus' ? $this->barang->cash_dus : $this->barang->cash_pack;
        } catch (Exception $e) {
            $this->barang = collect();
        }
    }
    public function cancel()
    {
        $this->showForm = false;
    }

    public function confirmed($id)
    {
        $this->dataPenjualan->transform(function ($item, $key) use ($id) {
            if ($item['id'] === $id) $item['status'] = 'CONFIRMED';

            return $item;
        });
    }
    public function confirmAll()
    {
        $this->dataPenjualan->transform(function ($item, $key) {
            $item['status'] = 'CONFIRMED';
            return $item;
        });
    }

    public function waiting($id)
    {
        $this->dataPenjualan->transform(function ($item, $key) use ($id) {
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
        $this->dataPenjualan->transform(function ($item, $key) {
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
        $this->dataPenjualan->transform(function ($item, $key) {
            if ($item['id'] === $this->remarkId) $item['remark'] = $this->remark;
            return $item;
        });

        $this->remarkId = '';
    }

    public function cancelRemark()
    {
        $this->remarkId = '';
    }

    public function searchCustomer()
    {
        $this->customers = Customer::where('nama', 'like', '%' . $this->namaCustomer . '%')->get();
    }

    private function cekStock(): bool
    {
        if ($this->jenis == 'dus') {
            $jumlah = (int)$this->barang->jumlah_renteng * (int)$this->qty;
    
            if ($this->barang->stock_bayangan < $jumlah) return false;
            return true;
        } else {
            if ($this->barang->stock_bayangan < $this->qty) return false;
            return true;
        }
    }

    public function searchBarang()
    {
        $this->barangs = Barang::where('nama_barang', 'like', '%' . $this->namaBarang . '%')->get();
    }

    public function hitungHarga()
    {
        $this->harga = ((int)$this->hargaSatuan * (int)$this->qty) - (int)$this->diskon;
        if ($this->harga < 0) $this->harga = 0;
    }

    #[On('set-invoice')]
    public function setInvoice($noInvoice)
    {
        $this->noInvoice = $noInvoice;
        $this->isEdit = true;
    }

    public function cariInvoice()
    {
        $this->isEdit = true;
    }
    #[On('cancel-edit')]
    public function cancelInvoice($message = '', $type = 'success')
    {
        $this->isEdit = false;
        if($message) session()->flash($type,$message);
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
