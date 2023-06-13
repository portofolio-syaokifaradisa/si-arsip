@extends('app.pdf_template', ['title' => $title])

@section('content')
    <table class="border-table">
        <tr>
            <th class="text-center">No</th>
            <th class="text-center">Tahun</th>
            <th class="text-center">Asal</th>
            <th class="text-center">Penerima</th>
            <th class="text-center">Detail<br>Bantuan</th>
            <th class="text-center">Tanda<br>Terima</th>
        </tr>
        @foreach ($blt as $index => $data)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">{{ $data->tahun }}</td>
                <td>
                    {{ $data->desa->nama_desa }} <br>
                    {{ "RT " . $data->rt." RW ".$data->rw }}
                </td>
                <td>
                    {{ $data->nama }} <br>
                    {{ $data->nik }} <br>
                    TTL : {{ $data->tanggal_lahir }}
                </td>
                <td>
                    Rp{{ $data->jumlah }} <br>
                    {{ $data->mekanisme_pembayaran }}
                </td>
                <td class="text-center" style="padding-bottom: 10px; padding-top: 10px">
                    <img src="{{ asset('img/tanda_terima_blt/' . $data->tahun . '/' . $data->tanda_terima) }}" style="width: 230px">
                </td>
            </tr>
        @endforeach
    </table>
@endsection