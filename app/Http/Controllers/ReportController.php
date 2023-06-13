<?php

namespace App\Http\Controllers;

use App\Models\Blt;
use App\Models\Desa;
use App\Models\User;
use App\Models\Pegawai;
use App\Models\Kependudukan;
use Illuminate\Http\Request;
use App\Models\KegiatanFisik;
use App\Models\PerangkatDesa;

class ReportController extends Controller
{
    public function pegawai(){
        return view('report.pegawai');
    }

    public function pegawaiDatatable(Request $request){
        /* ================== [1] Persiapan Pengambilan Data ================== */
        $startNumber = $request->start;
        $rowperpage = $request->length;
        $records = Pegawai::where('nama', '!=' , "Superadmin");

        /* ================== [2] Sorting Kolom ================== */
        $sortColumnIndex = $request->order[0]['column'];
        $sortColumnName = $request->columns[$sortColumnIndex]['data'];
        $sortType = $request->order[0]['dir'];
        if($sortColumnName === "no"){
            $records = $records->orderBy('golongan', 'DESC');
        }else{
            $records = $records->orderBy($sortColumnName, $sortType);
        }

        /* ================== [3] Individual Search ================== */
        $NameSearch = $request->columns[1]['search']['value'];
        if($NameSearch){
            $records = $records->where('nama', 'like', "%{$NameSearch}%");
        }

        $nipSearch = $request->columns[2]['search']['value'];
        if($nipSearch){
            $records = $records->where('nip', 'like', "%{$nipSearch}%");
        }

        $jabatanSearch = $request->columns[3]['search']['value'];
        if($jabatanSearch){
            $records = $records->where('jabatan', 'like', "%{$jabatanSearch}%");
        }

        $golonganSearch = $request->columns[4]['search']['value'];
        if($golonganSearch){
            $records = $records->where('golongan', 'like', "%{$golonganSearch}%");
        }

        $unitKerjaSearch = $request->columns[5]['search']['value'];
        if($unitKerjaSearch){
            $records = $records->where('unit_kerja', 'like', "%{$unitKerjaSearch}%");
        }

        /* ================== [4] Pengambilan Data ================== */
        $totalRecordswithFilter = $records->count();
        $totalRecord = Pegawai::where('nama', '!=' , "Superadmin")->count();
        $records = $records->skip($startNumber)->take($rowperpage)->get();

        /* ================== [7] Memformat Data ================== */
        $data_arr = array();
        foreach($records as $index => $record){
            $data_arr[] = array(
                "id" => $record->id,
                "no" => $startNumber + $index + 1,
                "nama" => $record->nama,
                "nip" => $record->nip,
                "jabatan" => $record->jabatan,
                "golongan" => $record->golongan,
                "unit_kerja" => $record->unit_kerja
            );
        }

        /* ================== [8] Mengirim JSON ================== */
        echo json_encode([
            "draw" => intval($request->draw),
            "iTotalRecords" => $totalRecord,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        ]);
    }

    public function desa(){
        return view('report.desa');
    }

