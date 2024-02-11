<div>
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
                <button wire:click='store' type="submit" class="btn btn-md btn-inverse-primary">Submit</button>

            </div>
        </div>

    </div>

    {{-- Order Table --}}
    <div class="table-responsive mt-5">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Qty</th>
                    <th>Aktual</th>
                    <th>Harga Satuan</th>
                    <th>Harga</th>
                    <th>Diskon</th>
                    <th>Remarks</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                {{-- @foreach ($dataPenjualan as $data)
                    <tr wire:key='{{ $data['id'] }}'>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $data['kode_barang'] }}</td>
                        <td>{{ $data['nama_barang'] }}</td>
                        <td>{{ $data['qty'] . ' ' . $data['jenis'] }}</td>
                        <td wire:click='showAktual("{{ $data['id'] }}")' class="text-primary"
                            role="button"><u>{{ $data['aktual'] }}</u></td>
                        <td>{{ formatRupiah($data['harga_satuan']) }}</td>
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
                @endforeach --}}
            </tbody>
        </table>
    </div>
</div>
