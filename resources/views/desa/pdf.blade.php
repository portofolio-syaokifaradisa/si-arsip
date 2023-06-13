@extends('app.pdf_template', ['title' => 'Laporan Daftar Desa/Kelurahan'])

@section('content')
    <table class="border-table">
        <tr>
            <th class="text-center">No</th>
            <th class="text-center">Kode</th>
            <th class="text-center">Desa/Kelurahan</th>
            <th class="text-center">Alamat Kantor</th>
            <th class="text-center">Kepala Desa/Lurah</th>
        </tr>
        @foreach ($desa as $index => $data)
            <tr>
                <td class="text-center align-middle">{{ $index + 1 }}</td>
                <td class="align-middle text-center">{{ $data['kode'] }}</td>
                <td class="align-middle text-center">{{ $data['tipe'] . " ". $data['nama_desa'] }}</td>
                <td class="align-middle">
                    {{ $data['alamat'] }} <br>
                    {{ "Kabupaten " . $data['kabupaten'] }} <br>
                    {{ "Kecamatan " . $data['kecamatan'] }}
                </td>
                <td class="align-middle">
                    {{ $data['kepala_desa'] }} <br>
                    {{ $data['kontak_kepala_desa'] }}
                </td>
            </tr>
        @endforeach
    </table>
@endsection