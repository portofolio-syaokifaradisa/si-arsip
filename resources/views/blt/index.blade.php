@extends('app.app', [
    'title' => 'Manajemen Data Penerima BLT',
    'titlePage' => 'Halaman Manajemen Data Penerima BLT',
    'sectionTitle' => "Manajemen Data Penerima BLT",
    'sectionSubTitle' => 'Memanajemen data-data keseluruhan Penerima BLT'
])

@section('page-header-actions')
  <a href="{{ route('admin.blt.create') }}" class="btn btn-primary">
    <i class="fas fa-plus mr-1"></i>
    Tambah Penerima BLT
  </a>
@endsection

@section('content')
    @if (Session::has('success'))
        <div class="alert alert-success mb-2">{{ Session::get('success') }}</div>
    @endif
    <div class="card">
        <div class="card-header row">
            <h4 class="col">Tabel Penerima BLT</h4>
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
                            <th class="text-center">Tahun</th>
                            <th class="text-center">Desa</th>
                            <th class="text-center">Penerima</th>
                            <th class="text-center">Tanggal<br>Lahir</th>
                            <th class="text-center">RT</th>
                            <th class="text-center">RW</th>
                            <th class="text-center">Mekanisme<br>Pembayaran</th>
                            <th class="text-center">Jumlah<br>Bantuan (Rp)</th>
                            <th class="text-center">Bukti Terima</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                        <th id="no">No.</th>
                        <th id="action">Aksi</th>
                        <th id="tahun">Tahun</th>
                        <th id="desa">Desa</th>
                        <th id="penerima">Penerima</th>
                        <th id="ttl">Tanggal Lahir</th>
                        <th id="rt">RT</th>
                        <th id="rw">RW</th>
                        <th id="mekanisme_pembayaran">Mekanisme Pembayaran</th>
                        <th id="jumlah">Jumlah Bantuan (Rp)</th>
                        <th id="bukti_terima">Bukti Terima</th>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('js-extends')
    <script src="{{ asset('js/blt/index.js') }}"></script>
@endsection