@extends('app.pdf_template', ['title' => 'Laporan Daftar Perangkat Desa'])

@section('content')
    <table class="border-table">
        <tr>
            <th class="text-center">No</th>
            <th class="text-center">Desa</th>
            <th class="text-center">Nama Lengkap</th>
            <th class="text-center">Kontak</th>
            <th class="text-center">Jabatan</th>
        </tr>
        @foreach ($perangkat_desa as $index => $data)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $data->desa->nama_desa }}</td>
                <td class="text-center">{{ $data->nama }}</td>
                <td class="text-center">{{ $data->kontak }}</td>
                <td class="text-center">{{ $data->jabatan }}</td>
            </tr>
        @endforeach
    </table>
@endsection