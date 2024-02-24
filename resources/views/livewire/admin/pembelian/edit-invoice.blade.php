<div>
    {{-- Table --}}
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show mt-4" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif (session('success'))
        <div class="alert alert-primary alert-dismissible fade show mt-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="card mt-2">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div class="p-2">
                    <h4 class="card-title">Data konfirmasi pembelian</h4>
                    <p class="my-2 text-muted">Data ini temporary tidak akan masuk ke database selama belum di save
                    </p>
                    <button wire:click='confirmAll' class="btn btn-md btn-inverse-warning">Confirm All</button>
                    <button wire:click='simpan' class="btn btn-ms btn-inverse-success" type="button"> <span
                            wire:loading wire:target='simpan' class="spinner-grow spinner-grow-sm"></span>Simpan
                        Invoice</button>
                    <button wire:click='cancel' class="btn btn-ms btn-inverse-danger" type="button"> <span wire:loading
                            wire:target='cancel' class="spinner-grow spinner-grow-sm"></span>
                        Cancel</button>
                </div>

            </div>
            @if ($dataPembelian->jenis_pembayaran == 'kredit')
                <div class="mt-3">
                    <label class="form-label">Jatuh Tempo</label>
                    <input type="date" class="form-control" wire:model='jatuhTempo'>
                </div>
            @endif

            {{-- Aktual --}}
            @if ($aktualId)
                <div class="row my-3">
                    <div class="col-md-8">
                        <input wire:model='aktual' type="number" class="form-control " placeholder="Aktual...">
                    </div>
                    <div class="col-md-4 ">
                        <button wire:click='updateAktual' type="button" class="btn btn-primary btn-sm">Save</button>
                        <button wire:click='cancelAktual' type="button"
                            class="btn btn-sm btn-secondary">Cancel</button>
                    </div>
                </div>
            @endif
            {{-- Remark --}}
            @if ($remarkId)
                <div class="row my-3">
                    <div class="col-md-8">
                        <input wire:model='remark' type="text" class="form-control " placeholder="Remark...">
                    </div>
                    <div class="col-md-4 ">
                        <button wire:click='updateRemark' type="button" class="btn btn-primary btn-sm">Save</button>
                        <button wire:click='cancelRemark' type="button"
                            class="btn btn-sm btn-secondary">Cancel</button>
                    </div>
                </div>
            @endif

            <div class="table-responsive mt-5">
                <p class=" fw-bold">Suplier : {{ $dataPembelian->suplier->nama }}</p>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Qty</th>
                            <th>Aktual</th>
                            <th>Harga</th>
                            <th>Diskon</th>
                            <th>Remarks</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataPembelian->detail_pembelian as $data)
                            <tr wire:key='{{ $data->id }}'>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->kode_barang }}</td>
                                <td>{{ $data->barang->nama_barang }}</td>
                                <td>{{ $data->qty }}</td>
                                <td wire:click='showAktual("{{ $data->id }}")' class="text-primary" role="button">
                                    <u>{{ $data->aktual }}</u></td>
                                <td>{{ formatRupiah($data->harga) }}</td>
                                <td>{{ $data->diskon }}</td>
                                <td wire:click='showRemark("{{ $data->id }}")' role="button" class="text-primary">
                                    <u>{{ $data->remark ?? '-' }}</u></td>
                                <td>
                                    @if ($data->status == 'WAITING')
                                        <span wire:click='confirmed("{{ $data->id }}")' role="button"
                                            class="btn btn-sm btn-warning"><i class="mdi mdi-check-outline"></i></span>
                                    @elseif ($data->status == 'CONFIRMED')
                                        <span wire:click='waiting("{{ $data->id }}")' role="button"
                                            class="btn btn-sm btn-success"><i class="mdi mdi-check-outline"></i></span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
