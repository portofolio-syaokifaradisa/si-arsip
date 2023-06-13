@extends('app.pdf_template', ['title' => 'Laporan Daftar Pegawai'])

@section('content')
    <table class="border-table">
        <tr>
            <th class="text-center">No</th>
            <th class="text-center">Pegawai</th>
            <th class="text-center">Jabatan</th>
            <th class="text-center">Golongan</th>
            <th class="text-center">Unit Kerja</th>
        </tr>
        @foreach ($pegawai as $index => $data)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>
                    {{ $data['nama'] }} <br>
                    {{ "NIP. ".$data['nip'] }}
                </td>
                <td>{{ $data['jabatan'] }}</td>
                <td>
                    {{ $data['golongan'] }} <br>
                    {{ $data['nama_golongan'] }}
                </td>
                <td>{{ $data['unit_kerja'] }}</td>
            </tr>
        @endforeach
    </table>
@endsection