<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Desa;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Requests\DesaRequest;

class DesaController extends Controller
{
    public function index(){
        return view('desa.index');
    }

    public function create(){
        return view('desa.create');
    }

    public function store(DesaRequest $request){
        try{
            Desa::create([
                'kode' => $request->kode,
                'kabupaten' => $request->kabupaten,
                'kecamatan' => $request->kecamatan,
                'nama_desa' => $request->nama_desa,
                'alamat' => $request->alamat,
                'kepala_desa' => $request->kepala_desa,
                'kontak_kepala_desa' => $request->kontak_kepala_desa,
                'tipe' => $request->tipe,
            ]);
            return redirect(route('admin.desa.index'))->with('success', 'Sukses Menambahkan Data Desa/Kelurahan');
        }catch(Exception $e){
            return redirect(route('admin.desa.create'))->with('error', 'terjadi Kesalahan, Silahkan Coba Lagi!');
        }
    }

    public function edit($id){
        return view('desa.create',[
            'desa' => Desa::find($id)
        ]);
    }

    public function update(DesaRequest $request, $id){
        try{
            Desa::find($id)->update([
                'kode' => $request->kode,
                'kabupaten' => $request->kabupaten,
                'kecamatan' => $request->kecamatan,
                'nama_desa' => $request->nama_desa,
                'alamat' => $request->alamat,
                'kepala_desa' => $request->kepala_desa,
                'kontak_kepala_desa' => $request->kontak_kepala_desa,
                'tipe' => $request->tipe,
            ]);
            return redirect(route('admin.desa.index'))->with('success', 'Sukses Menambahkan Data Desa/Kelurahan');
        }catch(Exception $e){
            return redirect(route('admin.desa.edit', ['id' => $id]))->with('error', 'terjadi Kesalahan, Silahkan Coba Lagi!');
        }
    }

    public function delete($id){
        try{
            Desa::find($id)->delete();
            return response()->json([
                'status' => 'success',
                'title' => 'Sukses',
                'message' => 'Sukses Menghapus Desa/Kelurahan'
            ]);
        }catch(Exception $e){
            return response()->json([
                'status' => 'error',
                'title' => 'Gagal',
                'message' => 'Terjadi Kesalahan, Silahkan Coba Lagi!'
            ]);
        }
    }

    public function datatable(Request $request){
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
        $codeSearch = $request->columns[2]['search']['value'];
        if($codeSearch){
            $records = $records->where('kode', 'like', "%{$codeSearch}%");
        }

        $tipeSearch = $request->columns[3]['search']['value'];
        if($tipeSearch && $tipeSearch != "Semua"){
            $records = $records->where('tipe', $tipeSearch);
        }

        $desaSearch = $request->columns[4]['search']['value'];
        if($desaSearch){
            $records = $records->where('nama_desa', 'like', "%{$desaSearch}%");
        }

        $kabupatenSearch = $request->columns[5]['search']['value'];
        if($kabupatenSearch){
            $records = $records->where('kabupaten', 'like', "%{$kabupatenSearch}%");
        }

        $kecamatanSearch = $request->columns[6]['search']['value'];
        if($kecamatanSearch){
            $records = $records->where('kecamatan', 'like', "%{$kecamatanSearch}%");
        }

        $alamatSearch = $request->columns[7]['search']['value'];
        if($alamatSearch){
            $records = $records->where('alamat', 'like', "%{$alamatSearch}%");
        }

        $kepalaDesaSearch = $request->columns[8]['search']['value'];
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

    public function print(Request $request){
        $records = Desa::query();
        if($request->kode){
            $records = $records->where('kode', 'like', "%{$request->kode}%");
        }

        if($request->tipe && $request->tipe != "Semua"){
            $records = $records->where('tipe', $request->tipe);
        }

        if($request->desa){
            $records = $records->where('nama_desa', 'like', "%{$request->desa}%");
        }

        if($request->kabupaten){
            $records = $records->where('kabupaten', 'like', "%{$request->kabupaten}%");
        }

        if($request->kecamatan){
            $records = $records->where('kecamatan', 'like', "%{$request->kecamatan}%");
        }

        if($request->alamat){
            $records = $records->where('alamat', 'like', "%{$request->alamat}%");
        }

        if($request->kepala_desa){
            $records = $records->where('kepala_desa', 'like', "%{$request->kepala_desa}%");
            $records = $records->orwhere('kontak_kepala_desa', 'like', "%{$request->kepala_desa}%");
        }

        $pdf = Pdf::loadView('desa.pdf', [
            'desa' => $records->get()
        ]);

        return $pdf->stream('Laporan Daftar Desa/Kelurahan.pdf');
    }

    public function json(){
        return response()->json(Desa::orderBy('nama_desa')->get());
    }

    public function onlyDesaJson(){
        return response()->json(Desa::orderBy('nama_desa')->where('tipe', 'Desa')->get());
    }
}
