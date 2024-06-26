<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        {{-- <li class="nav-item">
            <a class="nav-link" href="../index.html">
                <i class="mdi mdi-grid-large menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li> --}}

        @if (auth()->user()->level == 'super_admin')
            <li class="nav-item">
                <a wire:navigate class="nav-link" href="/dashboard">
                    <i class="mdi mdi-speedometer menu-icon"></i>
                    <span class="menu-title">Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#master-data" aria-expanded="false"
                    aria-controls="master-data">
                    <i class="menu-icon mdi mdi-database-check"></i>
                    <span class="menu-title">Master Data</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="master-data">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a wire:navigate class="nav-link" href="/customer">Customer</a></li>
                        <li class="nav-item"> <a wire:navigate class="nav-link" href="/suplier">Suplier</a></li>
                        <li class="nav-item"> <a wire:navigate class="nav-link" href="/barang">Barang</a></li>
                        <li class="nav-item"> <a wire:navigate class="nav-link" href="/users">User</a></li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#transaksiPembelian" aria-expanded="false"
                    aria-controls="transaksiPembelian">
                    <i class="menu-icon mdi mdi-basket-fill"></i>
                    <span class="menu-title">Pembelian</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="transaksiPembelian">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a wire:navigate class="nav-link" href="/pembelian-invoice">Invoice</a>
                        </li>
                        <li class="nav-item"> <a wire:navigate class="nav-link" href="/pembelian-history">Riwayat</a>
                        </li>

                    </ul>
                </div>
            </li>
        @endif

        @if (auth()->user()->level == 'super_admin' || auth()->user()->level == 'admin')
            <li class="nav-item">
                <a wire:navigate class="nav-link" href="/stock-barang">
                    <i class="mdi mdi-archive-check menu-icon"></i>
                    <span class="menu-title">Stok Barang</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#transaksiPenjualan" aria-expanded="false"
                    aria-controls="transaksiPenjualan">
                    <i class="menu-icon mdi mdi-cart-arrow-right"></i>
                    <span class="menu-title">Penjualan</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="transaksiPenjualan">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a wire:navigate class="nav-link" href="/penjualan-invoice">Nota
                                Penjualan</a>
                        </li>
                        <li class="nav-item"> <a wire:navigate class="nav-link" href="/persetujuan">Perlu
                                Persetujuan</a></li>
                        <li class="nav-item"> <a wire:navigate class="nav-link" href="/penjualan-history">Riwayat</a>
                        </li>

                    </ul>
                </div>
            </li>
        @endif

        @if (auth()->user()->level == 'super_admin')
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#report" aria-expanded="false"
                    aria-controls="report">
                    <i class="menu-icon mdi mdi-chart-bar"></i>
                    <span class="menu-title">Report</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="report">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a wire:navigate class="nav-link" href="/report">Report Qty</a></li>

                    </ul>
                </div>
            </li>
        @endif



        <livewire:auth.logout />

    </ul>
</nav>
