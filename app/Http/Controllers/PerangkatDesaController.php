<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Desa;
use Illuminate\Http\Request;
use App\Models\PerangkatDesa;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Requests\PerangkatDesaRequest;

class PerangkatDesaController extends Controller
{
    public function index(){
        return view('perangkat_desa.index');
    }

    public function create(){
        $desa = Desa::orderBy('nama_desa')->where('tipe', 'Desa')->get();
        return view('perangkat_desa.create', compact('desa'));
    }

    public function store(PerangkatDesaRequest $request){
        try{
            PerangkatDesa::create([
                'desa_id' => $request->desa,
                'jabatan' => $request->jabatan,
                'nama' => $request->nama,
                'kontak' => $request->kontak
            ]);
            return redirect(route('admin.perangkat.index'))->with('success', 'Sukses Menambahkan Data Perangkat Desa');
        }catch(Exception $e){
            return redirect(route('admin.perangkat.create'))->with('error', 'terjadi Kesalahan, Silahkan Coba Lagi!');
        }
    }

    public function edit($id){
        return view('perangkat_desa.create',[
            'desa' => Desa::orderBy('nama_desa')->where('tipe', 'Desa')->get(),
            'perangkat' => PerangkatDesa::find($id)
        ]);
    }

    public function update(Request $request, $id){
        try{
            PerangkatDesa::find($id)->update([
                'desa_id' => $request->desa,
                'jabatan' => $request->jabatan,
                'nama' => $request->nama,
                'kontak' => $request->kontak
            ]);
            return redirect(route('admin.perangkat.index'))->with('success', 'Sukses Mengubah Data Perangkat Desa');
        }catch(Exception $e){
            return redirect(route('admin.perangkat.create'))->with('error', 'terjadi Kesalahan, Silahkan Coba Lagi!');
        }
    }

    public function delete($id){
        try{
            PerangkatDesa::find($id)->delete();
            return response()->json([
                'status' => 'success',
                'title' => 'Sukses',
                'message' => 'Sukses Menghapus Desa'
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
        $desaSearch = $request->columns[2]['search']['value'];
        if($desaSearch){
            $records = $records->where('desa_id', $desaSearch);
        }

        $namaSearch = $request->columns[3]['search']['value'];
        if($namaSearch){
            $records = $records->where('nama', 'like', "%{$namaSearch}%");
        }

        $jabatanSearch = $request->columns[4]['search']['value'];
        if($jabatanSearch && $jabatanSearch != "SEMUA"){
            $records = $records->where('jabatan', $jabatanSearch);
        }

        $kontakSearch = $request->columns[5]['search']['value'];
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

    public function print(Request $request){
        $records = PerangkatDesa::with('desa');

        if($request->desa){
            $records = $records->where('desa_id', $request->desa);
        }

        if($request->nama){
            $records = $records->where('nama', 'like', "%{$request->nama}%");
        }

        if($request->jabatan && $request->jabatan != "SEMUA"){
            $records = $records->where('jabatan', $request->jabatan);
        }

        if($request->kontak){
            $records = $records->where('kontak', 'like', "%{$request->kontak}%");
        }

        $pdf = Pdf::loadView('perangkat_desa.pdf', [
            'perangkat_desa' => $records->get()
        ]);

        return $pdf->stream('Laporan Daftar Perangkat Desa.pdf');
    }
}