    public function desaDatatable(Request $request){
        /* ================== [1] Persiapan Pengambilan Data ================== */
        $startNumber = $request->start;
        $rowperpage = $request->length;
        $records = Desa::query();

        /* ================== [2] Sorting Kolom ================== */
        $sortColumnIndex = $request->order[0]['column'];
        $sortColumnName = ["no", "action", "kode", 'nama_desa', "kabupaten", "kecamatan", "alamat", 'kepala_desa'][$sortColumnIndex];
        $sortType = $request->order[0]['dir'];
        if($sortColumnName === "no"){
            $records = $records->orderBy('kode', 'ASC');
        }else{
            $records = $records->orderBy($sortColumnName, $sortType);
        }

        /* ================== [3] Individual Search ================== */
        $codeSearch = $request->columns[1]['search']['value'];
        if($codeSearch){
            $records = $records->where('kode', 'like', "%{$codeSearch}%");
        }

        $tipeSearch = $request->columns[2]['search']['value'];
        if($tipeSearch && $tipeSearch != "Semua"){
            $records = $records->where('tipe', $tipeSearch);
        }

        $desaSearch = $request->columns[3]['search']['value'];
        if($desaSearch){
            $records = $records->where('nama_desa', 'like', "%{$desaSearch}%");
        }

        $kabupatenSearch = $request->columns[4]['search']['value'];
        if($kabupatenSearch){
            $records = $records->where('kabupaten', 'like', "%{$kabupatenSearch}%");
        }

        $kecamatanSearch = $request->columns[5]['search']['value'];
        if($kecamatanSearch){
            $records = $records->where('kecamatan', 'like', "%{$kecamatanSearch}%");
        }

        $alamatSearch = $request->columns[6]['search']['value'];
        if($alamatSearch){
            $records = $records->where('alamat', 'like', "%{$alamatSearch}%");
        }

        $kepalaDesaSearch = $request->columns[7]['search']['value'];
        if($kepalaDesaSearch){
            $records = $records->where('kepala_desa', 'like', "%{$kepalaDesaSearch}%");
            $records = $records->orwhere('kontak_kepala_desa', 'like', "%{$kepalaDesaSearch}%");
        }

        /* ================== [4] Pengambilan Data ================== */
        $totalRecordswithFilter = $records->count();
        $totalRecord = Desa::count();
        $records = $records->skip($startNumber)->take($rowperpage)->get();

        /* ================== [7] Memformat Data ================== */
        $data_arr = array();
        foreach($records as $index => $record){
            $data_arr[] = array(
                "id" => $record->id,
                "no" => $startNumber + $index + 1,
                "desa" => $record->nama_desa,
                "kode" => $record->kode,
                "tipe" => $record->tipe,
                "alamat" => $record->alamat,
                "golongan" => $record->golongan,
                "kepala_desa" => $record->kepala_desa,
                'kontak_kepala_desa' => $record->kontak_kepala_desa,
                "kabupaten" => $record->kabupaten,
                "kecamatan" => $record->kecamatan
            );
        }

        /* ================== [8] Mengirim JSON ================== */
        echo json_encode([
            "draw" => intval($request->draw),
            "iTotalRecords" => $totalRecord,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        ]);
    }

    public function statistik(){
        return view('report.statistik');
    }

    public function statistikDatatable(Request $request){
        /* ================== [1] Persiapan Pengambilan Data ================== */
        $startNumber = $request->start;
        $rowperpage = $request->length;
        $records = Kependudukan::join('desas', 'desas.id', '=', 'kependudukans.desa_id')->select('kependudukans.*', 'desas.nama_desa');

        /* ================== [2] Sorting Kolom ================== */
        $sortColumnIndex = $request->order[0]['column'];
        $sortColumnName = ["no", "action", "tahun", 'desa_id', "luas_wilayah", "jumlah_lk", "jumlah_perempuan", 'jumlah_kk'][$sortColumnIndex];
        $sortType = $request->order[0]['dir'];
        if($sortColumnName === "no"){
            $records = $records->orderBy('tahun', 'DESC')->orderBy('desas.nama_desa', 'ASC');
        }else{
            $records = $records->orderBy($sortColumnName, $sortType);
        }

        /* ================== [3] Individual Search ================== */
        $tahunSearch = $request->columns[1]['search']['value'];
        if($tahunSearch){
            $records = $records->where('tahun', 'like', "%{$tahunSearch}%");
        }
        
        $desaSearch = $request->columns[2]['search']['value'];
        if($desaSearch){
            $records = $records->where('desa_id', $desaSearch);
        }

        $luasWilayahSearch = $request->columns[3]['search']['value'];
        if($luasWilayahSearch){
            $records = $records->where('luas_wilayah', 'like', "%{$luasWilayahSearch}%");
        }

        $lkSearch = $request->columns[4]['search']['value'];
        if($lkSearch){
            $records = $records->where('jumlah_lk', 'like', "%{$lkSearch}%");
        }

        $perempuanSearch = $request->columns[5]['search']['value'];
        if($perempuanSearch){
            $records = $records->where('jumlah_perempuan', 'like', "%{$perempuanSearch}%");
        }

        $kkSearch = $request->columns[6]['search']['value'];
        if($kkSearch){
            $records = $records->where('jumlah', 'like', "%{$kkSearch}%");
        }

        /* ================== [4] Pengambilan Data ================== */
        $totalRecordswithFilter = $records->count();
        $totalRecord = Kependudukan::count();
        $records = $records->skip($startNumber)->take($rowperpage)->get();

        /* ================== [7] Memformat Data ================== */
        $data_arr = array();
        foreach($records as $index => $record){
            $data_arr[] = array(
                "id" => $record['id'],
                "no" => $startNumber + $index + 1,
                'tahun' => $record->tahun,
                "desa" => $record->desa->nama_desa,
                'wilayah' => $record->luas_wilayah,
                'lk' => $record->jumlah_lk,
                'lp' => $record->jumlah_perempuan,
                'jumlah' => $record->jumlah
            );
        }

        /* ================== [8] Mengirim JSON ================== */
        echo json_encode([
            "draw" => intval($request->draw),
            "iTotalRecords" => $totalRecord,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        ]);
    }

