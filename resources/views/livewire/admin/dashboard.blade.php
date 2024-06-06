<div>
    <h2>Selamat Datang di Dashboard</h2>

    <p class="text-muted">Hasil Summary dari penjualan dan pembelian</p>

    <div class="row mt-5">
        {{-- Penjualan --}}
        <div class="col-md-6">
            <div class="card border-primary mb-3">
                <div class="card-header">Daftar Penjualan Belum Lunas
                    <p class="fs-4 mt-1 fw-bold">Total Semua : {{ formatRupiah($hargaPenjualan) }}</p>
                </div>
                <div class="card-body text-primary">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>No Invoice</th>
                                    <th>Customer</th>
                                    <th>Tanggal Jatuh Tempo</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($penjualans as $penjualan)
                                    <tr wire:key='{{ $penjualan->id }}'>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $penjualan->no_invoice }}</td>
                                        <td>{{ $penjualan->customer->nama }}</td>
                                        <td>{{ $penjualan->jatuh_tempo ? Carbon\Carbon::parse($penjualan->jatuh_tempo)->isoFormat('D MMM YYYY') : '-' }}
                                        </td>
                                        <td>
                                            @if ($penjualan->lunas)
                                                <span class="badge rounded-pill bg-success">Lunas</span>
                                            @else
                                                <span class="badge rounded-pill bg-danger">Belum Lunas</span>
                                            @endif
                                        </td>
                                        <td>{{ formatRupiah($penjualan->detail_penjualan->sum('harga')) }}</td>
                                       
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        {{-- Pembelian --}}
        <div class="col-md-6">
            <div class="card border-primary mb-3">
                <div class="card-header">Daftar Pembelian Belum Lunas
                    <p class="fs-4 mt-1 fw-bold">Total Semua : {{ formatRupiah($hargaPembelian) }}</p>
                </div>
                <div class="card-body text-primary">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>No Invoice</th>
                                    <th>Suplier</th>
                                    <th>Tanggal Jatuh Tempo</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pembelians as $pembelian)
                                    <tr wire:key='{{ $pembelian->id }}'>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $pembelian->no_invoice }}</td>
                                        <td>{{ $pembelian->suplier->nama }}</td>
                                        <td>{{ $pembelian->jatuh_tempo ? Carbon\Carbon::parse($pembelian->jatuh_tempo)->isoFormat('D MMM YYYY') : '-' }}
                                        </td>
                                        <td>
                                            @if ($pembelian->lunas)
                                                <span class="badge rounded-pill bg-success">Lunas</span>
                                            @else
                                                <span class="badge rounded-pill bg-danger">Belum Lunas</span>
                                            @endif
                                        </td>
                                        <td>{{ formatRupiah($pembelian->detail_pembelian->sum('harga')) }}</td>
                                       
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <div class="card border-primary mb-3">
            <div class="card-header">Daftar Penjualan Lewat Jatuh Tempo
                <p class="fs-4 mt-1 fw-bold">Total Semua : {{ formatRupiah($hargaJatuhTempo) }}</p>
            </div>
            <div class="card-body text-primary">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>No Invoice</th>
                                <th>Customer</th>
                                <th>Tanggal Jatuh Tempo</th>
                                <th>Status</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jatuhTempo as $penjualan)
                                <tr wire:key='{{ $penjualan->id }}'>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $penjualan->no_invoice }}</td>
                                    <td>{{ $penjualan->customer->nama }}</td>
                                    <td>{{ $penjualan->jatuh_tempo ? Carbon\Carbon::parse($penjualan->jatuh_tempo)->isoFormat('D MMM YYYY') : '-' }}
                                    </td>
                                    <td>
                                        @if ($penjualan->lunas)
                                            <span class="badge rounded-pill bg-success">Lunas</span>
                                        @else
                                            <span class="badge rounded-pill bg-danger">Belum Lunas</span>
                                        @endif
                                    </td>
                                    <td>{{ formatRupiah($penjualan->detail_penjualan->sum('harga')) }}</td>
                                   
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
