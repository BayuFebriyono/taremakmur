<div class="container">
    @if (session('success-top'))
        <div class="alert alert-primary alert-dismissible fade show mt-4" role="alert">
            {{ session('success-top') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (!$showForm)
        {{-- Cari Invoice --}}
        <div class="card">
            <div class="card-body">
                <p class="fs-5 fw-bold">Masukkan No Invoice anda</p>
                <p class="text-muted">Menu dibawah ini dugunakan untuk mencari no invoice yang sudah ada</p>
                <form class="mt-2" wire:submit='cariInvoice'>
                    <div class="row">
                        <div class="col-md-10">
                            <input wire:model='noInvoice' type="text" class="form-control"
                                placeholder="Masukkan No Invoice Yang Sudah Ada">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-inverse-primary">Cari</button>
                        </div>
                    </div>
                </form>
                <button wire:click='add' type="button" class="btn btn-md btn-inverse-success">Atau buat invoice
                    baru</button>
            </div>
        </div>

        {{-- Card Waiting --}}
        <div class="mt-3">
            <livewire:admin.pembelian.waiting-confirm />
        </div>
    @else
        {{-- Form Pembelian --}}
        <div class="card mt-3">
            <div class="card-body">
                <p class="fs-5 fw-bold">Form Pembelian Barang</p>
                <div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="kodeBarang" class="form-label">Kode Barang</label>
                            <input wire:model='kodeBarang' wire:change='searchBarang' type="text"
                                class="form-control" placeholder="Masukkan kode barang" required>
                            <p class="fw-bold mt-1">Nama Barang : {{ $namaBarang }}</p>
                        </div>

                        <div class="col-md-6">
                            <label for="Diskon" class="form-label">Diskon</label>
                            <input wire:model='diskon' type="number" class="form-control" placeholder="Masukkan diskon"
                                required>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="qty" class="form-label">Quantity</label>
                            <input wire:model='qty' type="number" id="qty" class="form-control"
                                placeholder="masukkan quantity dalam dus" required>
                        </div>

                        <div class="col-md-6">
                            <label for="harga" class="form-label">Harga</label>
                            <input wire:model='harga' type="number" id="harga" class="form-control"
                                placeholder="Masukkan harga" required>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button wire:click='addBarang' type="submit"
                            class="btn btn-md btn-inverse-primary">Submit</button>
                        <button wire:click='cancel' type="button"
                            class="btn btn-md btn-inverse-danger ">Cancel</button>
                    </div>
                </div>

            </div>
        </div>

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
                    </div>
                    <div class="ms-auto p-2">
                        <label for="Suplier" class="form-label">Pilih Suplier</label>
                        <input wire:model='namaSuplier' wire:change='cariSuplier' type="text"
                            class="form-control mb-2" placeholder="Cari suplier...">
                        <select wire:model.change='suplierId' class="form-select" required>
                            <option value="">---Pilih Suplier---</option>
                            @foreach ($supliers as $suplier)
                                <option value="{{ $suplier->id }}">{{ $suplier->nama }}</option>
                            @endforeach
                        </select>
                        @error($suplierId)
                            <p class="text-danger">Pilih Suplier Dulu</p>
                        @enderror
                    </div>
                    <div class="p-2">
                        <button wire:click='simpan' class="btn btn-ms btn-inverse-success" type="button"> <span
                                wire:loading wire:target='simpan' class="spinner-grow spinner-grow-sm"></span>Simpan
                            Invoice</button>
                    </div>
                </div>

                {{-- Aktual --}}
                @if ($aktualId)
                    <div class="row my-3">
                        <div class="col-md-8">
                            <input wire:model='aktual' type="number" class="form-control " placeholder="Aktual...">
                        </div>
                        <div class="col-md-4 ">
                            <button wire:click='updateAktual' type="button"
                                class="btn btn-primary btn-sm">Save</button>
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
                            <button wire:click='updateRemark' type="button"
                                class="btn btn-primary btn-sm">Save</button>
                            <button wire:click='cancelRemark' type="button"
                                class="btn btn-sm btn-secondary">Cancel</button>
                        </div>
                    </div>
                @endif

                <div class="table-responsive mt-5">
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
                            @foreach ($dataPembelian as $data)
                                <tr wire:key='{{ $data['id'] }}'>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data['kode_barang'] }}</td>
                                    <td>{{ $data['nama_barang'] }}</td>
                                    <td>{{ $data['qty'] }}</td>
                                    <td wire:click='showAktual("{{ $data['id'] }}")' class="text-primary"
                                        role="button"><u>{{ $data['aktual'] }}</u></td>
                                    <td>{{ formatRupiah($data['harga']) }}</td>
                                    <td>{{ $data['diskon'] }}</td>
                                    <td wire:click='showRemark("{{ $data['id'] }}")' role="button"
                                        class="text-primary"><u>{{ $data['remark'] ?? '-' }}</u></td>
                                    <td>
                                        @if ($data['status'] == 'WAITING')
                                            <span wire:click='confirmed("{{ $data['id'] }}")' role="button"
                                                class="btn btn-sm btn-warning"><i
                                                    class="mdi mdi-check-outline"></i></span>
                                        @elseif ($data['status'] == 'CONFIRMED')
                                            <span wire:click='waiting("{{ $data['id'] }}")' role="button"
                                                class="btn btn-sm btn-success"><i
                                                    class="mdi mdi-check-outline"></i></span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>
