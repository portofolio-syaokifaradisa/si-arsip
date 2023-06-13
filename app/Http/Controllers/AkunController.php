<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Requests\AkunRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\EditAkunRequest;

class AkunController extends Controller
{
    public function index(){
        return view('akun.index');
    }

    public function create(){
        $pegawai = Pegawai::where('nama', '!=', 'Superadmin')->doesntHave('user')->orderBy('nama')->get();
        return view('akun.create', compact('pegawai'));
    }

    public function store(AkunRequest $request){
        try{
            User::create([
                'pegawai_id' => $request->pegawai,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);
            return redirect(route('superadmin.akun.index'))->with('success', 'Sukses Menambahkan Akun Admin!');
        }catch(Exception $e){
            return redirect(route('superadmin.akun.create'))->with('error', 'Terjadi Kesalahan, Mohon Dicoba Kembali!');
        }
    }

    public function edit($id){
        $akun = User::find($id);
        $pegawai = Pegawai::where('nama', '!=', 'Superadmin')->doesntHave('user')->orderBy('nama')->get()->push($akun->pegawai);
        return view('akun.create', compact('pegawai', 'akun'));
    }

    public function update(EditAkunRequest $request, $id){
        try{
            $user = User::find($id);
            $user->pegawai_id = $request->pegawai;
            $user->email = $request->email;
            if($request->password){
                $user->password = bcrypt($request->password);
            }
            $user->save();
            return redirect(route('superadmin.akun.index'))->with('success', 'Sukses Mengubah Akun Admin!');
        }catch(Exception $e){
            return redirect(route('superadmin.akun.edit', ['id' => $id]))->with('error', 'Terjadi Kesalahan, Mohon Dicoba Kembali!');
        }
    }

    public function delete($id){
        try{
            User::find($id)->delete();
            return response()->json([
                'status' => 'success',
                'title' => 'Sukses',
                'message' => 'Sukses Menghapus Akun'
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
        $records = User::with('pegawai')->where('role', '!=' , "Superadmin");

        /* ================== [2] Sorting Kolom ================== */
        $sortColumnIndex = $request->order[0]['column'];
        $sortColumnName = $request->columns[$sortColumnIndex]['data'];
        $sortType = $request->order[0]['dir'];
        if($sortColumnName === "no"){
            $records = $records->orderBy('email', 'ASC');
        }else{
            $records = $records->orderBy($sortColumnName, $sortType);
        }

        /* ================== [3] Individual Search ================== */
        $nameSearch = $request->columns[2]['search']['value'];
        if($nameSearch){
            $records = $records->wherehas('pegawai', function($q) use ($nameSearch){
                $q->where('nama', 'like', "%{$nameSearch}%");
            });
        }

        $nipSearch = $request->columns[3]['search']['value'];
        if($nipSearch){
            $records = $records->wherehas('pegawai', function($q) use ($nipSearch){
                $q->where('nip', 'like', "%{$nipSearch}%");
            });
        }

        $emailSearch = $request->columns[4]['search']['value'];
        if($emailSearch){
            $records = $records->where('email', 'like', "%{$emailSearch}%");
        }

        /* ================== [4] Pengambilan Data ================== */
        $totalRecordswithFilter = $records->count();
        $totalRecord = User::with('pegawai')->where('role', '!=' , "Superadmin")->count();
        $records = $records->skip($startNumber)->take($rowperpage)->get();

        /* ================== [7] Memformat Data ================== */
        $data_arr = array();
        foreach($records as $index => $record){
            $data_arr[] = array(
                "id" => $record->id,
                "no" => $startNumber + $index + 1,
                "nama" => $record->pegawai->nama,
                "nip" => $record->pegawai->nip,
                "email" => $record->email,
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
        $records = User::with('pegawai')->where('role', '!=' , "Superadmin");

        if($request->nama){
            $records = $records->wherehas('pegawai', function($q) use ($request){
                $q->where('nama', 'like', "%{$request->nama}%");
            });
        }

        if($request->nip){
            $records = $records->wherehas('pegawai', function($q) use ($request){
                $q->where('nip', 'like', "%{$request->nip}%");
            });
        }

        if($request->email){
            $records = $records->where('email', 'like', "%{$request->email}%");
        }

        $pdf = Pdf::loadView('akun.pdf', [
            'akun' => $records->get()
        ]);

        return $pdf->stream('Laporan Daftar Akun.pdf');
    }
}
