<div>
    <p class="fs-6 fw-bold">Data Konfirmasi Penjualan</p>

    <div class="mt-3">
        <button wire:click='add' class="btn btn-sm btn-primary">Tambahkan Data</button>
        <button wire:click='showExcel()' class="btn btn-sm btn-success"><i class="mdi mdi-file-excel"></i>&nbsp;Import
            Penjualan</button>
    </div>

    @if (session('success'))
        <div class="alert alert-primary alert-dismissible fade show mt-2" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif (session('error'))
        <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Modal Add Penjualan --}}
    @if ($showModal)
        <div class="card mt-3">
            <div class="card-body">
                <form wire:submit='store'>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="noNota" class="form-label">No Nota</label>
                            <input wire:model='noNota' type="text" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="KodeBarang" class="form-label">Kode Barang</label>
                            <input wire:model='kodeBarang' wire:change='cekBarang' type="text" class="form-control"
                                required>
                            <p class="fs-6 fw-bold mt-1">Nama Barang : {{ $namaBarang }}</p>
                            @error($namaBarang)
                                <p class="text-danger">Kode Barang tidak ditemukan</p>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="Quantity" class="form-label">Quantity</label>
                            <input wire:model='quantity' type="number" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="Harga" class="form-label">Harga</label>
                            <select wire:model='harga' class="form-select" required>
                                <option value="" selected>---Pilih Harga---</option>
                                @if ($barang)
                                    <option value="{{ $barang->kredit_dus }}">Kredit Dus -
                                        {{ formatRupiah($barang->kredit_dus) }}</option>
                                    <option value="{{ $barang->kredit_pack }}">Kredit Pack -
                                        {{ formatRupiah($barang->kredit_pack) }}</option>
                                    <option value="{{ $barang->kredit_pcs }}">Kredit Pcs -
                                        {{ formatRupiah($barang->kredit_pcs) }}</option>
                                    <option value="{{ $barang->cash_dus }}">Cash Dus -
                                        {{ formatRupiah($barang->cash_dus) }}</option>
                                    <option value="{{ $barang->cash_pack }}">Cash pack -
                                        {{ formatRupiah($barang->cash_pack) }}</option>
                                    <option value="{{ $barang->cash_pcs }}">Cash Pcs -
                                        {{ formatRupiah($barang->cash_pcs) }}</option>
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="Diskon" class="form-label">Diskon</label>
                            <input wire:model='diskon' type="number" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="Toko" class="form-label">Toko</label>
                            <input wire:model='toko' type="text" class="form-control" required>
                        </div>
                    </div>

                    <div class="mt-3">
                        <button wire:loading.attr='disabled' wire:target='store' type="submit"
                            class="btn btn-primary">Simpan</button>
                        <button wire:click='cancel' type="button" class="btn btn-secondary">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

         {{-- Form Edit Remark --}}
        @if ($remarkId)
        <form wire:submit='saveRemark'>
            <div class="row my-3">
                <div class="col-md-8">
                    <input wire:model='remark' type="text" class="form-control " placeholder="Remark...">
                </div>
                <div class="col-md-4 ">
                    <button type="submit" class="btn btn-primary btn-sm">Save</button>
                    <button type="button" class="btn btn-sm btn-secondary">Cancel</button>
                </div>
            </div>
        </form>
    @endif

         {{-- Form Edit Aktual --}}
        @if ($aktualId)
        <form wire:submit='saveAktual'>
            <div class="row my-3">
                <div class="col-md-8">
                    <input wire:model='aktual' type="text" class="form-control " placeholder="Aktual...">
                </div>
                <div class="col-md-4 ">
                    <button type="submit" class="btn btn-primary btn-sm">Save</button>
                    <button type="button" class="btn btn-sm btn-secondary">Cancel</button>
                </div>
            </div>
        </form>
    @endif

    {{-- table --}}
    <div class="card mt-4">
        <div class="card-body">
            <div class="d-flex justify-content-end mb-2">
                <button wire:click='confirmAll' class="btn btn-success"><i class="mdi mdi-check-all"></i>&nbsp;Confirm
                    All</button>
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
                            <th scope="col">Diskon</th>
                            <th scope="col">Remark</th>
                            <th scope="col">Toko</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($penjualans as $penjualan)
                            <tr wire:key='{{ $penjualan->id }}'>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ Carbon\Carbon::parse($penjualan->created_at)->isoFormat('D MMM YYYY') }}</td>
                                <td>{{ $penjualan->no_nota }}</td>
                                <td>{{ $penjualan->kode_barang }}</td>
                                <td>{{ $penjualan->barang->nama_barang }}</td>
                                <td>{{ $penjualan->qty }}</td>
                                <td wire:click='addAktual("{{ $penjualan->id }}")' role="button" class="text-primary"><u>{{ $penjualan->aktual }}</u></td>
                                <td>{{ $penjualan->harga }}</td>
                                <td>{{ $penjualan->diskon }}</td>
                                <td wire:click='addRemark("{{ $penjualan->id }}")' class="text-primary" role="button"><u>{{ $penjualan->remark ?? '-' }}</u></td>
                                <td>{{ $penjualan->toko }}</td>
                                <td>
                                    @if ($penjualan->status == 'WAITING')
                                        <span wire:click='confirm("{{ $penjualan->id }}")' role="button"
                                            class="btn btn-sm btn-warning"><i
                                                class="mdi mdi-check-outline"></i></span>
                                    @elseif ($penjualan->status == 'CONFIRMED')
                                        <span wire:click='waiting("{{ $penjualan->id }}")' role="button"
                                            class="btn btn-sm btn-success"><i
                                                class="mdi mdi-check-outline"></i></span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if ($penjualans->count())
                <div class="mt-3">
                    <button wire:loading.attr='disabled' wire:target='save' wire:click='save' class="btn btn-success"> <span wire:loading wire:target='save' class="spinner-grow spinner-grow-sm" ></span>Save</button>
                    <button wire:loading.attr='disabled' wire:target='delete' wire:click='delete' class="btn btn-danger"><span wire:loading wire:target='delete' class="spinner-grow spinner-grow-sm" ></span>Delete</button>
                </div>
            @endif

        </div>
    </div>
</div>
