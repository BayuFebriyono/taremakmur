<div>
    <style>
        .underline {
            border-bottom: 1px dotted #c03;
            width: 100%;
            display: block;
        }
    </style>
    {{-- @if (session('success'))
        <div class="alert alert-primary alert-dismissible fade show mt-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif --}}

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Stock Barang</h4>
            <p class="card-description">
                List Stock Barang Yang Tersedia
            </p>

            <div class="d-flex align-items-center">

                {{-- <div class="p-2">
                    <select class="form-select" wire:model.change='perPage'>
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                        <option value="200">200</option>
                        <option value="{{ $pembelians->count() }}">All</option>
                    </select>
                </div> --}}
                <div class="">
                    <input wire:model.live="search" type="text" class="form-control" placeholder="Cari...">
                </div>
            </div>
            {{-- <div class="table-responsive"> --}}
            {{-- <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($barangs as $barang)
                            <tr wire:key='{{ $barang->id }}'>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <p class="fw-bold">{{ $barang->nama_barang }}</p>
                                    <p class="text-muted">{{ $barang->stock_bayangan / $barang->jumlah_renteng }} Dus
                                    </p>
                                    <p class="text-muted">{{ $barang->stock_bayangan }} Pack</p>
                                </td>
                                <td>
                                    <p class="text-muted">{{ $barang->cash_dus }} Cash Dus</p>
                                    <p class="text-muted">{{ $barang->cash_pack }} Cash Pack</p>
                                    <p class="text-muted">{{ $barang->kredit_dus }} Kredit Dus</p>
                                    <p class="text-muted">{{ $barang->kredit_pack }} Kredit Pack</p>
                                </td>
                                <td></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table> --}}
            {{-- </div> --}}

            <div class="row mt-3">
                <div class="col-6">Nama</div>
                <div class="col-6">Harga</div>
            </div>

            <div class="mt-3">
                <div class="row">
                    @foreach ($barangs as $barang)
                        <div class="col-6">
                            <p class="fw-bold">{{ $barang->nama_barang }}</p>
                            <p class="text-muted">{{ $barang->stock_bayangan / $barang->jumlah_renteng }} Dus
                            </p>
                            <p class="text-muted">{{ $barang->stock_bayangan }} Pack</p>
                        </div>
                        <div class="col-6">
                            <p class="text-muted">{{ formatRupiah($barang->cash_dus) }} Cash Dus</p>
                            <p class="text-muted">{{ formatRupiah($barang->cash_pack) }} Cash Pack</p>
                            <p class="text-muted">{{ formatRupiah($barang->kredit_dus) }} Kredit Dus</p>
                            <p class="text-muted">{{ formatRupiah($barang->kredit_pack) }} Kredit Pack</p>
                        </div>
                        <hr>
                    @endforeach
                </div>
            </div>
            <div class="mt-2">
                {{-- {{ $pembelians->links(data: ['scrollTo' => false]) }} --}}
            </div>
        </div>
    </div>

</div>
