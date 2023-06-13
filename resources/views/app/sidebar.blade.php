<ul class="sidebar-menu">
    @if(Auth::user()->role === "Superadmin")
        <li class="menu-header">Data Master</li>
        <li class="@if(URLHelper::has('pegawai') && !URLHelper::has('report')) active @endif">
            <a class="nav-link" href="{{ route('superadmin.pegawai.index') }}">
                <i class="fas fa-users"></i>
                <span>Pegawai</span>
            </a>
        </li>
        <li class="@if(URLHelper::has('akun') && !URLHelper::has('report')) active @endif">
            <a class="nav-link" href="{{ route('superadmin.akun.index') }}">
                <i class="fas fa-user-circle"></i>
                <span>Akun</span>
            </a>
        </li>
    @endif    
    <li class="menu-header">Data Desa/Kelurahan</li>
    <li class="@if(URLHelper::has('desa') && !URLHelper::has('report')) active @endif">
        <a class="nav-link" href="{{ route('admin.desa.index') }}">
            <i class="fas fa-city"></i>
            <span>Desa/Kelurahan</span>
        </a>
    </li>
    <li class="@if(URLHelper::has('statistik') && !URLHelper::has('report')) active @endif">
        <a class="nav-link" href="{{ route('admin.statistik.index') }}">
            <i class="fas fa-chart-bar"></i>
            <span>Statistik Desa/Kelurahan</span>
        </a>
    </li>
    

    <li class="menu-header">Data Desa</li>
    <li class="@if(URLHelper::has('perangkat') && !URLHelper::has('report')) active @endif">
        <a class="nav-link" href="{{ route('admin.perangkat.index') }}">
            <i class="fas fa-sitemap"></i>
            <span>Perangkat Desa</span>
        </a>
    </li>
    <li class="@if(URLHelper::has('kegiatan') && !URLHelper::has('report')) active @endif">
        <a class="nav-link" href="{{ route('admin.kegiatan.index') }}">
            <i class="fas fa-tasks"></i>
            <span>Kegiatan Desa</span>
        </a>
    </li>
    <li class="@if(URLHelper::has('blt') && !URLHelper::has('report')) active @endif">
        <a class="nav-link" href="{{ route('admin.blt.index') }}">
            <i class="fas fa-hand-holding-usd"></i>
            <span>Penerima BLT DD</span>
        </a>
    </li>

    <li class="menu-header">Laporan</li>
    <li class="nav-item dropdown @if(URLHelper::has('report')) active @endif">
        <a href="#" class="nav-link has-dropdown">
            <i class="fas fa-file-alt"></i>
            <span>Laporan</span>
        </a>
        <ul class="dropdown-menu">
            <li class="@if(URLHelper::has('report') && URLHelper::has('pegawai')) active @endif">
                <a class="nav-link" href="{{ route('report.pegawai') }}">Pegawai</a>
            </li>
            <li class="@if(URLHelper::has('report') && URLHelper::has('desa')) active @endif">
                <a class="nav-link" href="{{ route('report.desa') }}">Desa/Kelurahan</a>
            </li>
            <li class="@if(URLHelper::has('report') && URLHelper::has('statistik')) active @endif">
                <a class="nav-link" href="{{ route('report.statistik') }}">Statistik Desa/Kelurahan</a>
            </li>
            <li class="@if(URLHelper::has('report') && URLHelper::has('perangkat')) active @endif">
                <a class="nav-link" href="{{ route('report.perangkat') }}">Perangkat Desa</a>
            </li>
            <li class="@if(URLHelper::has('report') && URLHelper::has('kegiatan')) active @endif">
                <a class="nav-link" href="{{ route('report.kegiatan') }}">Kegiatan Desa</a>
            </li>
            <li class="@if(URLHelper::has('report') && URLHelper::has('blt')) active @endif">
                <a class="nav-link" href="{{ route('report.blt') }}">Penerima BLT DD</a>
            </li>
        </ul>
    </li>
</ul>