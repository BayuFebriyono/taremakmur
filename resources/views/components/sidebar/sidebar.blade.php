<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        {{-- <li class="nav-item">
            <a class="nav-link" href="../index.html">
                <i class="mdi mdi-grid-large menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li> --}}


        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false"
                aria-controls="ui-basic">
                <i class="men1u-icon mdi mdi-database-check"></i>
                <span class="menu-title">Master Data</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                    <li  class="nav-item"> <a wire:navigate class="nav-link" href="/customer">Customer</a></li>
                    <li  class="nav-item"> <a wire:navigate class="nav-link" href="/suplier">Suplier</a></li>
                    <li  class="nav-item"> <a wire:navigate class="nav-link" href="/barang">Barang</a></li>
                </ul>
            </div>
        </li>


        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false"
                aria-controls="ui-basic">
                <i class="men1u-icon mdi mdi-cash-multiple"></i>
                <span class="menu-title">Transaksi</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                    <li  class="nav-item"> <a wire:navigate class="nav-link" href="/pembelian">Pembelian</a></li>
                  
                </ul>
            </div>
        </li>

        <livewire:auth.logout />

    </ul>
</nav>
