<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>{{ $title ?? '' }}</title>

  {{-- Package Utama Stisla --}}
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  
  {{-- Datatables --}}
  <link rel="stylesheet" href="{{ asset('vendor/datatables/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendor/datatables/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">

  {{-- Stisla --}}
  <link rel="stylesheet" href="{{ asset('vendor/stisla/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('vendor/stisla/css/components.css') }}">

  <link rel="icon" type="image/png" href="{{ asset('logo.png') }}" />

  @yield('meta-extends')
</head>

<body>
  <div id="app">
    <div class="main-wrapper">
      <div class="navbar-bg"></div>
      @include('app.topbar')
      <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="{{ route('login') }}">Si - Arsip</a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">....</a>
          </div>
            @include('app.sidebar')
        </aside>
      </div>

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{ $titlePage ?? '' }}</h1>
            <div class="section-header-breadcrumb">
              @yield('page-header-actions')
            </div>
          </div>

          <div class="section-body">
            <h2 class="section-title">{{ $sectionTitle ?? '' }}</h2>
            <p class="section-lead">{{ $sectionSubTitle ?? '' }}</p>

            <div class="row">
              <div class="col-12">
                @yield('content')
              </div>
            </div>
          </div>
        </section>
      </div>
      <footer class="main-footer">
        <div class="footer-right">
          Copyright &copy; 2022 <div class="bullet"></div> Stisla</a>
        </div>
      </footer>
    </div>
  </div>

  @yield('modal-extends')
  
  {{-- Package Utama Stisla --}}
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  
  {{-- Stisla --}}
  <script src="{{ asset('vendor/stisla/js/stisla.js') }}"></script>
  <script src="{{ asset('vendor/stisla/js/scripts.js') }}"></script>
  
  {{-- Datatables --}}
  <script src="{{ asset('vendor/datatables/datatables/media/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('vendor/datatables/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('vendor/datatables/datatables.net-select-bs4/js/select.bootstrap4.min.js') }}"></script>

  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="{{ asset('js/utils/alert.js') }}"></script>
  <script src="{{ asset('js/utils/upload-form.js') }}"></script>

  {{-- Penambahan Script --}}
  @yield('js-extends')
</body>
</html>