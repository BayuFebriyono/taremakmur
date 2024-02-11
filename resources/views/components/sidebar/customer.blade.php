<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a wire:navigate class="nav-link" href="/customer-order">
                <i class="mdi mdi-basket-fill"></i>
                <span class="menu-title">Order</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="/">
                <i class="mdi mdi-key-chain"></i>
                <span class="menu-title">Ganti Password</span>
            </a>
        </li>

        {{-- 
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#master-data" aria-expanded="false"
                aria-controls="master-data">
                <i class="men1u-icon mdi mdi-database-check"></i>
                <span class="menu-title">Pengaturan</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="master-data">
                <ul class="nav flex-column sub-menu">
                    <li  class="nav-item"> <a wire:navigate class="nav-link" href="/customer">Customer</a></li>
                    <li  class="nav-item"> <a wire:navigate class="nav-link" href="/suplier">Suplier</a></li>
                    <li  class="nav-item"> <a wire:navigate class="nav-link" href="/barang">Barang</a></li>
                </ul>
            </div>
        </li> --}}

        <livewire:auth.logout />

    </ul>
</nav>
