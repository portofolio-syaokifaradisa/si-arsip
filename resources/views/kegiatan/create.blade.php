@extends('app.app', [
    'title' => 'Manajemen Kegiatan Desa',
    'titlePage' => 'Halaman Manajemen Data Kegiatan Desa',
    'sectionTitle' => "Manajemen Kegiatan Desa",
    'sectionSubTitle' => 'Memanajemen data-data keseluruhan Kegiatan Desa'
])

@section('content')
    @if(Session::has('error'))
        <div class="alert alert-danger mb-2">{{ Session::get('error') }}</div>
    @endif
    <div class="card">
        <div class="card-header">
            <h4>Form Tambah Kegiatan Desa</h4>
        </div>
        <form action="{{ URLHelper::has('edit') ? route('admin.kegiatan.update', ['id' => $kegiatan->id]) : route('admin.kegiatan.store') }}" method="POST" enctype='multipart/form-data' id="form-insitu-order">
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
                                <option value="{{ $data->id }}" @if($data->id == (old('desa') ?? $kegiatan->desa_id ?? '')) selected @endif>
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
                        <label><b>Nama Kegiatan</b></label>
                        <input type="text" class="form-control @error('kegiatan') is-invalid @enderror" name="kegiatan" placeholder="Masukkan Nama Kegiatan Desa/Kelurahan" value="{{ old('kegiatan') ?? $kegiatan->kegiatan ?? '' }}">
                        @error('kegiatan')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col">
                        <label><b>Pagu (Rp)</b></label>
                        <input type="text" class="form-control @error('pagu') is-invalid @enderror" name="pagu" placeholder="Masukkan Pagu kegiatan" value="{{ old('pagu') ?? $kegiatan->pagu ?? '' }}">
                        @error('pagu')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col">
                        <label><b>Realisasi (Rp)</b></label>
                        <input type="text" class="form-control @error('realisasi') is-invalid @enderror" name="realisasi" placeholder="Masukkan Realisasi Kegiatan" value="{{ old('realisasi') ?? $kegiatan->realisasi ?? '' }}">
                        @error('realisasi')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col">
                        <label><b>Tahun Kegiatan</b></label>
                        <input type="text" class="form-control @error('tahun') is-invalid @enderror" name="tahun" placeholder="Masukkan Tahun kegiatan" value="{{ old('tahun') ?? $kegiatan->tahun ?? '' }}">
                        @error('tahun')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col">
                        <label><b>Keterangan</b></label>
                        <textarea class="form-control @error('keterangan') is-invalid @enderror" name="keterangan">{{ old('keterangan') ?? $kegiatan->keterangan ?? '' }}</textarea>
                        @error('keterangan')
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