<div>
    <div class="mb-3">
        <button wire:click='add' class="btn btn-sm btn-primary ">Tambahkan Pembelian</button>
        <button class="btn btn-sm btn-success"><i class="mdi mdi-file-excel"></i>&nbsp;Import Pembelian</button>
    </div>
    <div class="container">
        @if ($showModal)
            <div class="card mb-3">
                <div class="card-body">
                    <form>
                        <div class="row">
                            {{-- Select Suplier --}}
                            <div class="col-md-6">
                                <label for="Suplier" class="form-label">Pilih Suplier</label>
                                <input wire:model='serachSuplier' wire:change='filterSuplier' type="text"
                                    class="form-control" placeholder="cari suplier...">
                                <select id="Suplier" class="form-select mt-1" required>
                                    <option value="" selected disabled>---Pilih Suplier---</option>
                                    @foreach ($supliers as $suplier)
                                        <option wire:key='{{ $suplier->id }}' value="{{ $suplier->id }}">
                                            {{ $suplier->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- Field Invoice --}}
                            <div class="col-md-6">
                                <label for="Invoice" class="form-label">No Invoice</label>
                                <input type="text" class="form-control" required>
                            </div>
                        </div>

                        <div class="row">
                            {{-- Kode Barang --}}
                            <div class="col-md-6">
                                <label for="KodeBarang" class="form-label">Kode Barang</label>
                                <input type="text" id="KodeBarang" class="form-control" required>
                                {{-- Text Nama Barang --}}
                                <p>Nama Barang :</p>
                            </div>

                            {{-- Quantity --}}
                            <div class="col-md-6">
                                <label for="Qty" class="form-label">Quantity</label>
                                <input type="number" id="Qty" class="form-control" required>
                            </div>
                        </div>

                        <div class="row">
                            {{-- Harga --}}
                            <div class="col-md-6">
                                <label for="Harga" class="form-label">Harga</label>
                                <input type="number" class="form-control" id="Harga" required>
                            </div>

                            {{-- Diskon --}}
                            <div class="col-md-6">
                                <label for="Diskon" class="form-label">Diskon</label>
                                <input type="text" class="form-control" required>
                                @error('diskon')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <button wire:click='cancel' type="button" class="btn btn-secondary">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif

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
                                    <td>{{ Carbon\Carbon::parse($pembelian->created_at)->locale('id_ID')->isoFormat('D MM YYYY') }}
                                    </td>
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
