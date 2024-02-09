<div>
    @if (session('success'))
        <div class="alert alert-primary alert-dismissible fade show mt-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Report Qty</h4>
            <p class="card-description">
                Data Report Qty
            </p>

            <div class="d-flex align-items-center">

                <div class="p-2">
                    <p class="fw-bold">Filter</p>
                    <div class="row ms-3">
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="all" wire:model.change='jenis'
                                    value="all">
                                <label class="form-label" for="all">
                                    All
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="IN" wire:model.change='jenis'
                                    value="in">
                                <label class="form-label" for="IN">
                                    IN
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="OUT" wire:model.change='jenis'
                                    value="out">
                                <label class="form-label" for="OUT">
                                    OUT
                                </label>
                            </div>
                        </div>
                    </div>



                </div>
                <div class="ms-auto p-2">
                  <div class="row">
                    <div class="col-md-6">
                        <label for="Dari">Dari</label>
                        <input wire:model='dari' type="date" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label for="Sampai">Sampai</label>
                        <input wire:model='sampai' type="date" class="form-control">
                    </div>
                  </div>
                </div>
                <div class="p-2"><button wire:click='cari' class="btn btn-md btn-inverse-primary">Cari</button></div>
            </div>
            <button wire:click='exportExcel' class="btn btn-md btn-inverse-warning mt-2">Export Excel</button>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Kode Barang</th>
                            <th>Stok</th>
                            <th>IN</th>
                            <th>Out</th>
                            <th>Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($report as $r)
                            <tr wire:key='{{ $r->id }}'>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $r->kode_barang }}</td>
                                <td>{{ $r->stock }}</td>
                                <td>{{ $r->in ?? '-' }}</td>
                                <td>{{ $r->out ?? '-' }}</td>
                                <td>{{ $r->harga ?? '-' }}</td>
                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
