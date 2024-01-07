<div>
    <button class="btn btn-primary">Tambahkan Data</button>

    <div class="card mt-5">
        <div class="card-header">Data Customer</div>
        <div class="card-body">
            <input wire:model.live="search" type="text" class="form-control" placeholder="Cari berdasarkan nama atau alamat....">
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
                            <th  scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $customer->nama }}</td>
                            <td>{{ $customer->alamat }}</td>
                            <td></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $customers->links() }}
        </div>
    </div>

</div>
