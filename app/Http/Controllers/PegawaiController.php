<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Requests\PegawaiRequest;

class PegawaiController extends Controller
{
    public function index(){
        return view('pegawai.index');
    }

    public function create(){
        return view('pegawai.create');
    }

    public function store(PegawaiRequest $request){
        try{
            Pegawai::create([
                'nama' => $request->nama,
                'nip' => $request->nip,
                'golongan' => $request->golongan,
                'nama_golongan' => $request->nama_golongan,
                'jabatan' => $request->jabatan,
                'unit_kerja' => $request->unit_kerja,
            ]);
            return redirect(route('superadmin.pegawai.index'))->with('success', 'Sukses Menambahkan Data Pegawai!');
        }catch(Exception $e){
            return redirect(route('superadmin.pegawai.create'))->with('error', 'Terjadi Kesalahan Silahkan Coba Lagi!');
        }
    }

    public function edit($id){
        $pegawai = Pegawai::find($id);
        return view('pegawai.create', [
            'pegawai' => $pegawai
        ]);
    }

    public function update(PegawaiRequest $request, $id){
        try{
            Pegawai::find($id)->update([
                'nama' => $request->nama,
                'nip' => $request->nip,
                'golongan' => $request->golongan,
                'nama_golongan' => $request->nama_golongan,
                'jabatan' => $request->jabatan,
                'unit_kerja' => $request->unit_kerja,
            ]);
            return redirect(route('superadmin.pegawai.index'))->with('success', 'Sukses Menambahkan Data Pegawai!');
        }catch(Exception $e){
            return redirect(route('superadmin.pegawai.create'))->with('error', 'Terjadi Kesalahan Silahkan Coba Lagi!');
        }
    }

    public function delete($id){
        try{
            User::where('pegawai_id', $id)->delete();
            Pegawai::find($id)->delete();
            return response()->json([
                'status' => 'success',
                'title' => 'Sukses',
                'message' => 'Sukses Menghapus Pegawai'
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
        $NameSearch = $request->columns[2]['search']['value'];
        if($NameSearch){
            $records = $records->where('nama', 'like', "%{$NameSearch}%");
        }

        $nipSearch = $request->columns[3]['search']['value'];
        if($nipSearch){
            $records = $records->where('nip', 'like', "%{$nipSearch}%");
        }

        $jabatanSearch = $request->columns[4]['search']['value'];
        if($jabatanSearch){
            $records = $records->where('jabatan', 'like', "%{$jabatanSearch}%");
        }

        $golonganSearch = $request->columns[5]['search']['value'];
        if($golonganSearch){
            $records = $records->where('golongan', 'like', "%{$golonganSearch}%");
        }

        $unitKerjaSearch = $request->columns[6]['search']['value'];
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

    public function print(Request $request){
        $records = Pegawai::where('nama', '!=' , "Superadmin");

        if($request->nama){
            $records = $records->where('nama', 'like', "%{$request->nama}%");
        }

        if($request->nip){
            $records = $records->where('nip', 'like', "%{$request->nip}%");
        }

        if($request->jabatan){
            $records = $records->where('jabatan', 'like', "%{$request->jabatan}%");
        }

        if($request->golongan){
            $records = $records->where('golongan', 'like', "%{$request->golongan}%");
        }

        if($request->unit_kerja){
            $records = $records->where('unit_kerja', 'like', "%{$request->unit_kerja}%");
        }

        $pdf = Pdf::loadView('pegawai.pdf', [
            'pegawai' => $records->get()
        ]);

        return $pdf->stream('Laporan Daftar Pegawai.pdf');
    }
}