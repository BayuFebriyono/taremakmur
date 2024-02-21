<div>
    <style>
     .oneliner {
        word-wrap: break-word;
        max-width: 100%; /* Ubah max-width sesuai kebutuhan */
        overflow: auto; /* Atau gunakan overflow: hidden; */
    }
    </style>
    <button wire:click='addData' class="btn btn-primary">Tambahkan Data</button>
    <button wire:click='importExcel' class="btn btn-success"><i class="mdi mdi-file-excel"></i>&nbsp;Import Excel</button>
    @if (session('success'))
        <div class="alert alert-primary alert-dismissible fade show mt-2" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($excel)
        <livewire:admin.excel.barang-excel />
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
                                <label for="cashDus" class="form-label">Cash Dus</label>
                                <input wire:model='cashDus' type="number" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label for="cashPack" class="form-label">Cash Pack</label>
                                <input wire:model='cashPack' type="number" class="form-control">
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
                                <label for="beliDus" class="form-label">Harga Beli Dus</label>
                                <input wire:model='hargaBeliDus' type="number" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label for="BeliPcs" class="form-label">Harga Beli Pcs</label>
                                <input wire:model='hargaBeliPack' type="number" class="form-control">
                            </div>
                        </div>

                        <div class="my-4 col-md-6">
                            <label for="diskon" class="form-label">Diskon</label>
                            <input wire:model='diskon' type="number" class="form-control">
                        </div>

                        <div class="my-4 col-md-6">
                            <label for="Jumlah Renteng">Min Pack</label>
                            <input wire:model='jumlahRenteng' type="number" class="form-control"
                                placeholder="Jumlah renteng dalam satu dus" required>
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
                                <label for="cashDus" class="form-label">Cash Dus</label>
                                <input wire:model='cashDus' type="number" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label for="cashPack" class="form-label">Cash Pack</label>
                                <input wire:model='cashPack' type="number" class="form-control">
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
                                <label for="beliDus" class="form-label">Harga Beli Dus</label>
                                <input wire:model='hargaBeliDus' type="number" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label for="BeliPcs" class="form-label">Harga Beli Pcs</label>
                                <input wire:model='hargaBeliPack' type="number" class="form-control">
                            </div>
                        </div>

                        <div class="my-4 col-md-6">
                            <label for="diskon" class="form-label">Diskon</label>
                            <input wire:model='diskon' type="number" class="form-control">
                        </div>

                        <div class="my-4 col-md-6">
                            <label for="Jumlah Renteng">Min Pack</label>
                            <input wire:model='jumlahRenteng' type="number" class="form-control"
                                placeholder="Jumlah renteng dalam satu dus" required>
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
            <div class="d-flex align-items-center">
                <p class="p-2">Tampilkan</p>
                <div class="p-2">
                    <select class="form-select" wire:model.change='perPage'>
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                        <option value="200">200</option>
                        <option value="{{ $jumlahData }}">All</option>
                    </select>
                </div>
                <div class="ms-auto p-2">
                    <input wire:model.live="search" type="text" class="form-control" placeholder="Cari...">
                </div>
                <div class=" p-2">
                    <button wire:click='exportExcel' class="btn btn-inverse-success btn-md"> <span wire:loading
                            wire:target='exportExcel' class="spinner-grow spinner-grow-sm"></span>Export</button>
                </div>
            </div>
            {{-- <div class="table-responsive"> --}}
            <table class="table table-striped table-bordered" style="table-layout: fixed; width:100%;">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Suplier</th>
                        {{-- 7%;">Kode Barang</th> --}}
                        <th>Nama Barang</th>
                        <th>Min Pack</th>
                        <th>Cash Dus</th>
                        <th>Cash Pack</th>
                        <th>Kredit Dus</th>
                        <th>Kredit Pack</th>
                        <th>Diskon</th>
                        <th>Aktif</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($barangs as $barang)
                        <tr wire:key="{{ $barang->id }}">
                            <td>{{ $loop->iteration }}</td>
                            <td class="oneliner">{{ $barang->suplier->nama }}</td>
                            {{-- <td>{{ $barang->kode_barang }}</td> --}}
                            <td class="oneliner">{{ $barang->nama_barang }}</td>
                            <td class="oneliner">{{ $barang->jumlah_renteng }}</td>
                            <td class="oneliner">{{ formatRupiah($barang->cash_dus) }}</td>
                            <td class="oneliner">{{ formatRupiah($barang->cash_pack) }}</td>
                            <td class="oneliner">{{ formatRupiah($barang->kredit_dus) }}</td>
                            <td class="oneliner">{{ formatRupiah($barang->kredit_pack) }}</td>
                            <td class="oneliner">{{ formatRupiah($barang->diskon) }}</td>
                            <td>
                                @if ($barang->aktif)
                                    <span wire:click='nonAktif("{{ $barang->id }}")' role="button"
                                        class="btn btn-sm btn-success"><i class="mdi mdi-eye-outline"></i></span>
                                @else
                                    <span wire:click='aktif("{{ $barang->id }}")' role="button"
                                        class="btn btn-sm btn-danger"><i class="mdi mdi-eye-closed"></i></span>
                                @endif
                            </td>
                            <td><button wire:click="edit('{{ $barang->id }}')"
                                    class="btn btn-sm btn-warning d-inline"><i class="mdi mdi-pen"></i></button>
                                <button wire:click="delete('{{ $barang->id }}')"
                                    wire:confirm="Apakah anda yakin ingin menghapus?"
                                    class="btn btn-danger btn-sm d-inline"><i class="mdi mdi-trash-can"></i></button>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $barangs->links(data: ['scrollTo' => false]) }}
            {{-- </div> --}}
        </div>
    </div>
</div>
