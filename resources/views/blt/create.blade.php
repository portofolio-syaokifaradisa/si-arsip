@extends('app.app', [
    'title' => 'Manajemen Data Penerima BLT',
    'titlePage' => 'Halaman Manajemen Data Penerima BLT',
    'sectionTitle' => "Manajemen Data Penerima BLT",
    'sectionSubTitle' => 'Memanajemen data-data keseluruhan Penerima BLT'
])

@section('content')
    @if(Session::has('error'))
        <div class="alert alert-danger mb-2">{{ Session::get('error') }}</div>
    @endif
    <div class="card">
        <div class="card-header">
            <h4>Form Tambah Penerima BLT</h4>
        </div>
        <form action="{{ URLHelper::has('edit') ? route('admin.blt.update', ['id' => $blt->id]) : route('admin.blt.store') }}" method="POST" enctype='multipart/form-data'>
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
                                <option value="{{ $data->id }}" @if($data->id == (old('desa') ?? $blt->desa_id ?? '')) selected @endif>
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
                        <label><b>Tahun BLT</b></label>
                        <input type="text" class="form-control @error('tahun') is-invalid @enderror" name="tahun" placeholder="Masukkan Periode Tahun BLT" value="{{ old('tahun') ?? $blt->tahun ?? '' }}">
                        @error('tahun')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="row col">
                        <div class="form-group col">
                            <label><b>Nama Penerima</b></label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" placeholder="Masukkan Nama Lengkap Penerima BLT" value="{{ old('nama') ?? $blt->nama ?? '' }}">
                            @error('nama')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col">
                            <label><b>NIK Penerima</b></label>
                            <input type="text" class="form-control @error('nik') is-invalid @enderror" name="nik" placeholder="Masukkan NIK Penerima BLT" value="{{ old('nik') ?? $blt->nik ?? '' }}">
                            @error('nik')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group col">
                        <label><b>Tanggal Lahir Penerima</b></label>
                        <input type="date" class="form-control @error('ttl') is-invalid @enderror" name="ttl" value="{{ old('ttl') ?? $blt->tanggal_lahir ?? '' }}">
                        @error('ttl')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="row col">
                        <div class="form-group col">
                            <label><b>RT</b></label>
                            <input type="text" class="form-control @error('rt') is-invalid @enderror" name="rt" placeholder="Masukkan RT Penerima BLT" value="{{ old('rt') ?? $blt->rt ?? '' }}">
                            @error('rt')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col">
                            <label><b>RW</b></label>
                            <input type="text" class="form-control @error('rw') is-invalid @enderror" name="rw" placeholder="Masukkan RW Penerima BLT" value="{{ old('rw') ?? $blt->rw ?? '' }}">
                            @error('rw')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group col">
                        <label><b>Mekanisme Pembayaran</b></label>
                        <input type="text" class="form-control @error('mekanisme_pembayaran') is-invalid @enderror" name="mekanisme_pembayaran" placeholder="Masukkan Mekanisme Pembayaran" value="{{ old('mekanisme_pembayaran') ?? $blt->mekanisme_pembayaran ?? '' }}">
                        @error('mekanisme_pembayaran')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col">
                        <label><b>Jumlah Penerimaan (Rp)</b></label>
                        <input type="text" class="form-control @error('jumlah') is-invalid @enderror" name="jumlah" placeholder="Masukkan Mekanisme Pembayaran" value="{{ old('jumlah') ?? $blt->jumlah ?? '' }}">
                        @error('jumlah')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col">
                        <label><b>Bukti Tanda Penerimaan</b></label>
                        <div class="custom-file">
                            <input type="file" name="tanda_terima" class="custom-file-input @error('tanda_terima') is-invalid @enderror" id="uploaded-file-form">
                            <label class="custom-file-label" for="uploaded-file-form" id="uploaded-file-label">Choose file</label>
                            @if ($errors->has('tanda_terima'))
                                <span class="invalid-feedback" role="alert" style="margin-top: 12px">
                                    <strong>{{ $errors->get('tanda_terima')[0] }}</strong>
                                </span>
                            @endif
                        </div>
                        @if($blt->tanda_terima ?? false)
                            <small>
                            <br>
                            Bukti Tanda Terima Sebelumnya Dapat dilihat di <a href="{{ asset('img/tanda_terima_blt/'. $blt->tahun.'/'.$blt->tanda_terima) }}" target="_blank">disini</a>. (Kosongkan jika tidak ingin mengupdate bukti terima)
                            </small>
                        @endif
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