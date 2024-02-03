<div>
    <div class="container mt-4">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <select wire:model.change='perPage' class="form-select">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="15">15</option>
                            <option value="20">20</option>
                            <option value="25">25</option>
                            <option value="30">30</option>
                            <option value="100">100</option>
                            <option value="200">200</option>
                        </select>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control" placeholder="Cari pembelians...">
                    </div>
                </div>
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
                            </tr>
                        </thead>
                        <tbody>
                           @foreach ($pembelians as $pembelian)
                           <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ \Carbon\Carbon::parse($pembelian->created_at)->isoFormat('D MMM YYYY') }}</td>
                            <td>{{ $pembelian->no_invoice }}</td>
                            <td>{{ $pembelian->kode_barang }}</td>
                            <td>{{ $pembelian->barang->nama_barang }}</td>
                            <td>{{ $pembelian->qty }}</td>
                            <td>{{ $pembelian->aktual }}</td>
                            <td>{{ $pembelian->harga }}</td>
                            <td>{{ $pembelian->suplier->nama }}</td>
                            <td>{{ $pembelian->diskon }}</td>
                            <td>{{ $pembelian->remark ?? '-' }}</td>
                           </tr>
                           @endforeach
                        </tbody>
                    </table>
                    {{ $pembelians->links(data:['scrollTo' => false]) }}
                </div>
            </div>
        </div>
    </div>
</div>
