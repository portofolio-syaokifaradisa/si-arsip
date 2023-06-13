<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Desa;
use App\Models\Kependudukan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Requests\StatistikDesaRequest;

class StatistikDesaController extends Controller
{
    public function index(){
        return view('statistik_desa.index');
    }

    public function create(){
        $desa = Desa::orderBy('nama_desa')->get();
        return view('statistik_desa.create', compact('desa'));
    }

    public function store(StatistikDesaRequest $request){
        try{
            Kependudukan::create([
                'desa_id' => $request->desa,
                'tahun' => $request->tahun,
                'luas_wilayah' => $request->wilayah,
                'jumlah_lk' => $request->lk,
                'jumlah_perempuan' => $request->perempuan,
                'jumlah' => $request->jumlah
            ]);
            return redirect(route('admin.statistik.index'))->with('success', 'Sukses Menambahkan Data statistik Desa/Kelurahan');
        }catch(Exception $e){
            dd($e);
            return redirect(route('admin.statistik.create'))->with('error', 'terjadi Kesalahan, Silahkan Coba Lagi!');
        }
    }

    public function edit($id){
        return view('statistik_desa.create',[
            'desa' => Desa::orderBy('nama_desa')->get(),
            'statistik' => Kependudukan::find($id)
        ]);
    }

    public function update(Request $request, $id){
        try{
            Kependudukan::find($id)->update([
                'desa_id' => $request->desa,
                'tahun' => $request->tahun,
                'luas_wilayah' => $request->wilayah,
                'jumlah_lk' => $request->lk,
                'jumlah_perempuan' => $request->perempuan,
                'jumlah' => $request->jumlah
            ]);
            return redirect(route('admin.statistik.index'))->with('success', 'Sukses Mengubah Data Statistik Desa/Kelurahan');
        }catch(Exception $e){
            return redirect(route('admin.statistik.create'))->with('error', 'terjadi Kesalahan, Silahkan Coba Lagi!');
        }
    }

    public function delete($id){
        try{
            Kependudukan::find($id)->delete();
            return response()->json([
                'status' => 'success',
                'title' => 'Sukses',
                'message' => 'Sukses Menghapus Statistik Desa/Kelurahan'
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
        $tahunSearch = $request->columns[2]['search']['value'];
        if($tahunSearch){
            $records = $records->where('tahun', 'like', "%{$tahunSearch}%");
        }
        
        $desaSearch = $request->columns[3]['search']['value'];
        if($desaSearch){
            $records = $records->where('desa_id', $desaSearch);
        }

        $luasWilayahSearch = $request->columns[4]['search']['value'];
        if($luasWilayahSearch){
            $records = $records->where('luas_wilayah', 'like', "%{$luasWilayahSearch}%");
        }

        $lkSearch = $request->columns[5]['search']['value'];
        if($lkSearch){
            $records = $records->where('jumlah_lk', 'like', "%{$lkSearch}%");
        }

        $perempuanSearch = $request->columns[6]['search']['value'];
        if($perempuanSearch){
            $records = $records->where('jumlah_perempuan', 'like', "%{$perempuanSearch}%");
        }

        $kkSearch = $request->columns[7]['search']['value'];
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

    public function print(Request $request){
        $records = Kependudukan::with('desa')->orderBy('desa_id');

        $tahun = '';
        $title = 'Laporan Daftar Statistik Desa/Kelurahan';
        if($request->tahun){
            $title = $title . " Tahun " . $request->tahun;
            $records = $records->where('tahun', 'like', "%{$request->tahun}%");
        }
        
        if($request->desa){
            $records = $records->where('desa_id', $request->desa);
        }

        if($request->wilayah){
            $records = $records->where('luas_wilayah', 'like', "%{$request->wilayah}%");
        }

        if($request->lk){
            $records = $records->where('jumlah_lk', 'like', "%{$request->lk}%");
        }

        if($request->lp){
            $records = $records->where('jumlah_perempuan', 'like', "%{$request->lp}%");
        }

        if($request->kk){
            $records = $records->where('jumlah_kk', 'like', "%{$request->kk}%");
        }

        $pdf = Pdf::loadView('statistik_desa.pdf', [
            'statistik' => $records->get(),
            'title' => $title,
        ]);

        return $pdf->stream($title.".pdf");
    }
}
