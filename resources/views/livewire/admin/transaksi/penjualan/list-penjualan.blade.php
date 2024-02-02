<div>
    <p class="fs-6 mt-5 fw-bold">History Penjualan</p>
    <div class="card mt-4">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">No Invoice</th>
                            <th scope="col">Kode Barang</th>
                            <th scope="col">Nama Barang</th>
                            <th scope="col">Qty</th>
                            <th scope="col">Aktual</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Diskon</th>
                            <th scope="col">Remark</th>
                            <th scope="col">Toko</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($penjualans as $penjualan)
                            <tr wire:key='{{ $penjualan->id }}'>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ Carbon\Carbon::parse($penjualan->created_at)->isoFormat('D MMM YYYY') }}</td>
                                <td>{{ $penjualan->no_nota }}</td>
                                <td>{{ $penjualan->kode_barang }}</td>
                                <td>{{ $penjualan->barang->nama_barang }}</td>
                                <td>{{ $penjualan->qty }}</td>
                                <td>{{ $penjualan->aktual }}</td>
                                <td>{{ $penjualan->harga }}</td>
                                <td>{{ $penjualan->diskon }}</td>
                                <td>{{ $penjualan->remark }}</td>
                                <td>{{ $penjualan->toko }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
