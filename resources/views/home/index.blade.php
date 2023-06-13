@extends('app.app', [
    'title' => 'Si - ARSIP',
    'titlePage' => 'Si - ARSIP',
    'sectionTitle' => "Aplikasi Pengarsipan",
    'sectionSubTitle' => 'Memanajemen data-data desa/kelurahan'
])

@section('content')
    <div class="card py-5">
        <div class="card-body text-center py-5">
            <h2 class="text-primary">Halo {{ Auth::user()->pegawai->nama }}, Selamat Datang di <br>Aplikasi Pengarsipan Desa dan Kelurahan</h2>
            <h1 class="text-primary">Si-ARSIP</h1>
        </div>
    </div>
@endsection