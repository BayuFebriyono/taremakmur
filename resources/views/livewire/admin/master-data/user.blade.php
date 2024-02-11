<div>
    <button wire:click="addData" class="btn btn-primary">Tambahkan Data</button>
    @if (session('success'))
        <div class="alert alert-primary alert-dismissible fade show mt-2" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($modalStatus == 'add')
        <div wire:transition class="card my-3">
            <div class="card-header">
                <p class="fs-6">Tambahkan Data</p>
            </div>
            <div class="card-body">
                <form wire:submit="store">
                    <div class="my-2">
                        <label for="Username" class="form-label">Username</label>
                        <input wire:model="username" type="text"
                            class="form-control @error('username')is-invalid @enderror" placeholder="Masukkan Username"
                            required>
                        @error('username')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="my-2">
                        <label for="Password" class="form-label">Password</label>
                        <input wire:model="password" type="password" class="form-control"
                            placeholder="Masukkan Password Pelanggan" required>
                    </div>

                    <div class="my-2">
                        <label for="Level" class="form-label">Level</label>
                        <select wire:model='level' class="form-select" required>
                            <option value="">---Pilih Level---</option>
                            <option value="admin">Admin</option>
                            <option value="super_admin">Super Admin</option>
                        </select>
                        @error('level')
                            <p class="text-danger">Pilih Level dulu</p>
                        @enderror
                    </div>

                    <button class="btn btn-primary mt-3" type="submit">Simpan</button>
                </form>
            </div>
        </div>
    @endif

    @if ($modalStatus == 'edit')
        <div wire:transition class="card my-3">
            <div class="card-header">
                <p class="fs-6">Edit Data</p>
            </div>
            <div class="card-body">
                <form wire:submit="update">
                    <div class="my-2">
                        <label for="Username" class="form-label">Username</label>
                        <input wire:model="username" type="text" class="form-control" placeholder="Masukkan Username"
                            required>
                    </div>

                    <div class="my-2">
                        <label for="Password" class="form-label">Password</label>
                        <input wire:model="password" type="password" class="form-control"
                            placeholder="Masukkan Password Pelanggan">
                        <p class="fw-bold">Biarkan kosong jika tidak ingin mengubah password</p>
                    </div>

                    <div class="my-2">
                        <label for="Level" class="form-label">Level</label>
                        <select wire:model='level' class="form-select" required>
                            <option value="">---Pilih Level---</option>
                            <option value="admin">Admin</option>
                            <option value="super_admin">Super Admin</option>
                        </select>
                        @error('level')
                            <p class="text-danger">Pilih Level dulu</p>
                        @enderror
                    </div>

                    <button class="btn btn-primary mt-3" type="submit">Simpan</button>
                </form>
            </div>
        </div>
    @endif
    <div class="card mt-5">
        <div class="card-header">Data Users</div>
        <div class="card-body">
            <div class="d-flex align-items-center">
                <p class="p-2">Tampilkan</p>
                <div class="p-2">
                    <select class="form-select" wire:model.change='perPage'>
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                        <option value="200">200</option>
                        <option value="{{ $users->count() }}">All</option>
                    </select>
                </div>
                <div class="ms-auto p-2">
                    <input wire:model.live="search" type="text" class="form-control" placeholder="Cari...">
                </div>
                <div class=" p-2">
                    <button wire:click='exportExcel' class="btn btn-inverse-success btn-md"> <span wire:loading
                            wire:target='exportExcel' class="spinner-grow spinner-grow-sm"></span>Export</button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Username</th>
                            <th scope="col">Level</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr wire:key="{{ $user->id }}">
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->level }}</td>
                                <td><button wire:click="edit('{{ $user->id }}')"
                                        class="btn btn-warning d-inline"><i class="mdi mdi-pen"></i></button>
                                    <button wire:click="delete('{{ $user->id }}')"
                                        wire:confirm="Apakah anda yakin ingin menghapus?"
                                        class="btn btn-danger d-inline"><i class="mdi mdi-trash-can"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $users->links(data: ['scrollTo' => false]) }}
        </div>
    </div>

</div>
