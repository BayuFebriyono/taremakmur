<div>
    <div class="container">
        <div class="card">
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
                                <th scope="col">Suplier</th>
                                <th scope="col">Diskon</th>
                                <th scope="col">Remark</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pembelians as $pembelian)
                                <tr wire:key='{{ $pembelian->id }}'>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ Carbon\Carbon::parse($pembelian->created_at)->locale('id_ID')->isoFormat('D MM YYYY') }}</td>
                                    <td>{{ $pembelian->no_invoice }}</td>
                                    <td>{{ $pembelian->kode_barang }}</td>
                                    <td>{{ $pembelian->kode_barang->nama_barang }}</td>
                                    <td>{{ $pembelian->qty }}</td>
                                    <td>{{ $pembelian->aktual }}</td>
                                    <td>{{ $pembelian->harga }}</td>
                                    <td>{{ $pembelian->diskon }}</td>
                                    <td>??</td>
                                    <td>??</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