    public function perangkat(){
        return view('report.perangkat');
    }

    public function perangkatDatatable(Request $request){
        /* ================== [1] Persiapan Pengambilan Data ================== */
        $startNumber = $request->start;
        $rowperpage = $request->length;
        $records = PerangkatDesa::join('desas', 'desas.id', '=', 'perangkat_desas.desa_id')->select('perangkat_desas.*', 'desas.nama_desa');

        /* ================== [2] Sorting Kolom ================== */
        $sortColumnIndex = $request->order[0]['column'];
        $sortColumnName = ["no", "action", "desa_id", 'nama', "jabatan", "kontak"][$sortColumnIndex];
        $sortType = $request->order[0]['dir'];
        if($sortColumnName === "no"){
            $records = $records->orderBy('desas.nama_desa', 'ASC');
        }else{
            $records = $records->orderBy($sortColumnName, $sortType);
        }

        /* ================== [3] Individual Search ================== */
        $desaSearch = $request->columns[1]['search']['value'];
        if($desaSearch){
            $records = $records->where('desa_id', $desaSearch);
        }

        $namaSearch = $request->columns[2]['search']['value'];
        if($namaSearch){
            $records = $records->where('nama', 'like', "%{$namaSearch}%");
        }

        $jabatanSearch = $request->columns[3]['search']['value'];
        if($jabatanSearch && $jabatanSearch != "SEMUA"){
            $records = $records->where('jabatan', $jabatanSearch);
        }

        $kontakSearch = $request->columns[4]['search']['value'];
        if($kontakSearch){
            $records = $records->where('kontak', 'like', "%{$kontakSearch}%");
        }

        /* ================== [4] Pengambilan Data ================== */
        $totalRecordswithFilter = $records->count();
        $totalRecord = PerangkatDesa::count();
        $records = $records->skip($startNumber)->take($rowperpage)->get();

        /* ================== [7] Memformat Data ================== */
        $data_arr = array();
        foreach($records as $index => $record){
            $data_arr[] = array(
                "id" => $record->id,
                "no" => $startNumber + $index + 1,
                "desa" => $record->desa->nama_desa,
                'nama' => $record->nama,
                'jabatan' => $record->jabatan,
                'kontak' => $record->kontak,
            );
        }

        /* ================== [8] Mengirim JSON ================== */
        echo json_encode([
            "draw" => intval($request->draw),
            "iTotalRecords" => $totalRecord,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        ]);
    }

    public function kegiatan(){
        return view('report.kegiatan');
    }

    public function kegiatanDatatable(Request $request){
        /* ================== [1] Persiapan Pengambilan Data ================== */
        $startNumber = $request->start;
        $rowperpage = $request->length;
        $records = KegiatanFisik::join('desas', 'desas.id', '=', 'kegiatan_fisiks.desa_id')->select('kegiatan_fisiks.*', 'desas.nama_desa');

        /* ================== [2] Sorting Kolom ================== */
        $sortColumnIndex = $request->order[0]['column'];
        $sortColumnName = ["no", "action", "tahun", 'desa_id', "kegiatan", "pagu", "realisasi", "keterangan"][$sortColumnIndex];
        $sortType = $request->order[0]['dir'];
        if($sortColumnName === "no"){
            $records = $records->orderBy('desas.nama_desa', 'ASC')->orderBy("tahun", 'DESC');
        }else{
            $records = $records->orderBy($sortColumnName, $sortType);
        }

        /* ================== [3] Individual Search ================== */
        $tahunSearch = $request->columns[1]['search']['value'];
        if($tahunSearch){
            $records = $records->where('tahun', 'like', "%{$tahunSearch}%");
        }
        
        $desaSearch = $request->columns[2]['search']['value'];
        if($desaSearch){
            $records = $records->where('desa_id', $desaSearch);
        }

        $kegiatanSearch = $request->columns[3]['search']['value'];
        if($kegiatanSearch){
            $records = $records->where('kegiatan', 'like', "%{$kegiatanSearch}%");
        }

        $paguSearch = $request->columns[4]['search']['value'];
        if($paguSearch){
            $records = $records->where('pagu', 'like', "%{$paguSearch}%");
        }

        $realisasiSearch = $request->columns[5]['search']['value'];
        if($realisasiSearch){
            $records = $records->where('realisasi', 'like', "%{$realisasiSearch}%");
        }

        $keteranganSearch = $request->columns[6]['search']['value'];
        if($keteranganSearch){
            $records = $records->where('keterangan', 'like', "%{$keteranganSearch}%");
        }

        /* ================== [4] Pengambilan Data ================== */
        $totalRecordswithFilter = $records->count();
        $totalRecord = KegiatanFisik::count();
        $records = $records->skip($startNumber)->take($rowperpage)->get();

        /* ================== [7] Memformat Data ================== */
        $data_arr = array();
        foreach($records as $index => $record){
            $data_arr[] = array(
                "id" => $record->id,
                "no" => $startNumber + $index + 1,
                "desa" => $record->desa->nama_desa,
                'nama' => $record->kegiatan,
                'pagu' => $record->pagu,
                'realisasi' => $record->realisasi ?? '-',
                'keterangan' => $record->keterangan ?? '-',
                'tahun' => $record->tahun
            );
        }

        /* ================== [8] Mengirim JSON ================== */
        echo json_encode([
            "draw" => intval($request->draw),
            "iTotalRecords" => $totalRecord,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        ]);
    }

