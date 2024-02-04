<div>
    <button wire:click="addData" class="btn btn-primary">Tambahkan Data</button>
    <button wire:click='importExcel' class="btn btn-success"><i class="mdi mdi-file-excel"></i>&nbsp;Import Excel</button>
    @if (session('success'))
        <div class="alert alert-primary alert-dismissible fade show mt-2" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if ($excel)
        <livewire:admin.excel.customer-excel />
    @endif

    @if ($modalStatus == 'add')
        <div wire:transition class="card my-3">
            <div class="card-header">
                <p class="fs-6">Tambahkan Data</p>
            </div>
            <div class="card-body">
                <form wire:submit="store">
                    <div class="my-2">
                        <label for="Nama" class="form-label">Nama</label>
                        <input wire:model="nama" type="text" class="form-control"
                            placeholder="Masukkan Nama Pelanggan" required>
                    </div>

                    <div class="my-2">
                        <label for="Alamat" class="form-label">Alamat</label>
                        <textarea wire:model="alamat" class="form-control" rows="3" placeholder="Masukkan alamat...." required></textarea>
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
                        <label for="Nama" class="form-label">Nama</label>
                        <input wire:model="nama" type="text" class="form-control"
                            placeholder="Masukkan Nama Pelanggan" required>
                    </div>

                    <div class="my-2">
                        <label for="Alamat" class="form-label">Alamat</label>
                        <textarea wire:model="alamat" class="form-control" rows="3" placeholder="Masukkan alamat...." required></textarea>
                    </div>

                    <button class="btn btn-primary mt-3" type="submit">Simpan</button>
                </form>
            </div>
        </div>
    @endif
    <div class="card mt-5">
        <div class="card-header">Data Customer</div>
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
                        <option value="{{ $customers->count() }}">All</option>
                    </select>
                </div>
                <div class="ms-auto p-2">
                    <input wire:model.live="search" type="text" class="form-control" placeholder="Cari...">
                </div>
                <div class=" p-2">
                    <button wire:click='exportExcel' class="btn btn-inverse-success btn-md"> <span wire:loading wire:target='exportExcel' class="spinner-grow spinner-grow-sm" ></span>Export</button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $customer)
                            <tr wire:key="{{ $customer->id }}">
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $customer->nama }}</td>
                                <td>{{ $customer->alamat }}</td>
                                <td><button wire:click="edit('{{ $customer->id }}')" class="btn btn-warning d-inline"><i
                                            class="mdi mdi-pen"></i></button>
                                    <button wire:click="delete('{{ $customer->id }}')"
                                        wire:confirm="Apakah anda yakin ingin menghapus?"
                                        class="btn btn-danger d-inline"><i class="mdi mdi-trash-can"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $customers->links(data: ['scrollTo' => false]) }}
        </div>
    </div>

</div>
