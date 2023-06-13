@extends('app.app', [
    'title' => 'Manajemen Akun',
    'titlePage' => 'Halaman Manajemen Data Akun',
    'sectionTitle' => "Manajemen Akun",
    'sectionSubTitle' => 'Memanajemen data-data Keseluruhan Akun'
])

@section('content')
<div class="card">
    <div class="card-header">
      <h4>Form Tambah Akun</h4>
    </div>
    <form action="{{ URLHelper::has('edit') ? route('superadmin.akun.update', ['id' => $akun->id]) : route('superadmin.akun.store') }}" method="POST" enctype='multipart/form-data' id="form-insitu-order">
      @csrf
      @if(URLHelper::has('edit'))
        @method('PUT')
      @endif

      <div class="card-body py-0 px-4">
        <div class="row">
            <div class="form-group col">
                <label><b>Pegawai</b></label>
                <select class="form-control select2 category-select @error('pegawai') is-invalid @enderror" name="pegawai">
                    <option value="" selected hidden>Pilih Pegawai</option>
                    @foreach ($pegawai as $data)
                      <option value="{{ $data->id }}" @if($data->id == (old('pegawai') ?? $akun->pegawai_id ?? '')) selected @endif>
                        {{ $data->nama }}
                    </option>
                    @endforeach
                </select>
                @error('pegawai')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group col">
                <label><b>Email</b></label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Masukkan Email Akun" value="{{ old('email') ?? $akun->email ?? '' }}">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="form-group col">
                <label><b>Password</b></label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Masukkan Password Akun">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group col">
                <label><b>Konfirmasi Password</b></label>
                <input type="password" class="form-control @error('confirmation_password') is-invalid @enderror" name="confirmation_password" placeholder="Masukkan Konfirmasi Password">
                @error('confirmation_password')
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