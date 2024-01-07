<?php

namespace App\Livewire\Admin\MasterData;

use App\Models\Suplier as ModelsSuplier;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.sidebar')]
#[Title('Master Data Suplier')]
class Suplier extends Component
{
    use WithPagination;
    public $search = '';

    public $modalStatus = '';
    public $nama = '';
    public $nama_barang = '';
    public $suplier = '';
    public $satuan = '';
    public $unit = 0;
    public $suplierId = null;

    public function render()
    {
        $supliers = ModelsSuplier::where('nama', 'like', '%' . $this->search . '%')
            ->orWhere('nama_barang', 'like', '%' . $this->search . '%')
            ->orWhere('suplier', 'like', '%' . $this->search . '%')
            ->paginate(10);

        return view('livewire.admin.master-data.suplier', [
            'supliers' => $supliers
        ]);
    }

    public function store()
    {
        $this->validate([
            'nama' => 'required',
            'nama_barang' => 'required',
            'suplier' => 'required',
            'satuan' => 'required',
            'unit' => 'required|numeric'
        ]);

        ModelsSuplier::create([
            'nama' => $this->nama,
            'nama_barang' => $this->nama_barang,
            'suplier' => $this->suplier,
            'satuan' => $this->satuan,
            'unit' => $this->unit
        ]);

        session()->flash('success', 'Data berhasil ditambahkan');
        $this->resetFields();
    }

    public function delete($id)
    {
        ModelsSuplier::find($id)->delete();
        session()->flash('success', 'Data telah dihapus');
    }

    public function edit($id)
    {
        $data = ModelsSuplier::find($id);
        $this->nama = $data->nama;
        $this->nama_barang = $data->nama_barang;
        $this->suplier = $data->suplier;
        $this->satuan = $data->satuan;
        $this->unit = $data->unit;
        $this->suplierId = $data->id;

        $this->modalStatus = 'edit';
    }

    public function update()
    {
        ModelsSuplier::find($this->suplierId)
            ->update([
                'nama' => $this->nama,
                'nama_barang' => $this->nama_barang,
                'suplier' => $this->suplier,
                'satuan' => $this->satuan,
                'unit' => $this->unit
            ]);

        session()->flash('success', 'Data berhasil di update');
        $this->resetFields();
    }

    public function addData()
    {
        $this->modalStatus = 'add';
    }

    public function resetFields()
    {
        $this->modalStatus = '';
        $this->nama = '';
        $this->nama_barang = '';
        $this->suplier = '';
        $this->satuan = '';
        $this->unit = 0;
        $this->suplierId = null;
    }
}
