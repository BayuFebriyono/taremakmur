<?php

namespace App\Livewire\Admin\MasterData;

use App\Models\Customer as ModelsCustomer;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
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
    public $modalStatus = '';
    public $customerId = null;

    public $nama = '';
    public $alamat = '';
    public $excel = false;

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

    public function delete($id)
    {
        ModelsCustomer::destroy($id);
        session()->flash('success', 'Data telah dihapus');
    }

    public function addData()
    {
        $this->modalStatus = 'add';
    }

    public function edit($id)
    {
        $data = ModelsCustomer::find($id);
        $this->nama = $data->nama;
        $this->alamat = $data->alamat;
        $this->customerId = $data->id;
        $this->modalStatus = 'edit';
    }

    public function update()
    {
        ModelsCustomer::find($this->customerId)
            ->update([
                'nama' => $this->nama,
                'alamat' => $this->alamat
            ]);

        session()->flash('success', 'Data berhasil diubah');
        $this->resetFields();
    }

    public function resetFields()
    {


        $this->nama = '';
        $this->alamat = '';
        $this->modalStatus = '';
        $this->customerId = null;
    }

    public function importExcel()
    {
        $this->excel = true;
    }

    #[On('cancelExcelCustomer')]
    public function cancelExcel($message='')
    {
        $this->excel = false;
        if($message){
            session()->flash('success', $message);
        }
    }
}
