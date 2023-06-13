@extends('app.pdf_template', ['title' => $title])

@section('content')
    <table class="border-table">
        <tr>
            <th class="text-center" rowspan="2">No</th>
            <th class="text-center" rowspan="2">Tahun</th>
            <th class="text-center" rowspan="2">Desa</th>
            <th class="text-center" rowspan="2">Luas Wilayah (Km&sup2;)</th>
            <th class="text-center" colspan="3">Jumlah</th>
        </tr>
        <tr>
            <th class="text-center">Laki-laki</th>
            <th class="text-center">Perempuan</th>
            <th class="text-center">Warga</th>
        </tr>
        @foreach ($statistik as $index => $data)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">{{ $data->tahun }}</td>
                <td>{{ $data->desa->nama_desa }}</td>
                <td class="text-center">{{ $data->luas_wilayah }}</td>
                <td class="text-center">{{ $data->jumlah_lk }}</td>
                <td class="text-center">{{ $data->jumlah_perempuan }}</td>
                <td class="text-center">{{ $data->jumlah }}</td>
            </tr>
        @endforeach
    </table>
@endsection