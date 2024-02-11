<div>
    @if (session('error-top'))
        <div class="alert alert-danger alert-dismissible fade show mt-4" role="alert">
            {{ session('error-top') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif (session('success-top'))
        <div class="alert alert-primary alert-dismissible fade show mt-4" role="alert">
            {{ session('success-top') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="card">
        <div class="card-body">
            <p class="fs-5 fw-bold">Form Pembelian Barang</p>
            <div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <label for="kodeBarang" class="form-label">Kode Barang</label>
                        <input wire:model='keywordBarang' wire:change='cariBarang' type="text" class="form-control"
                            placeholder="Cari nama barang" required>
                        <select wire:change='pilihBarang' wire:model.change='kodeBarang' class="form-select mt-1"
                            required>
                            <option value="">---Pilih Barang---</option>
                            @foreach ($barangs as $barang)
                                <option wire:key='{{ $barang->id }}' value="{{ $barang->kode_barang }}">
                                    {{ $barang->kode_barang }} - {{ $barang->nama_barang }}</option>
                            @endforeach
                        </select>

                    </div>

                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <label for="qty" class="form-label">Quantity</label>
                        <input wire:change='setHarga' wire:model.change='qty' type="number" id="qty"
                            class="form-control" placeholder="masukkan quantity" required>
                    </div>

                    <div class="col-md-6">
                        <p class="fw-bold">Pilih Jenis Pembelian</p>
                        <div class="row">
                            <div class="col-6">
                                <div class="ms-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="Dus" value="dus"
                                            wire:model.change='jenisPembelian' wire:change='setHarga'>
                                        <label class="form-label" for="Dus">
                                            Dus
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="ms-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="Renteng" value="renteng"
                                            wire:model.change='jenisPembelian' wire:change='setHarga'>
                                        <label class="form-label" for="Renteng">
                                            Pack
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="fw-bold">Pilih Metode Pembayaran</p>
                        <div class="row">
                            <div class="col-6">
                                <div class="ms-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="Dus" value="cash"
                                            wire:model.change='metodePembayaran' wire:change='setHarga'>
                                        <label class="form-label" for="Dus">
                                            Cash
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="ms-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="Renteng" value="kredit"
                                            wire:model.change='metodePembayaran' wire:change='setHarga'>
                                        <label class="form-label" for="Renteng">
                                            Kredit
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex">
                            <p class="fw-bold">Harga : {{ formatRupiah($hargaSatuan) }}</p>
                            <p class="fw-bold ms-4">Total Harga : {{ formatRupiah($harga) }} </p>
                        </div>
                    </div>




                </div>
            </div>
            <div class="mt-3">
                <button wire:click='addBarang' type="submit" class="btn btn-md btn-inverse-primary">Submit</button>

            </div>
        </div>

    </div>

    {{-- Order Table --}}
    <div class="table-responsive mt-5">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Aksi</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Qty</th>
                    <th>Harga Satuan</th>
                    <th>Harga</th>
                    <th>Diskon</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dataPenjualan as $data)
                    <tr wire:key='{{ $data['id'] }}'>
                        <td>{{ $loop->iteration }}</td>
                        <td wire:confirm='Apakah yakin ingin anda hapus?' wire:click='hapus("{{ $data['id'] }}")'>
                            <span role="button" class="btn btn-sm btn-danger"><i
                                    class="mdi mdi-trash-can"></i></span>
                        </td>
                        <td>{{ $data['kode_barang'] }}</td>
                        <td>{{ $data['nama_barang'] }}</td>
                        <td>{{ $data['qty'] . ' ' . $data['jenis'] }}</td>
                        <td>{{ formatRupiah($data['harga_satuan']) }}</td>
                        <td>{{ formatRupiah($data['harga']) }}</td>
                        <td>{{ $data['diskon'] }}</td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <p class="fw-bold">Total : {{ formatRupiah($dataPenjualan->sum('harga')) }}</p>
    <div class="mt-3">
        <button wire:click='simpan' type="button" class="btn btn-md btn-inverse-primary">  <span wire:target='simpan' wire:loading class="spinner-grow spinner-grow-sm"></span>Simpan Pesanan</button>
        <button wire:click='cancel' type="button" class="btn btn-md btn-inverse-danger">Batalkan Pesanan</button>
    </div>
</div>
