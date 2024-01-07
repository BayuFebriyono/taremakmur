<div>
    <button wire:click="addData" class="btn btn-primary">Tambahkan Data</button>
    @if (session('success'))     
    <div class="alert alert-primary alert-dismissible fade show mt-2" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if ($isAddData)
        <div wire:transition class="card my-3">
            <div class="card-header">
                <p class="fs-6">Tambahkan Data</p>
            </div>
            <div class="card-body">
                <form wire:submit="store">
                    <div class="my-2">
                        <label for="Nama" class="form-label">Nama</label>
                        <input wire:model="nama" type="text" class="form-control" placeholder="Masukkan Nama Pelanggan" required>
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
            <input wire:model.live="search" type="text" class="form-control"
                placeholder="Cari berdasarkan nama atau alamat....">
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
                            <td><button wire:click="delete('{{ $customer->id }}')" wire:confirm="Apakah anda yakin ingin menghapus?" class="btn btn-danger d-inline"><i class="mdi mdi-trash-can"></i></button></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $customers->links() }}
        </div>
    </div>

</div>
