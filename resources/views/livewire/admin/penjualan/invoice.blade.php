<div class="container">
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
    @if (!$showForm)
        {{-- Cari Invoice --}}
        <div class="card">
            <div class="card-body">
                <p class="fs-5 fw-bold">Masukkan No Invoice anda</p>
                <p class="text-muted">Menu dibawah ini dugunakan untuk mencari no invoice yang sudah ada</p>
                <form wire:submit='cariInvoice' class="mt-2">
                    <div class="row">
                        <div class="col-md-10">
                            <input wire:model='noInvoice' type="text" class="form-control"
                                placeholder="Masukkan No Invoice Yang Sudah Ada" required>
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

        <div class="mt-2">
            @if (!$isEdit)
                <livewire:admin.penjualan.waiting-confirm />
            @else
                <livewire:admin.penjualan.edit-invoice :noInvoice="$noInvoice" />
            @endif
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
                            {{-- <input wire:model='namaBarang' wire:change='searchBarang' type="text"
                                class="form-control" placeholder="Cari nama barang" required>
                            <select wire:change='cariBarang' wire:model.change='kodeBarang' class="form-select mt-1"
                                required>
                                <option value="">---Pilih Barang---</option>
                                @foreach ($barangs as $barang)
                                    <option wire:key='{{ $barang->id }}' value="{{ $barang->kode_barang }}">
                                        {{ $barang->kode_barang }} - {{ $barang->nama_barang }}</option>
                                @endforeach
                            </select> --}}

                            <input type="text" wire:model='namaBarang' wire:change='searchBarang' class="form-control" list="barangList" placeholder="Cari Barang">
                            <datalist id="barangList">
                                @foreach ($barangs as $barang)
                                    <option wire:key='{{ $barang->id }}' value="{{ $barang->nama_barang }}">
                                @endforeach
                            </datalist>

                        </div>

                        <div class="col-md-6">
                            <label for="Diskon" class="form-label">Diskon</label>
                            <input wire:change='hitungHarga' wire:model.change='diskon' type="number"
                                class="form-control" placeholder="Masukkan diskon" required>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="qty" class="form-label">Quantity</label>
                            <input wire:change='hitungHarga' wire:model.change='qty' type="number" id="qty"
                                class="form-control" placeholder="masukkan quantity" required>
                        </div>

                        <div class="col-md-6">
                            <p class="fw-bold">Pilih Jenis Pembelian</p>
                            <div class="ms-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="Dus" value="dus"
                                        wire:model.change='jenis' wire:change='cariBarang'>
                                    <label class="form-check-label" for="Dus">
                                        Dus
                                    </label>
                                </div>
                            </div>
                            <div class="ms-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="Renteng" value="renteng"
                                        wire:model.change='jenis' wire:change='cariBarang'>
                                    <label class="form-check-label" for="Renteng">
                                        Pack
                                    </label>
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
                    <button wire:click='cancel' type="button" class="btn btn-md btn-inverse-danger ">Cancel</button>
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
                <h4 class="card-title">Data konfirmasi pembelian</h4>
                <p class="my-2 text-muted">Data ini temporary tidak akan masuk ke database selama belum di save
                </p>
                <div class="">
                    <label for="customer" class="form-label">Pilih Customer</label>
                    {{-- <input wire:model='namaCustomer' wire:change='searchCustomer' type="text"
                        class="form-control mb-2" placeholder="Cari customer...">
                    <select wire:model.change='customerId' class="form-select" id="dselect-example" required>
                        <option value="">---Pilih customer---</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->nama }}</option>
                        @endforeach
                    </select> --}}
                    <input type="text" wire:model='namaCustomer' wire:change='searchCustomer' class="form-control" list="exampleList" placeholder="Cari Customer">
                    <datalist id="exampleList">
                        @foreach ($customers as $customer)
                            <option wire:key='{{ $customer->id }}' value="{{ $customer->nama }}">
                        @endforeach
                    </datalist>
                    @error($customerId)
                        <p class="text-danger">Pilih Customer Dulu</p>
                    @enderror

                    <label class="form-label mt-3">Keterangan</label>
                    <textarea wire:model='keterangan' rows="3" class="form-control"></textarea>
                </div>
                <div class="p-2">
                    <button wire:click='simpan' class="btn btn-ms btn-inverse-success" type="button"> <span
                            wire:loading wire:target='simpan' class="spinner-grow spinner-grow-sm"></span>Simpan
                        Invoice</button>
                </div>





                <div class="mt-3">
                    @foreach ($dataPenjualan as $data)
                        <div wire:key='{{ $data['id'] }}' class="row">
                            <div class="col-6">
                                <p class="fw-bold">{{ $data['nama_barang'] }}</p>
                                <p class="text-muted">{{ $data['qty'] }}
                                    {{ $data['jenis'] == 'dus' ? 'Dos' : 'Pack' }} @
                                    {{ formatRupiah($data['harga_satuan']) }}</p>
                            </div>

                            <div class="col-6">
                                <p class="fw-bold">{{ formatRupiah($data['harga']) }}</p>
                                <div>
                                    <span wire:click='hapus("{{ $data['id'] }}")'
                                        wire:confirm='Apakah anda yakin ingin menghapus?' role="button"
                                        class="btn btn-sm btn-danger"><i class="mdi mdi-trash-can"></i></span>
                                </div>
                            </div>

                        </div>
                        <hr>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>

@push('script')
@endpush
