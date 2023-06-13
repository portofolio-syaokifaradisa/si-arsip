@extends('app.app', [
    'title' => 'Manajemen Pegawai',
    'titlePage' => 'Halaman Manajemen Data Pegawai',
    'sectionTitle' => "Manajemen Pegawai",
    'sectionSubTitle' => 'Memanajemen data-data keseluruhan pegawai'
])

@section('content')
    @if(Session::has('error'))
        <div class="alert alert-danger mb-2">{{ Session::get('error') }}</div>
    @endif
    <div class="card">
        <div class="card-header">
            <h4>Form Tambah Pegawai</h4>
        </div>
        <form action="{{ URLHelper::has('edit') ? route('superadmin.pegawai.update', ['id' => $pegawai->id]) : route('superadmin.pegawai.store') }}" method="POST" enctype='multipart/form-data' id="form-insitu-order">
            @csrf
            @if(URLHelper::has('edit'))
                @method('PUT')
            @endif

            <div class="card-body py-0 px-4">
                <div class="row">
                    <div class="form-group col">
                        <label><b>Nama Lengkap</b></label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" placeholder="Masukkan Nama Lengkap Pegawai" value="{{ old('nama') ?? $pegawai->nama ?? '' }}">
                        @error('nama')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col">
                        <label><b>NIP</b></label>
                        <input type="text" class="form-control @error('nip') is-invalid @enderror" name="nip" placeholder="Masukkan NIP Pegawai" value="{{ old('nip') ?? $pegawai->nip ?? '' }}">
                        @error('nip')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col">
                        <label><b>Golongan</b></label>
                        <input type="text" class="form-control @error('golongan') is-invalid @enderror" name="golongan" placeholder="Masukkan Golongan Pegawai" value="{{ old('golongan') ?? $pegawai->golongan ?? '' }}">
                        @error('golongan')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col">
                        <label><b>Nama Golongan</b></label>
                        <input type="text" class="form-control @error('nama_golongan') is-invalid @enderror" name="nama_golongan" placeholder="Masukkan Nama Golongan Pegawai" value="{{ old('nama_golongan') ?? $pegawai->nama_golongan ?? '' }}">
                        @error('nama_golongan')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col">
                        <label><b>Jabatan</b></label>
                        <input type="text" class="form-control @error('jabatan') is-invalid @enderror" name="jabatan" placeholder="Masukkan Jabatan Pegawai" value="{{ old('jabatan') ?? $pegawai->jabatan ?? '' }}">
                        @error('jabatan')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col">
                        <label><b>Unit Kerja</b></label>
                        <input type="text" class="form-control @error('unit_kerja') is-invalid @enderror" name="unit_kerja" placeholder="Masukkan Unit Kerja Pegawai" value="{{ old('unit_kerja') ?? $pegawai->unit_kerja ?? '' }}">
                        @error('unit_kerja')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="card-footer text-right">
                <button class="btn btn-primary px-3">
                    <i class="fas fa-save mr-1"></i>
                    Simpan
                </button>
            </div>
        </form>
  </div>
@endsection