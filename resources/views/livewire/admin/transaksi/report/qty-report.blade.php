<div>
    <p class="fs-5 fw-bold">Qty Report</p>
    
    <div class="card mt-4">
        <div class="card-body">
            <div class="d-flex align-items-center mb-2">
                <div class="p-2"><p>Tampilkan</p></div>
                <div class="p-2">
                    <select class="form-select" wire:model.change='perPage'>
                        <option value="1">1</option>
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                        <option value="200">200</option>
                        <option value="500">500</option>
                    </select>
                </div>
                <div class="ms-auto p-2">
                    <input type="text" class="form-control" placeholder="Carii....">
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Kode Barang</th>
                            <th scope="col">Nama Barang</th>
                            <th scope="col">Stock</th>
                            <th scope="col">IN</th>
                            <th scope="col">OUT</th>
                            <th scope="col">Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach ($reports as $report)
                           <tr wire:key='{{ $report->id }}'>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ \Carbon\Carbon::parse($report->created_at)->isoFormat('D MMM YYYY') }}</td>
                            <td>{{ $report->kode_barang }}</td>
                            <td>{{ $report->barang->nama_barang }}</td>
                            <td>{{ $report->barang->stock }}</td>
                            <td>{{ $report->in ?? '-' }}</td>
                            <td>{{ $report->out ?? '-' }}</td>
                            <td>{{ $report->balance }}</td>
                        </tr>
                       @endforeach
                    </tbody>
                </table>
            </div>
            {{ $reports->links(data:['scrollTo' => false]) }}
        </div>
    </div>
</div>
