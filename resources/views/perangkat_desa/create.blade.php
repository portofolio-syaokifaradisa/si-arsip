@extends('app.app', [
    'title' => 'Manajemen Perangkat Desa',
    'titlePage' => 'Halaman Manajemen Data Perangkat Desa',
    'sectionTitle' => "Manajemen Perangkat Desa",
    'sectionSubTitle' => 'Memanajemen data-data keseluruhan Perangkat Desa'
])

@section('content')
    @if(Session::has('error'))
        <div class="alert alert-danger mb-2">{{ Session::get('error') }}</div>
    @endif
    <div class="card">
        <div class="card-header">
            <h4>Form Tambah Perangkat Desa</h4>
        </div>
        <form action="{{ URLHelper::has('edit') ? route('admin.perangkat.update', ['id' => $perangkat->id]) : route('admin.perangkat.store') }}" method="POST" enctype='multipart/form-data' id="form-insitu-order">
            @csrf
            @if(URLHelper::has('edit'))
                @method('PUT')
            @endif

            <div class="card-body py-0 px-4">
                <div class="row">
                    <div class="form-group col">
                        <label><b>Desa</b></label>
                        <select class="form-control select2 category-select @error('desa') is-invalid @enderror" name="desa">
                            <option value="" selected hidden>Pilih Desa</option>
                            @foreach ($desa as $data)
                                <option value="{{ $data->id }}" @if($data->id == (old('desa') ?? $perangkat->desa_id ?? '')) selected @endif>
                                    {{ $data->nama_desa }}
                                </option>
                            @endforeach
                        </select>
                        @error('desa')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col">
                        <label><b>Jabatan</b></label>
                        <select class="form-control select2 category-select @error('jabatan') is-invalid @enderror" name="jabatan">
                            <option value="" selected hidden>Pilih Jabatan</option>
                            @foreach (['Sekretaris Desa', 'Kaur Umum', 'Kaur Perencanaan Keuangan', 'Kasi Pemerintahan', 'Kasi Pelayanan dan Kesejahteraan'] as $data)
                                <option value="{{ $data }}" @if($data == (old('desa') ?? $perangkat->jabatan ?? '')) selected @endif>
                                    {{ $data }}
                                </option>
                            @endforeach
                        </select>
                        @error('jabatan')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col">
                        <label><b>Nama Lengkap</b></label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" placeholder="Masukkan Nama Lengkap" value="{{ old('nama') ?? $perangkat->nama ?? '' }}">
                        @error('nama')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col">
                        <label><b>Kontak</b></label>
                        <input type="text" class="form-control @error('kontak') is-invalid @enderror" name="kontak" placeholder="Masukkan Kontak" value="{{ old('kontak') ?? $perangkat->kontak ?? '' }}">
                        @error('kontak')
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