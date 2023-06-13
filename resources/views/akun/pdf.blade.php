@extends('app.pdf_template', ['title' => 'Laporan Daftar Akun'])

@section('content')
    <table class="border-table">
        <tr>
            <th class="text-center">No</th>
            <th class="text-center">Pegawai</th>
            <th class="text-center">Jabatan</th>
            <th class="text-center">Golongan</th>
            <th class="text-center">Unit Kerja</th>
            <th class="text-center">Email</th>
        </tr>
        @foreach ($akun as $index => $data)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>
                    {{ $data->pegawai->nama }} <br>
                    {{ "NIP. ".$data->pegawai->nip }}
                </td>
                <td>{{ $data->pegawai->jabatan }}</td>
                <td>
                    {{ $data->pegawai->golongan }} <br>
                    {{ $data->pegawai->nama_golongan }} 
                </td>
                <td>{{ $data->pegawai->unit_kerja }}</td>
                <td>{{ $data->email }}</td>
            </tr>
        @endforeach
    </table>
@endsection