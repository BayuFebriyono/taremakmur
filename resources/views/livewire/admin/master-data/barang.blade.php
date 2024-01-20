<div>
    <button wire:click='addData' class="btn btn-primary">Tambahkan Data</button>
    @if (session('success'))
        <div class="alert alert-primary alert-dismissible fade show mt-2" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($statusModal == 'add')
        <div class="card my-3">
            <div class="card-header">
                <p class="fs-6">Tambahkan Data</p>
            </div>
            <div class="card-body">
                <form wire:submit='store'>
                    <div class="my-2">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="Suplier" class="form-label">Suplier</label>
                            </div>
                            <div class="col-md-4">
                                <input wire:model='searchSuplier' wire:change='updateSelectedSuplier' type="text"
                                    class="form-control" placeholder="Cari nama suplier...">
                            </div>
                            <div class="col-md-8">
                                <select wire:model.change="suplierId" id="Suplier" class="form-select" required>
                                    <option value="" selected>---Pilih Suplier---</option>
                                    @foreach ($supliers as $suplier)
                                        <option wire:key='{{ $suplier->id }}' value="{{ $suplier->id }}">
                                            {{ $suplier->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row my-4">
                            <div class="col-md-6">
                                <label for="KodeBarang" class="form-label">Kode Barang</label>
                                <input wire:model='kodeBarang' type="text" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label for="NamaBarang" class="form-label">Nama Barang</label>
                                <input wire:model='namaBarang' type="text" class="form-control" required>
                            </div>
                        </div>

                        <div class="row my-4">
                            <div class="col-md-6">
                                <label for="kreditDus" class="form-label">Kredit Dus</label>
                                <input wire:model='kreditDus' type="number" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label for="kreditPack" class="form-label">Kredit Pack</label>
                                <input wire:model='kreditPack' type="number" class="form-control">
                            </div>
                        </div>

                        <div class="row my-4">
                            <div class="col-md-6">
                                <label for="kreditPcs" class="form-label">Kredit Pcs</label>
                                <input wire:model='kreditPcs' type="number" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label for="cashDus" class="form-label">Cash Dus</label>
                                <input wire:model='cashDus' type="number" class="form-control">
                            </div>
                        </div>

                        <div class="row my-4">
                            <div class="col-md-6">
                                <label for="cashPack" class="form-label">Cash Pack</label>
                                <input wire:model='cashPack' type="number" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label for="cashPcs" class="form-label">Cash Pcs</label>
                                <input wire:model='cashPcs' type="number" class="form-control">
                            </div>
                        </div>

                        <div class="my-4 col-md-6">
                            <label for="diskon" class="form-label">Diskon</label>
                            <input wire:model='diskon' type="number" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>

                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- modal Update --}}
    @if ($statusModal == 'edit')
        <div class="card my-3">
            <div class="card-header">
                <p class="fs-6">Tambahkan Data</p>
            </div>
            <div class="card-body">
                <form wire:submit='update'>
                    <div class="my-2">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="Suplier" class="form-label">Suplier</label>
                            </div>
                            <div class="col-md-4">
                                <input wire:model='searchSuplier' wire:change='updateSelectedSuplier' type="text"
                                    class="form-control" placeholder="Cari nama suplier...">
                            </div>
                            <div class="col-md-8">
                                <select wire:model.change="suplierId" id="Suplier" class="form-select" required>
                                    <option value="" selected>---Pilih Suplier---</option>
                                    @foreach ($supliers as $suplier)
                                        <option wire:key='{{ $suplier->id }}' value="{{ $suplier->id }}">
                                            {{ $suplier->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row my-4">
                            <div class="col-md-6">
                                <label for="KodeBarang" class="form-label">Kode Barang</label>
                                <input wire:model='kodeBarang' type="text" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label for="NamaBarang" class="form-label">Nama Barang</label>
                                <input wire:model='namaBarang' type="text" class="form-control" required>
                            </div>
                        </div>

                        <div class="row my-4">
                            <div class="col-md-6">
                                <label for="kreditDus" class="form-label">Kredit Dus</label>
                                <input wire:model='kreditDus' type="number" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label for="kreditPack" class="form-label">Kredit Pack</label>
                                <input wire:model='kreditPack' type="number" class="form-control">
                            </div>
                        </div>

                        <div class="row my-4">
                            <div class="col-md-6">
                                <label for="kreditPcs" class="form-label">Kredit Pcs</label>
                                <input wire:model='kreditPcs' type="number" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label for="cashDus" class="form-label">Cash Dus</label>
                                <input wire:model='cashDus' type="number" class="form-control">
                            </div>
                        </div>

                        <div class="row my-4">
                            <div class="col-md-6">
                                <label for="cashPack" class="form-label">Cash Pack</label>
                                <input wire:model='cashPack' type="number" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label for="cashPcs" class="form-label">Cash Pcs</label>
                                <input wire:model='cashPcs' type="number" class="form-control">
                            </div>
                        </div>

                        <div class="my-4 col-md-6">
                            <label for="diskon" class="form-label">Diskon</label>
                            <input wire:model='diskon' type="number" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>

                    </div>
                </form>
            </div>
        </div>
    @endif


    {{-- Table Untuk Show Data --}}
    <div class="card mt-5">
        <div class="card-header">
            Data Barang
        </div>
        <div class="card-body">
            <input wire:model.live='search' type="text" class="form-control" placeholder="Cari nama barang...">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Suplier</th>
                            <th scope="col">Kode Barang</th>
                            <th scope="col">Nama Barang</th>
                            <th scope="col">Kredit Dus</th>
                            <th scope="col">Kredit Pack</th>
                            <th scope="col">Kredit Pcs</th>
                            <th scope="col">Cash Dus</th>
                            <th scope="col">Cash Pack</th>
                            <th scope="col">Cash Pcs</th>
                            <th scope="col">Diskon</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($barangs as $barang)
                            <tr wire:key="{{ $barang->id }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $barang->suplier->nama }}</td>
                                <td>{{ $barang->kode_barang }}</td>
                                <td>{{ $barang->nama_barang }}</td>
                                <td>{{ formatRupiah($barang->kredit_dus) }}</td>
                                <td>{{ formatRupiah($barang->kredit_pack) }}</td>
                                <td>{{ formatRupiah($barang->kredit_pcs) }}</td>
                                <td>{{ formatRupiah($barang->cash_dus) }}</td>
                                <td>{{ formatRupiah($barang->cash_pack) }}</td>
                                <td>{{ formatRupiah($barang->cash_pcs) }}</td>
                                <td>{{ formatRupiah($barang->diskon) }}</td>
                                <td><button wire:click="edit('{{ $barang->id }}')"
                                        class="btn btn-warning d-inline"><i class="mdi mdi-pen"></i></button>
                                    <button wire:click="delete('{{ $barang->id }}')"
                                        wire:confirm="Apakah anda yakin ingin menghapus?"
                                        class="btn btn-danger d-inline"><i class="mdi mdi-trash-can"></i></button>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $barangs->links() }}
            </div>
        </div>
    </div>
</div>