    public function blt(){
        return view('report.blt');
    }

    public function bltDatatable(Request $request){
        /* ================== [1] Persiapan Pengambilan Data ================== */
        $startNumber = $request->start;
        $rowperpage = $request->length;
        $records = Blt::join('desas', 'desas.id', '=', 'blts.desa_id')->select('blts.*', 'desas.nama_desa');

        /* ================== [2] Sorting Kolom ================== */
        $sortColumnIndex = $request->order[0]['column'];
        $sortColumnName = ["no", "action", "tahun", 'desa_id', "nama", "tanggal_lahir", "rt", "rw", "mekanisme_pembayaran"][$sortColumnIndex];
        $sortType = $request->order[0]['dir'];
        if($sortColumnName === "no"){
            $records = $records->orderBy('desas.nama_desa', 'ASC');
        }else{
            $records = $records->orderBy($sortColumnName, $sortType);
        }

        /* ================== [3] Individual Search ================== */
        $tahunSearch = $request->columns[1]['search']['value'];
        if($tahunSearch){
            $records = $records->where('tahun', 'like', "%{$tahunSearch}%");
        }

        $desaSearch = $request->columns[2]['search']['value'];
        if($desaSearch){
            $records = $records->where('desa_id', $desaSearch);
        }
        
        $receiveSearch = $request->columns[3]['search']['value'];
        if($receiveSearch){
            $records = $records->where('nama', 'like', "%{$receiveSearch}%");
            $records = $records->orwhere('nik', 'like', "%{$receiveSearch}%");
        }

        $ttlSearch = $request->columns[4]['search']['value'];
        if($ttlSearch){
            $records = $records->where('tanggal_lahir', $ttlSearch);
        }

        $rtSearch = $request->columns[5]['search']['value'];
        if($rtSearch){
            $records = $records->where('RT', 'like', "%{$rtSearch}%");
        }

        $rwSearch = $request->columns[6]['search']['value'];
        if($rwSearch){
            $records = $records->where('RW', 'like', "%{$rwSearch}%");
        }

        $jumlahSearch = $request->columns[7]['search']['value'];
        if($jumlahSearch){
            $records = $records->where('jumlah', 'like', "%{$jumlahSearch}%");
        }

        $paymentSearch = $request->columns[8]['search']['value'];
        if($paymentSearch){
            $records = $records->where('mekanisme_pembayaran', 'like', "%{$paymentSearch}%");
        }

        /* ================== [4] Pengambilan Data ================== */
        $totalRecordswithFilter = $records->count();
        $totalRecord = Blt::count();
        $records = $records->skip($startNumber)->take($rowperpage)->get();

        /* ================== [7] Memformat Data ================== */
        $data_arr = array();
        foreach($records as $index => $record){
            $data_arr[] = array(
                "id" => $record->id,
                "no" => $startNumber + $index + 1,
                'tahun' => $record->tahun,
                "desa" => $record->desa->nama_desa,
                'nama' => $record->nama,
                'nik' => $record->nik,
                'rt' => $record->rt,
                'rw' => $record->rw,
                'mekanisme_pembayaran' => $record->mekanisme_pembayaran,
                'tanggal_lahir' => $record->tanggal_lahir,
                'jumlah' => $record->jumlah,
                'bukti_terima' => asset('img/tanda_terima_blt/'.$record->tahun.'/'.$record->tanda_terima),
            );
        }

        /* ================== [8] Mengirim JSON ================== */
        echo json_encode([
            "draw" => intval($request->draw),
            "iTotalRecords" => $totalRecord,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        ]);
    }
}
