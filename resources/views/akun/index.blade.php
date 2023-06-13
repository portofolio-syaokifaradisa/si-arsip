@extends('app.app', [
    'title' => 'Manajemen Akun',
    'titlePage' => 'Halaman Manajemen Data Akun',
    'sectionTitle' => "Manajemen Akun",
    'sectionSubTitle' => 'Memanajemen data-data keseluruhan Akun'
])

@section('page-header-actions')
  <a href="{{ route('superadmin.akun.create') }}" class="btn btn-primary">
    <i class="fas fa-plus mr-1"></i>
    Tambah Akun
  </a>
@endsection

@section('content')
    @if (Session::has('success'))
        <div class="alert alert-success mb-2">{{ Session::get('success') }}</div>
    @endif
    <div class="card">
        <div class="card-header row">
            <h4 class="col">Tabel Akun Admin</h4>
            <div class="col">
                <button class="btn btn-outline-primary float-right" id="print">
                    <i class="fas fa-print mr-2"></i> Cetak Laporan
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered w-100" id="datatable">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 15px">No</th>
                            <th class="text-center">Aksi</th>
                            <th class="text-center">Pemegang Akun</th>
                            <th class="text-center">NIP</th>
                            <th class="text-center">Email</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                        <th id="no">No.</th>
                        <th id="action">Aksi</th>
                        <th id="nama">Nama Lengkap</th>
                        <th id="nip">NIP</th>
                        <th id="email">Email</th>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('js-extends')
    <script src="{{ asset('js/akun/index.js') }}"></script>
@endsection