<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">Stisla</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">Stisla</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="nav-item  {{ $type_menu === 'dashboard' ? 'active' : '' }}">
                <a href="#"
                    class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a>
            </li>
            <li class="nav-item dropdown {{ $type_menu === 'data' ? 'active' : '' }}">
                <a href="#"
                    class="nav-link has-dropdown"><i class="fas fa-stethoscope"></i><span>Master Data</span></a>
                <ul class="dropdown-menu">
                    <li class='{{ Request::is('obat') ? 'active' : '' }}'>
                        <a class="nav-link"
                            href="{{ url('/obat') }}">Obat</a>
                    </li>
                    <li class='{{ Request::is('kategori') ? 'active' : '' }}'>
                        <a class="nav-link"
                            href="{{ url('/kategori') }}">Kategori</a>
                    </li>
                    <li class='{{ Request::is('unit') ? 'active' : '' }}'>
                        <a class="nav-link"
                            href="{{ url('/unit') }}">Unit</a>
                    </li>
                    <li class='{{ Request::is('pemasok') ? 'active' : '' }}'>
                        <a class="nav-link"
                            href="{{ url('/pemasok') }}">Pemasok</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown {{ $type_menu === 'transaksi' ? 'active' : '' }}">
                <a href="#"
                    class="nav-link has-dropdown"><i class="fa-solid fa-money-bill"></i><span>Transaksi</span></a>
                <ul class="dropdown-menu">
                    <li class='{{ Request::is('detailpembelian') ? 'active' : '' }}'>
                        <a class="nav-link"
                            href="{{ url('/detailpembelian') }}">Pembelian</a>
                    </li>
                    <li class='{{ Request::is('detailpenjualan') ? 'active' : '' }}'>
                        <a class="nav-link"
                            href="{{ url('/detailpenjualan') }}">Penjualan</a>
                    </li>
                </ul>
            </li>
            <li class="menu-header">Error</li>
            <li class="nav-item dropdown {{ $type_menu === 'error' ? 'active' : '' }}">
                <a href="#"
                    class="nav-link has-dropdown"><i class="fas fa-exclamation"></i>
                    <span>Errors</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('error-403') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ url('error-403') }}">403</a>
                    </li>
                    <li class="{{ Request::is('error-404') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ url('error-404') }}">404</a>
                    </li>
                    <li class="{{ Request::is('error-500') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ url('error-500') }}">500</a>
                    </li>
                    <li class="{{ Request::is('error-503') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ url('error-503') }}">503</a>
                    </li>
                </ul>
            </li>
        </ul>

        <div class="hide-sidebar-mini mt-4 mb-4 p-3">
            <a href="https://docs.getstisla.com/"
                class="btn btn-primary btn-lg btn-block btn-icon-split">
                <i class="fas fa-rocket"></i> Documentation
            </a>
        </div>
    </aside>
</div>
