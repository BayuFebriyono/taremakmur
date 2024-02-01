<div>
    <p class="fs-6 fw-bold">Data Konfirmasi Penjualan</p>

    <div class="mt-3">
        <button wire:click='add' class="btn btn-sm btn-primary">Tambahkan Data</button>
        <button wire:click='showExcel()' class="btn btn-sm btn-success"><i class="mdi mdi-file-excel"></i>&nbsp;Import
            Penjualan</button>
    </div>

    {{-- Modal Add Penjualan --}}
    @if ($showModal)
        <div class="card mt-3">
            <div class="card-body">
                <form>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="noNota" class="form-label">No Nota</label>
                            <input type="text" class="form-control" value="{{ uniqid() }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="KodeBarang" class="form-label">Kode Barang</label>
                            <input type="text" class="form-control" required>
                            <p class="fs-6 fw-bold mt-1">Nama Barang :</p>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="Quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="Harga" class="form-label">Harga</label>
                            <select class="form-select" required>
                                <option value="" selected>---Pilih Harga---</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="Diskon" class="form-label">Diskon</label>
                            <input type="number" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="Toko" class="form-label">Toko</label>
                            <input type="text" class="form-control" required>
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

                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                <button wire:click='save' class="btn btn-success">Save</button>
                <button wire:click='delete' class="btn btn-danger">Delete</button>
            </div>

        </div>
    </div>
</div>
