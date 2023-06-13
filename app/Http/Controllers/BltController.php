<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Blt;
use App\Models\Desa;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Requests\BltRequest;

class BltController extends Controller
{
    public function index(){
        return view('blt.index');
    }

    public function create(){
        $desa = Desa::orderBy('nama_desa')->where('tipe', 'Desa')->get();
        return view('blt.create', compact('desa'));
    }

    public function store(BltRequest $request){
        try{
            $bltCount = Blt::where('tahun', $request->tahun)->count() + 1;
            $extension = explode('.', $request->file('tanda_terima')->getClientOriginalName());
            $fileName = "$bltCount-$request->desa-$request->nik.".$extension[array_key_last($extension)];
            $request->file('tanda_terima')->move(
                public_path("img/tanda_terima_blt/$request->tahun"), 
                $fileName
            );

            Blt::create([
                'desa_id' => $request->desa,
                'tahun' => $request->tahun,
                'nama' => $request->nama,
                'nik' => $request->nik,
                'tanggal_lahir' => $request->ttl,
                'rt' => $request->rt,
                'rw' => $request->rw,
                'mekanisme_pembayaran' => $request->mekanisme_pembayaran,
                'jumlah' => $request->jumlah,
                'tanda_terima' => $fileName
            ]);
            return redirect(route('admin.blt.index'))->with('success', 'Sukses Menambahkan Data Penerima BLT');
        }catch(Exception $e){
            return redirect(route('admin.blt.create'))->with('error', 'terjadi Kesalahan, Silahkan Coba Lagi!');
        }
    }

    public function edit($id){
        return view('blt.create',[
            'desa' => Desa::orderBy('nama_desa')->where('tipe', 'Desa')->get(),
            'blt' => Blt::find($id)
        ]);
    }

    public function update(Request $request, $id){
        try{
            $blt = Blt::find($id);
            if($request->file('tanda_terima')){
                $extension = explode('.', $request->file('tanda_terima')->getClientOriginalName());
                $fileName = explode('.', $blt->tanda_terima)[0] . $extension[array_key_last($extension)];
                $request->file('tanda_terima')->move(
                    public_path("img/tanda_terima_blt/$blt->tahun"), 
                    $fileName
                );

                $blt->tanda_terima = $fileName;
            }

            $blt->desa_id = $request->desa;
            $blt->tahun = $request->tahun;
            $blt->nama = $request->nama;
            $blt->nik = $request->nik;
            $blt->tanggal_lahir = $request->ttl;
            $blt->rt = $request->rt;
            $blt->rw = $request->rw;
            $blt->mekanisme_pembayaran = $request->mekanisme_pembayaran;
            $blt->jumlah = $request->jumlah;
            $blt->save();
            return redirect(route('admin.blt.index'))->with('success', 'Sukses Mengubah Data Penerima BLT');
        }catch(Exception $e){
            return redirect(route('admin.blt.create'))->with('error', 'terjadi Kesalahan, Silahkan Coba Lagi!');
        }
    }

    public function delete($id){
        try{
            Blt::find($id)->delete();
            return response()->json([
                'status' => 'success',
                'title' => 'Sukses',
                'message' => 'Sukses Menghapus Data Penerima BLT'
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
        $tahunSearch = $request->columns[2]['search']['value'];
        if($tahunSearch){
            $records = $records->where('tahun', 'like', "%{$tahunSearch}%");
        }

        $desaSearch = $request->columns[3]['search']['value'];
        if($desaSearch){
            $records = $records->where('desa_id', $desaSearch);
        }
        
        $receiveSearch = $request->columns[4]['search']['value'];
        if($receiveSearch){
            $records = $records->where('nama', 'like', "%{$receiveSearch}%");
            $records = $records->orwhere('nik', 'like', "%{$receiveSearch}%");
        }

        $ttlSearch = $request->columns[5]['search']['value'];
        if($ttlSearch){
            $records = $records->where('tanggal_lahir', $ttlSearch);
        }

        $rtSearch = $request->columns[6]['search']['value'];
        if($rtSearch){
            $records = $records->where('RT', 'like', "%{$rtSearch}%");
        }

        $rwSearch = $request->columns[7]['search']['value'];
        if($rwSearch){
            $records = $records->where('RW', 'like', "%{$rwSearch}%");
        }

        $jumlahSearch = $request->columns[8]['search']['value'];
        if($jumlahSearch){
            $records = $records->where('jumlah', 'like', "%{$jumlahSearch}%");
        }

        $paymentSearch = $request->columns[9]['search']['value'];
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

    public function print(Request $request){
        $records = Blt::with('desa')->orderBy('desa_id');

        $title = "Laporan Daftar Penerima BLT";
        if($request->tahun){
            $title = $title . " Tahun " . $request->tahun;
            $records = $records->where('tahun', 'like', "%{$request->tahun}%");
        }

        if($request->diskfreespace){
            $records = $records->where('desa_id', $request->diskfreespace);
        }
        
        if($request->penerima){
            $records = $records->where('nama', 'like', "%{$request->penerima}%");
            $records = $records->orwhere('nik', 'like', "%{$request->penerima}%");
        }

        if($request->ttl){
            $records = $records->where('tanggal_lahir', $request->ttl);
        }

        if($request->rt){
            $records = $records->where('RT', 'like', "%{$request->rt}%");
        }

        if($request->rw){
            $records = $records->where('RW', 'like', "%{$request->rw}%");
        }

        if($request->jumlah){
            $records = $records->where('jumlah', 'like', "%{$request->jumlah}%");
        }

        if($request->mekanisme_pembayaran){
            $records = $records->where('mekanisme_pembayaran', 'like', "%{$request->mekanisme_pembayaran}%");
        }

        $pdf = Pdf::loadView('blt.pdf', [
            'blt' => $records->get(),
            'title' => $title
        ]);

        return $pdf->stream($title.'.pdf');
    }
}
