<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Desa;
use Illuminate\Http\Request;
use App\Models\KegiatanFisik;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Requests\KegiatanDesaRequest;

class KegiatanDesaController extends Controller
{
    public function index(){
        return view('kegiatan.index');
    }

    public function create(){
        $desa = Desa::orderBy('nama_desa')->where('tipe', 'Desa')->get();
        return view('kegiatan.create', compact('desa'));
    }

    public function store(KegiatanDesaRequest $request){
        try{
            KegiatanFisik::create([
                'desa_id' => $request->desa,
                'kegiatan' => $request->kegiatan,
                'pagu' => $request->pagu,
                'realisasi' => $request->realisasi ?? '',
                'keterangan' => $request->keterangan ?? '',
                'tahun' => $request->tahun
            ]);
            return redirect(route('admin.kegiatan.index'))->with('success', 'Sukses Menambahkan Data Kegiatan Desa');
        }catch(Exception $e){
            return redirect(route('admin.kegiatan.create'))->with('error', 'terjadi Kesalahan, Silahkan Coba Lagi!');
        }
    }

    public function edit($id){
        return view('kegiatan.create',[
            'desa' => Desa::orderBy('nama_desa')->where('tipe', 'Desa')->get(),
            'kegiatan' => KegiatanFisik::find($id)
        ]);
    }

    public function update(KegiatanDesaRequest $request, $id){
        try{
            KegiatanFisik::find($id)->update([
                'desa_id' => $request->desa,
                'kegiatan' => $request->kegiatan,
                'pagu' => $request->pagu,
                'realisasi' => $request->realisasi ?? '',
                'keterangan' => $request->keterangan ?? '',
                'tahun' => $request->tahun
            ]);
            return redirect(route('admin.kegiatan.index'))->with('success', 'Sukses Mengubah Data Kegiatan Desa');
        }catch(Exception $e){
            return redirect(route('admin.kegiatan.create'))->with('error', 'terjadi Kesalahan, Silahkan Coba Lagi!');
        }
    }

    public function delete($id){
        try{
            KegiatanFisik::find($id)->delete();
            return response()->json([
                'status' => 'success',
                'title' => 'Sukses',
                'message' => 'Sukses Menghapus Kegiatan Desa'
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
        $tahunSearch = $request->columns[2]['search']['value'];
        if($tahunSearch){
            $records = $records->where('tahun', 'like', "%{$tahunSearch}%");
        }
        
        $desaSearch = $request->columns[3]['search']['value'];
        if($desaSearch){
            $records = $records->where('desa_id', $desaSearch);
        }

        $kegiatanSearch = $request->columns[4]['search']['value'];
        if($kegiatanSearch){
            $records = $records->where('kegiatan', 'like', "%{$kegiatanSearch}%");
        }

        $paguSearch = $request->columns[5]['search']['value'];
        if($paguSearch){
            $records = $records->where('pagu', 'like', "%{$paguSearch}%");
        }

        $realisasiSearch = $request->columns[6]['search']['value'];
        if($realisasiSearch){
            $records = $records->where('realisasi', 'like', "%{$realisasiSearch}%");
        }

        $keteranganSearch = $request->columns[7]['search']['value'];
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

    public function print(Request $request){
        $records = KegiatanFisik::with('desa')->orderBy('desa_id');

        $title = "Laporan Daftar kegiatan Desa";
        if($request->tahun){
            $title = $title . " Tahun " . $request->tahun;
            $records = $records->where('tahun', 'like', "%{$request->tahun}%");
        }
        
        if($request->desa){
            $records = $records->where('desa_id', $request->desa);
        }

        if($request->nama){
            $records = $records->where('kegiatan', 'like', "%{$request->nama}%");
        }

        if($request->pagu){
            $records = $records->where('pagu', 'like', "%{$request->pagu}%");
        }

        if($request->realisasi){
            $records = $records->where('realisasi', 'like', "%{$request->realisasi}%");
        }

        if($request->keterangan){
            $records = $records->where('keterangan', 'like', "%{$request->keterangan}%");
        }

        $pdf = Pdf::loadView('kegiatan.pdf', [
            'kegiatan' => $records->get(),
            'title' => $title,
        ]);

        return $pdf->stream($title.'.pdf');
    }
}
