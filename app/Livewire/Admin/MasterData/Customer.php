<?php

namespace App\Livewire\Admin\MasterData;

use App\Models\Customer as ModelsCustomer;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.sidebar')]
#[Title('Master Data Customer')]
class Customer extends Component
{
    use WithPagination;

    public $active = 'customer';
    public $search = '';
    public $isAddData = false;

    public $nama = '';
    public $alamat = '';

    public function render()
    {
        $customers = ModelsCustomer::where('nama', 'like', '%' . $this->search . '%')
            ->orWhere('alamat', 'like', '%' . $this->search . '%')
            ->paginate(10);

        return view('livewire.admin.master-data.customer', [
            'customers' => $customers
        ]);
    }

    public function store()
    {
        $this->validate([
            'nama' => 'required',
            'alamat' => 'required'
        ]);

        ModelsCustomer::create([
            'nama' => $this->nama,
            'alamat' => $this->alamat
        ]);

        session()->flash('success', 'Data berhasil ditambahkan');
        $this->resetFields();
    }

    public function addData()
    {
        $this->isAddData = true;
    }

    public function resetFields()
    {
        $this->isAddData = false;

        $this->nama = '';
        $this->alamat = '';
    }
}
