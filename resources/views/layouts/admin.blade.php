<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Dashboard | Whiskr</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
  
  @livewireStyles
  <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@livewireScripts
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
    
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <span class="nav-link text-gray">Halo, <b>{{ Auth::user()->name }}</b></span>
        </li>
    </ul>
  </nav>

  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="#" class="brand-link">
      <span class="brand-text font-weight-light font-weight-bold ml-3">🐾 Whiskr Admin</span>
    </a>

    <div class="sidebar">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          
          <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('admin.categories') }}" class="nav-link {{ request()->routeIs('admin.categories') ? 'active' : '' }}">
              <i class="nav-icon fas fa-tags"></i>
              <p>Kategori</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('admin.photos') }}" class="nav-link {{ request()->routeIs('admin.photos') ? 'active' : '' }}">
                <i class="nav-icon fas fa-images"></i>
                <p>Kelola Foto</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('admin.users') }}" class="nav-link {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                <i class="nav-icon fas fa-users"></i>
                <p>Manajemen User</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('admin.reports') }}" class="nav-link {{ request()->routeIs('admin.reports') ? 'active' : '' }}">
                <i class="nav-icon fas fa-exclamation-triangle text-warning"></i>
                <p>
                    Laporan Masuk
                    @php 
                        $count = \App\Models\Report::where('status', 'pending')->count(); 
                    @endphp
                    
                    @if($count > 0)
                        <span class="right badge badge-danger">{{ $count }}</span>
                    @endif
                </p>
            </a>
          </li>

          <li class="nav-header">AKSI</li>
          <li class="nav-item">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="nav-link bg-danger">
                    <i class="nav-icon fas fa-sign-out-alt"></i>
                    <p>Keluar</p>
                </a>
            </form>
          </li>

        </ul>
      </nav>
    </div>
  </aside>

  <div class="content-wrapper">
    {{ $slot }}
  </div>

  <footer class="main-footer">
    <strong>Copyright &copy; 2025 Whiskr - Pet Gallery.</strong>
  </footer>
</div>

<script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>

@livewireScripts
</body>
</html>