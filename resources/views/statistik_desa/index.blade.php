@extends('app.app', [
    'title' => 'Manajemen Statistik Desa/Kelurahan',
    'titlePage' => 'Halaman Manajemen Data Statistik Desa/Kelurahan',
    'sectionTitle' => "Manajemen Statistik Desa/Kelurahan",
    'sectionSubTitle' => 'Memanajemen data-data keseluruhan Statistik Desa/Kelurahan'
])

@section('page-header-actions')
  <a href="{{ route('admin.statistik.create') }}" class="btn btn-primary">
    <i class="fas fa-plus mr-1"></i>
    Tambah Statistik Desa/Kelurahan
  </a>
@endsection

@section('content')
    @if (Session::has('success'))
        <div class="alert alert-success mb-2">{{ Session::get('success') }}</div>
    @endif
    <div class="card">
        <div class="card-header row">
            <h4 class="col">Tabel Statistik Desa/Kelurahan</h4>
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
                            <th class="text-center" style="width: 80px">Tahun</th>
                            <th class="text-center">Desa/Kelurahan</th>
                            <th class="text-center" style="width: 80px">Luas (Km&sup2;)</th>
                            <th class="text-center" style="width: 80px">Jumlah<br>Laki-laki</th>
                            <th class="text-center" style="width: 80px">Jumlah<br>Perempuan</th>
                            <th class="text-center" style="width: 80px">Jumlah<br>Warga</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                        <th id="no">No.</th>
                        <th id="action">Aksi</th>
                        <th id="tahun">Tahun</th>
                        <th id="desa">Desa</th>
                        <th id="wilayah">Luas (Km&sup2;)</th>
                        <th id="lk">Jumlah Laki-laki</th>
                        <th id="lp">Jumlah Perempuan</th>
                        <th id="jumlah">Jumlah</th>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('js-extends')
    <script src="{{ asset('js/statistik/index.js') }}"></script>
@endsection