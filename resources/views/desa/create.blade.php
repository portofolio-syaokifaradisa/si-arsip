@extends('app.app', [
    'title' => 'Manajemen Desa/Kelurahan',
    'titlePage' => 'Halaman Manajemen Data Desa/Kelurahan',
    'sectionTitle' => "Manajemen Desa/Kelurahan",
    'sectionSubTitle' => 'Memanajemen data-data keseluruhan desa/kelurahan'
])

@section('content')
    @if(Session::has('error'))
        <div class="alert alert-danger mb-2">{{ Session::get('error') }}</div>
    @endif
    <div class="card">
        <div class="card-header">
            <h4>Form Tambah Desa/Kelurahan</h4>
        </div>
        <form action="{{ URLHelper::has('edit') ? route('admin.desa.update', ['id' => $desa->id]) : route('admin.desa.store') }}" method="POST">
            @csrf
            @if(URLHelper::has('edit'))
                @method('PUT')
            @endif

            <div class="card-body py-0 px-4">
                <div class="row">
                    <div class="form-group col-6">
                        <label><b>Kode Desa/Kelurahan</b></label>
                        <input type="text" class="form-control @error('kode') is-invalid @enderror" name="kode" placeholder="Masukkan Kode Desa/Kelurahan" value="{{ old('kode') ?? $desa->kode ?? '' }}">
                        @error('kode')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-6 row">
                        <div class="form-group col">
                            <label><b>Nama Desa/Kelurahan</b></label>
                            <input type="text" class="form-control @error('nama_desa') is-invalid @enderror" name="nama_desa" placeholder="Masukkan Nama Desa/Kelurahan" value="{{ old('nama_desa') ?? $desa->nama_desa ?? '' }}">
                            @error('nama_desa')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col">
                            <label><b>Tipe</b></label>
                            <select class="form-control select2 category-select @error('tipe') is-invalid @enderror" name="tipe">
                                <option value="" selected hidden>Pilih Tipe</option>
                                @foreach (['Desa', 'Kelurahan'] as $tipe)
                                    <option value="{{ $tipe }}" @if($tipe == (old('tipe') ?? $desa->tipe ?? '')) selected @endif>
                                        {{ $tipe }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tipe')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col">
                        <label><b>Kecamatan</b></label>
                        <input type="text" class="form-control @error('kecamatan') is-invalid @enderror" name="kecamatan" placeholder="Masukkan Kecamatan Desa/Kelurahan" value="{{ old('kecamatan') ?? $desa->kecamatan ?? '' }}">
                        @error('kecamatan')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col">
                        <label><b>Kabupaten</b></label>
                        <input type="text" class="form-control @error('kabupaten') is-invalid @enderror" name="kabupaten" placeholder="Masukkan Kabupaten Desa/Kelurahan" value="{{ old('kabupaten') ?? $desa->kabupaten ?? '' }}">
                        @error('kabupaten')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label><b>Alamat Kantor Desa/Kelurahan</b></label>
                    <textarea class="form-control @error('alamat') is-invalid @enderror" name="alamat">{{ old('alamat') ?? $desa->alamat ?? '' }}</textarea>
                    @error('alamat')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="row">
                    <div class="form-group col">
                        <label><b>Nama Kepala Desa/Lurah</b></label>
                        <input type="text" class="form-control @error('kepala_desa') is-invalid @enderror" name="kepala_desa" placeholder="Masukkan Nama Lengkap Kepala Desa/Lurah" value="{{ old('kepala_desa') ?? $desa->kepala_desa ?? '' }}">
                        @error('kepala_desa')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col">
                        <label><b>Kontak Kepala Desa/Lurah</b></label>
                        <input type="text" class="form-control @error('kontak_kepala_desa') is-invalid @enderror" name="kontak_kepala_desa" placeholder="Masukkan Kontak Kepala Desa/Lurah" value="{{ old('kontak_kepala_desa') ?? $desa->kontak_kepala_desa ?? '' }}">
                        @error('kontak_kepala_desa')
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