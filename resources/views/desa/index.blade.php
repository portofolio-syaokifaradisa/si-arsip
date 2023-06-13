@extends('app.app', [
    'title' => 'Manajemen Desa/Kelurahan',
    'titlePage' => 'Halaman Manajemen Data Desa/Kelurahan',
    'sectionTitle' => "Manajemen Desa/Kelurahan",
    'sectionSubTitle' => 'Memanajemen data-data keseluruhan Desa/Kelurahan'
])

@section('page-header-actions')
  <a href="{{ route('admin.desa.create') }}" class="btn btn-primary">
    <i class="fas fa-plus mr-1"></i>
    Tambah Desa/Kelurahan
  </a>
@endsection

@section('content')
    @if (Session::has('success'))
        <div class="alert alert-success mb-2">{{ Session::get('success') }}</div>
    @endif
    <div class="card">
        <div class="card-header row">
            <h4 class="col">Tabel Desa/Kelurahan</h4>
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
                            <th class="text-center">Kode</th>
                            <th class="text-center">Tipe</th>
                            <th class="text-center">Desa/Kelurahan</th>
                            <th class="text-center">Kabupaten</th>
                            <th class="text-center">Kecamatan</th>
                            <th class="text-center">Alamat</th>
                            <th class="text-center">Kepala<br>Desa/Lurah</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                        <th id="no">No.</th>
                        <th id="action">Aksi</th>
                        <th id="kode">Kode Desa/Kelurahan</th>
                        <th id="tipe">Tipe</th>
                        <th id="desa">Desa/Kelurahan</th>
                        <th id="kabupaten">Kabupaten</th>
                        <th id="kecamatan">Kecamatan</th>
                        <th id="alamat">Alamat</th>
                        <th id="kepala_desa">Kepala Desa/Lurah</th>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('js-extends')
    <script src="{{ asset('js/desa/index.js') }}"></script>
@endsection