@extends('app.app', [
    'title' => 'Manajemen Kegiatan Desa',
    'titlePage' => 'Halaman Manajemen Data Kegiatan Desa',
    'sectionTitle' => "Manajemen Kegiatan Desa",
    'sectionSubTitle' => 'Memanajemen data-data keseluruhan Kegiatan Desa'
])

@section('page-header-actions')
  <a href="{{ route('admin.kegiatan.create') }}" class="btn btn-primary">
    <i class="fas fa-plus mr-1"></i>
    Tambah Kegiatan
  </a>
@endsection

@section('content')
    @if (Session::has('success'))
        <div class="alert alert-success mb-2">{{ Session::get('success') }}</div>
    @endif
    <div class="card">
        <div class="card-header row">
            <h4 class="col">Tabel Kegiatan Desa</h4>
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
                            <th class="text-center">Tahun<br>Kegiatan</th>
                            <th class="text-center">Desa</th>
                            <th class="text-center">Nama Kegiatan</th>
                            <th class="text-center">Pagu (Rp)</th>
                            <th class="text-center">Realisasi (Rp)</th>
                            <th class="text-center">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                        <th id="no">No.</th>
                        <th id="action">Aksi</th>
                        <th id="tahun">Tahun Kegiatan</th>
                        <th id="desa">Desa</th>
                        <th id="nama">Nama Kegiatan</th>
                        <th id="pagu">Pagu</th>
                        <th id="realisasi">Realisasi</th>
                        <th id="keterangan">Keterangan</th>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('js-extends')
    <script src="{{ asset('js/kegiatan/index.js') }}"></script>
@endsection