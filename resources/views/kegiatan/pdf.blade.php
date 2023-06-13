@extends('app.pdf_template', ['title' => $title])

@section('content')
    <table class="border-table">
        <tr>
            <th class="text-center">No</th>
            <th class="text-center">Tahun</th>
            <th class="text-center">Desa</th>
            <th class="text-center">Kegiatan</th>
            <th class="text-center">Pagu (Rp)</th>
            <th class="text-center">Realisasi (Rp)</th>
            <th class="text-center">Keterangan</th>
        </tr>
        @foreach ($kegiatan as $index => $data)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">{{ $data->tahun }}</td>
                <td>{{ $data->desa->nama_desa }}</td>
                <td>{{ $data->kegiatan }}</td>
                <td class="text-right">{{ $data->pagu }}</td>
                <td class="text-right">{{ $data->realisasi }}</td>
                <td>{{ $data->keterangan }}</td>
            </tr>
        @endforeach
    </table>
@endsection