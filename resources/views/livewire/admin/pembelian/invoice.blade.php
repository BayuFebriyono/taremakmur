<div class="container">
    <div class="card">
        <div class="card-body">
            <p class="fs-5 fw-bold">Masukkan No Invoice anda</p>
            <p class="text-muted">Menu dibawah ini dugunakan untuk mencari no invoice yang sudah ada</p>
            <form class="mt-2">
                <div class="row">
                    <div class="col-md-10">
                        <input type="text" class="form-control" placeholder="Masukkan No Invoice Yang Sudah Ada">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-inverse-primary">Cari</button>
                    </div>
                </div>
            </form>
            <button type="button" class="btn btn-md btn-inverse-success">Atau buat invoice baru</button>
        </div>
    </div>


    {{-- Form Pembelian --}}
    <div class="card mt-3">
        <div class="card-body">
            <p class="fs-5 fw-bold">Form Pembelian Barang</p>
            <form action="">
                <div class="row mt-3">
                    <div class="col-md-6">
                        <label for="Suplier" class="form-label">Pilih Suplier</label>
                        <input type="text" class="form-control mb-2" placeholder="Cari suplier...">
                        <select class="form-select" required>
                            <option value="">---Pilih Suplier---</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="kodeBarang" class="form-label">Kode Barang</label>
                        <input type="text" class="form-control" placeholder="Masukkan kode barang" required>
                        <p class="fw-bold mt-1">Nama Barang :</p>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <label for="qty" class="form-label">Quantity</label>
                        <input type="number" id="qty" class="form-control" placeholder="masukkan quantity"
                            required>
                    </div>

                    <div class="col-md-6">
                        <label for="harga" class="form-label">Harga</label>
                        <input type="number" id="harga" class="form-control" placeholder="Masukkan harga" required>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <label for="Diskon" class="form-label">Diskon</label>
                        <input type="number" class="form-control" placeholder="Masukkan diskon" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-md btn-inverse-primary mt-2">Submit</button>
            </form>
        </div>
    </div>

    {{-- Table --}}
    <div class="card mt-4">
        <div class="card-body">
            <h4 class="card-title">Data konfirmasi pembelian</h4>
            <p class="my-2 text-muted">Data ini temporary tidak akan masuk ke database selama belum di save</p>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
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
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
