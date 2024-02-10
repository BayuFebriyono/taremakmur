<div>
    {{-- @if (session('success'))
        <div class="alert alert-primary alert-dismissible fade show mt-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif --}}

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Pembelian Menunggu di konfirmasi</h4>
            <p class="card-description">
               Data pembelian ini tidak akan mempengaruhi stock sebelum anda mengkonfirmasinya
            </p>

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
                        <option value="{{ $pembelians->count() }}">All</option>
                    </select>
                </div>
                <div class="ms-auto p-2">
                    <input wire:model.live="search" type="text" class="form-control" placeholder="No Invoice...">
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>No Invoice</th>
                            <th>Admin</th>
                            <th>Suplier</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pembelians as $pembelian)
                            <tr wire:key='{{ $pembelian->id }}'>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $pembelian->no_invoice }}</td>
                                <td>{{ $pembelian->user->username }}</td>
                                <td>{{ $pembelian->suplier->nama }}</td>
                                <td>{{ Carbon\Carbon::parse($pembelian->created_at)->isoFormat('D MMM YYYY') }}</td>
                                <td>
                                    <button wire:click='generateNota("{{ $pembelian->no_invoice }}")' type="button"
                                        class="btn btn-sm btn-info"><span
                                            class="mdi mdi-printer-outline"></span></button>
                                    <button wire:click='setInvoice("{{ $pembelian->no_invoice }}")' type="button" class="btn btn-sm btn-success"><span
                                            class="mdi mdi-eye-outline"></span></button>
                                    <button wire:confirm='Apakah anda yakin ingin menghapus?'
                                        wire:click='delete("{{ $pembelian->no_invoice }}")' type="button"
                                        class="btn btn-sm btn-danger"><span class="mdi mdi-trash-can"></span></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-2">
                {{ $pembelians->links(data: ['scrollTo' => false]) }}
            </div>
        </div>
    </div>
</div>
