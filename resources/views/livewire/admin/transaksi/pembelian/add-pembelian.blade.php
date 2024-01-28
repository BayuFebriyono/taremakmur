<div>
    <div class="mb-3">
        <button wire:click='add' class="btn btn-sm btn-primary ">Tambahkan Pembelian</button>
        <button wire:click='showExcel()' class="btn btn-sm btn-success"><i class="mdi mdi-file-excel"></i>&nbsp;Import
            Pembelian</button>
    </div>
    @if (session('success'))
        <div class="alert alert-primary alert-dismissible fade show mt-2" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif




    <div class="container">
        @if ($excel)
            <livewire:admin.transaksi.pembelian.excel-add-pembelian />
        @endif
        {{-- Form Edit Remark --}}
        @if ($showRemarkId)
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
        @if ($showAktualId)
            <form wire:submit='saveAktual'>
                <div class="row my-3">
                    <div class="col-md-8">
                        <input wire:model='aktual' type="number" class="form-control " placeholder="Aktual...">
                    </div>
                    <div class="col-md-4 ">
                        <button type="submit" class="btn btn-primary btn-sm">Save</button>
                        <button type="button" class="btn btn-sm btn-secondary">Cancel</button>
                    </div>
                </div>
            </form>
        @endif


        @if ($showModal)
            <div class="card mb-3">
                <div class="card-body">
                    <form wire:submit='store'>
                        <div class="row">
                            {{-- Select Suplier --}}
                            <div class="col-md-6">
                                <label for="Suplier" class="form-label">Pilih Suplier</label>
                                <input wire:model='serachSuplier' wire:change='filterSuplier' type="text"
                                    class="form-control" placeholder="cari suplier...">
                                <select wire:model='suplierId' id="Suplier" class="form-select mt-1" required>
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
                                <input wire:model='noInvoice' type="text" class="form-control" required>
                            </div>
                        </div>

                        <div class="row">
                            {{-- Kode Barang --}}
                            <div class="col-md-6">
                                <label for="KodeBarang" class="form-label">Kode Barang</label>
                                <input wire:model='kodeBarang' wire:change='changeNamaBarang' type="text"
                                    id="KodeBarang" class="form-control" required>
                                {{-- Text Nama Barang --}}
                                <p>Nama Barang : {{ $namaBarang }}</p>
                            </div>

                            {{-- Quantity --}}
                            <div class="col-md-6">
                                <label for="Qty" class="form-label">Quantity</label>
                                <input wire:model='quantity' type="number" id="Qty" class="form-control"
                                    required>
                            </div>
                        </div>

                        <div class="row">
                            {{-- Harga --}}
                            <div class="col-md-6">
                                <label for="Harga" class="form-label">Harga</label>
                                <input wire:model='harga' type="number" class="form-control" id="Harga" required>
                            </div>

                            {{-- Diskon --}}
                            <div class="col-md-6">
                                <label for="Diskon" class="form-label">Diskon</label>
                                <input wire:model='diskon' type="text" class="form-control" required>
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
                <div class="d-flex justify-content-end mb-2">
                    <button wire:click='confirmAll' class="btn btn-success"><i
                            class="mdi mdi-check-all"></i>&nbsp;Confirm All</button>
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
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pembelians as $pembelian)
                                <tr wire:key='{{ $pembelian->id }}'>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ Carbon\Carbon::parse($pembelian->created_at)->locale('id_ID')->isoFormat('D MMM YYYY') }}
                                    </td>
                                    <td>{{ $pembelian->no_invoice }}</td>
                                    <td>{{ $pembelian->kode_barang }}</td>
                                    <td>{{ $pembelian->barang->nama_barang }}</td>
                                    <td>{{ $pembelian->qty }}</td>
                                    <td wire:click='showAktual("{{ $pembelian->id }}")' role="button"
                                        class="text-primary"><u>{{ $pembelian->aktual }}</u></td>
                                    <td>{{ formatRupiah($pembelian->harga) }}</td>
                                    <td>{{ $pembelian->suplier->nama }}</td>
                                    <td>{{ $pembelian->diskon }}</td>
                                    <td wire:click='showRemark("{{ $pembelian->id }}")' role="button"
                                        class="text-primary"><u>{{ $pembelian->remark ?? '-' }}</u>
                                    </td>
                                    <td>
                                        @if ($pembelian->status == 'WAITING')
                                            <span wire:click='confirmed("{{ $pembelian->id }}")' role="button"
                                                class="btn btn-sm btn-warning"><i
                                                    class="mdi mdi-check-outline"></i></span>
                                        @elseif ($pembelian->status == 'CONFIRMED')
                                            <span wire:click='waiting("{{ $pembelian->id }}")' role="button"
                                                class="btn btn-sm btn-success"><i
                                                    class="mdi mdi-check-outline"></i></span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if ($pembelians->count())
                    <div class="mt-3">
                        <button wire:click='save' class="btn btn-success">Save</button>
                        <button wire:click='delete' class="btn btn-danger">Delete</button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
