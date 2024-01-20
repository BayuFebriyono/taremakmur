<div>

    <button wire:click="addData" class="btn btn-primary">Tambahkan Data</button>
    @if (session('success'))
        <div class="alert alert-primary alert-dismissible fade show mt-2" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($modalStatus == 'add')
        <div class="mt-3">
            <div wire:transition class="card">
                <div class="card-header">Tambahkan Data</div>
                <div class="card-body">
                    <form wire:submit="store">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="Nama" class="form-label">Nama</label>
                                <input wire:model="nama" type="text" class="form-control"
                                    placeholder="masukkan nama..." required>
                            </div>
                            <div class="col-md-6">
                                <label for="NamaBarang" class="form-label">Nama Barang</label>
                                <input wire:model="nama_barang" type="text" class="form-control"
                                    placeholder="masukkan nama barang..." required>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <label for="Suplier" class="form-label">Suplier</label>
                                <input wire:model="suplier" type="text" class="form-control"
                                    placeholder="Masukkan suplier..." required>
                            </div>
                            <div class="col-md-6">
                                <label for="Satuan" class="form-label">Satuan</label>
                                <input wire:model="satuan" type="text" class="form-control"
                                    placeholder="Masukkan satuan..." required>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-6">
                                <label for="Unit" class="form-label">Unit</label>
                                <input wire:model="unit" type="number" class="form-control" placeholder="Masukkan unit"
                                    required>
                            </div>

                        </div>
                        <button type="submit" class="btn btn-primary mt-2">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    @endif

    @if ($modalStatus == 'edit')
        <div class="mt-3">
            <div wire:transition class="card">
                <div class="card-header">Edit Data</div>
                <div class="card-body">
                    <form wire:submit="update">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="Nama" class="form-label">Nama</label>
                                <input wire:model="nama" type="text" class="form-control"
                                    placeholder="masukkan nama..." required>
                            </div>
                            <div class="col-md-6">
                                <label for="NamaBarang" class="form-label">Nama Barang</label>
                                <input wire:model="nama_barang" type="text" class="form-control"
                                    placeholder="masukkan nama barang..." required>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <label for="Suplier" class="form-label">Suplier</label>
                                <input wire:model="suplier" type="text" class="form-control"
                                    placeholder="Masukkan suplier..." required>
                            </div>
                            <div class="col-md-6">
                                <label for="Satuan" class="form-label">Satuan</label>
                                <input wire:model="satuan" type="text" class="form-control"
                                    placeholder="Masukkan satuan..." required>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-6">
                                <label for="Unit" class="form-label">Unit</label>
                                <input wire:model="unit" type="number" class="form-control" placeholder="Masukkan unit"
                                    required>
                            </div>

                        </div>
                        <button type="submit" class="btn btn-primary mt-2">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <div class="card mt-3">
        <div class="card-header">Data Suplier</div>
        <div class="card-body">
            <input wire:model.live="search" type="text" class="form-control" placeholder="Cari ">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Nama Barang</th>
                            <th scope="col">Suplier</th>
                            <th scope="col">Satuan</th>
                            <th scope="col">Unit</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($supliers as $suplier)
                            <tr wire:key="{{ $suplier->id }}">
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $suplier->nama }}</td>
                                <td>{{ $suplier->nama_barang }}</td>
                                <td>{{ $suplier->suplier }}</td>
                                <td>{{ $suplier->satuan }}</td>
                                <td>{{ $suplier->unit }}</td>
                                <td><button wire:click="edit('{{ $suplier->id }}')" class="btn btn-warning d-inline"><i
                                            class="mdi mdi-pen"></i></button></td>
                                <td><button wire:click="delete('{{ $suplier->id }}')"
                                        wire:confirm="Apakah anda yakin ingin menghapus?"
                                        class="btn btn-danger d-inline"><i class="mdi mdi-trash-can"></i></button></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $supliers->links() }}
        </div>
    </div>
</div>