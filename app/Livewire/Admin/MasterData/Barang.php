<?php

namespace App\Livewire\Admin\MasterData;

use App\Models\Barang as ModelsBarang;
use App\Models\Suplier as ModelsSuplier;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.sidebar')]
#[Title('Master Data Barang')]
class Barang extends Component
{
    use WithPagination;


    public $supliers;
    public $searchSuplier = '';

    // Properti Model
    public $kodeBarang;
    public $namaBarang;
    public $suplierId;
    public $hargaBeliDus = 0;
    public $hargaBeliPack = 0;
    public $cashDus = 0;
    public $cashPack = 0;
    public $diskon = 0;
    public $kreditDus = 0;
    public $kreditPack = 0;
    public $jumlahRenteng = '';

    // utils property
    public $statusModal = '';
    public $barangId = null;
    public $search = '';
    public $excel = false;

    public function mount()
    {
        $this->supliers = ModelsSuplier::all();
        $this->kodeBarang = uniqid();
    }

    public function updateSelectedSuplier()
    {
        $this->supliers = ModelsSuplier::where('nama', 'like', '%' . $this->searchSuplier . '%')->get();
    }

    public function addData()
    {
        $this->statusModal = 'add';
    }

    public function edit($id)
    {
        $this->statusModal = 'edit';
        $barang = ModelsBarang::find($id);
        $this->kodeBarang = $barang->kode_barang;

        $this->namaBarang = $barang->nama_barang;
        $this->suplierId = $barang->suplier_id;
        $this->hargaBeliDus = $barang->kredit_dus;
        $this->hargaBeliPack = $barang->kredit_pack;
        $this->cashDus = $barang->cash_dus;
        $this->cashPack = $barang->cash_pack;
        $this->kreditDus = $barang->kredit_dus;
        $this->kreditPack = $barang->kredit_pack;
        $this->diskon = $barang->diskon;
        $this->barangId = $barang->id;
        $this->jumlahRenteng = $barang->jumlah_renteng;
    }

    public function update()
    {
        $this->validate([
            'suplierId' => 'required',
            'kodeBarang' => ['required', Rule::unique('barangs', 'kode_barang')->where(function ($q) {
                return $q->where('kode_barang', '!=', $this->kodeBarang);
            })],
            'namaBarang' => 'required'
        ]);

        ModelsBarang::find($this->barangId)->update([
            'suplier_id' => $this->suplierId,
            'kode_barang' => $this->kodeBarang,
            'nama_barang' => $this->namaBarang,
            'harga_beli_dus' => $this->hargaBeliDus,
            'harga_beli_pack' => $this->hargaBeliPack,
            'cash_dus' => $this->cashDus,
            'cash_pack' => $this->cashPack,
            'kredit_dus' => $this->kreditDus,
            'kredit_pack' => $this->kreditPack,
            'diskon' => $this->diskon,
            'jumlah_renteng' => $this->jumlahRenteng
        ]);
        $this->cancel();
        session()->flash('success', 'Data telah diubah');
    }

    public function store()
    {
        $this->validate([
            'suplierId' => 'required',
            'kodeBarang' => 'required|unique:barangs,kode_barang',
            'namaBarang' => 'required'
        ]);

        ModelsBarang::create([
            'suplier_id' => $this->suplierId,
            'kode_barang' => $this->kodeBarang,
            'nama_barang' => $this->namaBarang,
            'harga_beli_dus' => $this->hargaBeliDus,
            'harga_beli_pack' => $this->hargaBeliPack,
            'cash_dus' => $this->cashDus,
            'cash_pack' => $this->cashPack,
            'kredit_dus' => $this->kreditDus,
            'kredit_pack' => $this->kreditPack,
            'diskon' => $this->diskon,
            'jumlah_renteng' => $this->jumlahRenteng
        ]);

        $this->cancel();
        session()->flash('success', 'Data telah ditambahkan');
    }

    public function delete($id)
    {
        ModelsBarang::find($id)->delete();
        session()->flash('success', 'Data berhasil dihapus');
    }

    public function render()
    {
        $barangs = ModelsBarang::where('nama_barang', 'like', '%' . $this->search . '%')
            ->paginate(10);
        return view('livewire.admin.master-data.barang', [
            'barangs' => $barangs,
        ]);
    }

    public function aktif($id)
    {
        ModelsBarang::find($id)->update(['aktif' => true]);
    }

    public function nonAktif($id)
    {
        ModelsBarang::find($id)->update(['aktif' => false]);
    }

    public function cancel()
    {
        $this->kodeBarang;
        $this->namaBarang;
        $this->suplierId;
        $this->hargaBeliDus = 0;
        $this->hargaBeliPack = 0;
        $this->cashDus = 0;
        $this->cashPack = 0;
        $this->diskon = 0;
        $this->statusModal = '';
        $this->jumlahRenteng = '';
        $this->barangId = null;
    }

    public function importExcel()
    {
        $this->excel = true;
    }

    #[On('cancelExcelBarang')]
    public function cancelExcel($message = '')
    {
        $this->excel = false;
        if ($message) {
            session()->flash('success', $message);
        }
    }
}
