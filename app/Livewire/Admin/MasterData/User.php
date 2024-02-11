<?php

namespace App\Livewire\Admin\MasterData;

use App\Models\User as ModelsUser;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.sidebar')]
#[Title('Master Data User')]

class User extends Component
{
    use WithPagination;

    public $modalStatus = '';
    public $perPage = 10;
    public $serach = '';
    public $userId = null;

    public $username = '';
    public $password = '';
    public $level = '';

    public function render()
    {
        $users = ModelsUser::where('username', 'like', '%' . $this->serach . '%')
            ->paginate($this->perPage);
        return view('livewire.admin.master-data.user', ['users' => $users]);
    }

    public function addData()
    {
        $this->modalStatus = 'add';
    }

    public function edit($id)
    {
        $user = ModelsUser::find($id);
        $this->username = $user->username;
        $this->level = $user->level;
        $this->modalStatus = 'edit';
        $this->userId = $user->id;
    }
    public function store()
    {
        $this->validate([
            'level' => 'required',
            'username' => 'required|unique:users,username'
        ]);
        ModelsUser::create([
            'username' => $this->username,
            'password' => bcrypt($this->password),
            'level' => $this->level
        ]);

        $this->resetFields();
        session()->flash('success', 'Data berhasil ditambahkan');
    }

    public function update()
    {
        $data = [
            'username' => $this->username,
            'level' => $this->level
        ];
        if($this->password) $data['password'] = bcrypt($this->password);
        ModelsUser::find($this->userId)
            ->update($data);
        $this->resetFields();
        session()->flash('success', 'Data berhasil diupdate');
    }

    public function delete($id)
    {
        ModelsUser::find($id)->delete();
        session()->flash('success', 'Data berhasil dihapus');
    }

    public function resetFields()
    {
        $this->username = '';
        $this->password = '';
        $this->level = '';
        $this->modalStatus = '';
        $this->userId = null;
    }
}
