@extends('app.app', [
    'title' => 'Manajemen Statistik Desa/Kelurahan',
    'titlePage' => 'Halaman Manajemen Data Statistik Desa/Kelurahan',
    'sectionTitle' => "Manajemen Statistik Desa/Kelurahan",
    'sectionSubTitle' => 'Memanajemen data-data keseluruhan Statistik Desa/Kelurahan'
])

@section('content')
    @if(Session::has('error'))
        <div class="alert alert-danger mb-2">{{ Session::get('error') }}</div>
    @endif
    <div class="card">
        <div class="card-header">
            <h4>Form Tambah Statistik Desa/Kelurahan</h4>
        </div>
        <form action="{{ URLHelper::has('edit') ? route('admin.statistik.update', ['id' => $statistik->id]) : route('admin.statistik.store') }}" method="POST">
            @csrf
            @if(URLHelper::has('edit'))
                @method('PUT')
            @endif

            <div class="card-body py-0 px-4">
                <div class="row">
                    <div class="form-group col">
                        <label><b>Desa/Kelurahan</b></label>
                        <select class="form-control select2 category-select @error('desa') is-invalid @enderror" name="desa">
                            <option value="" selected hidden>Pilih Desa/Kelurahan</option>
                            @foreach ($desa as $data)
                                <option value="{{ $data->id }}" @if($data->id == (old('desa') ?? $statistik->desa_id ?? '')) selected @endif>
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
                        <label><b>Luas (Km&sup2;)</b></label>
                        <input type="text" class="form-control @error('wilayah') is-invalid @enderror" name="wilayah" placeholder="Masukkan Luas Wilayah Desa/Kelurahan" value="{{ old('wilayah') ?? $statistik->luas_wilayah ?? '' }}">
                        @error('wilayah')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col">
                        <label><b>Tahun Pencatatan Statistik</b></label>
                        <input type="text" class="form-control @error('tahun') is-invalid @enderror" name="tahun" placeholder="Masukkan Tahun Pencatatan" value="{{ old('tahun') ?? $statistik->tahun ?? '' }}">
                        @error('tahun')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col">
                        <label><b>Jumlah Laki-laki</b></label>
                        <input type="text" class="form-control @error('lk') is-invalid @enderror" id="lk" name="lk" placeholder="Masukkan Jumlah Laki-laki" value="{{ old('lk') ?? $statistik->jumlah_lk ?? '' }}">
                        @error('lk')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col">
                        <label><b>Jumlah Perempuan</b></label>
                        <input type="text" class="form-control @error('perempuan') is-invalid @enderror" id="perempuan" name="perempuan" placeholder="Masukkan Jumlah Perempuan" value="{{ old('perempuan') ?? $statistik->jumlah_perempuan ?? '' }}">
                        @error('perempuan')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col">
                        <label><b>Jumlah</b></label>
                        <input type="text" class="form-control" id="jumlah" name="jumlah" value="{{ old('kk') ?? $statistik->jumlah_kk ?? '' }}" readonly>
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

  <script>
    document.addEventListener("DOMContentLoaded", function(){
        for (var id of ['lk', 'perempuan']) {
            document.getElementById(id).addEventListener('keyup', function(){
                var lk = document.getElementById('lk').value;
                var perempuan = document.getElementById('perempuan').value;

                if(!lk){
                    lk = 0;
                }

                if(!perempuan){
                    perempuan = 0;
                }

                document.getElementById('jumlah').value = parseInt(lk) + parseInt(perempuan);
            });
        }
    });
  </script>
@endsection