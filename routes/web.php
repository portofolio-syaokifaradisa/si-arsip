<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AkunController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BltController;
use App\Http\Controllers\DesaController;
use App\Http\Controllers\KegiatanDesaController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PerangkatDesaController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StatistikDesaController;
use Illuminate\Http\Request;

Route::middleware('guest')->group(function(){
    Route::get('/', [AuthController::class, 'login'])->name('login');
    Route::post('/verify', [AuthController::class, 'verify'])->name('verify');
});

Route::middleware('auth')->group(function(){
    Route::name('logout')->get('logout', function(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route('login'));
    });

    Route::get('home', function(){
        return view('home.index');
    })->name('home');

    Route::prefix('report')->name('report.')->controller(ReportController::class)->group(function(){
        Route::get('pegawai', 'pegawai')->name('pegawai');
        Route::get('pegawai/datatable', 'pegawaiDatatable');
        Route::get('desa', 'desa')->name('desa');
        Route::get('desa/datatable', 'desaDatatable');
        Route::get('statistik', 'statistik')->name('statistik');
        Route::get('statistik/datatable', 'statistikDatatable');
        Route::get('perangkat', 'perangkat')->name('perangkat');
        Route::get('perangkat/datatable', 'perangkatDatatable');
        Route::get('kegiatan', 'kegiatan')->name('kegiatan');
        Route::get('kegiatan/datatable', 'kegiatanDatatable');
        Route::get('blt', 'blt')->name('blt');
        Route::get('blt/datatable', 'bltDatatable');
    });

    Route::prefix('superadmin')->name('superadmin.')->group(function(){
        Route::prefix('pegawai')->name('pegawai.')->group(function(){
            Route::get('/', [PegawaiController::class, 'index'])->name('index');
            Route::get('/datatable', [PegawaiController::class, 'datatable']);
            Route::get('print', [PegawaiController::class, 'print']);
            Route::get('create', [PegawaiController::class, 'create'])->name('create');
            Route::post('store', [PegawaiController::class, 'store'])->name('store');
            Route::prefix('{id}')->group(function(){
                Route::get('edit', [PegawaiController::class, 'edit'])->name('edit');
                Route::put('update', [PegawaiController::class, 'update'])->name('update');
                Route::get('delete', [PegawaiController::class, 'delete'])->name('delete');
            });
        });
    
        Route::prefix('akun')->name('akun.')->group(function(){
            Route::get('/', [AkunController::class, 'index'])->name('index');
            Route::get('datatable', [AkunController::class, 'datatable']);
            Route::get('print', [AkunController::class, 'print']);
            Route::get('create', [AkunController::class, 'create'])->name('create');
            Route::post('store', [AkunController::class, 'store'])->name('store');
            Route::prefix('{id}')->group(function(){
                Route::get('edit', [AkunController::class, 'edit'])->name('edit');
                Route::put('update', [AkunController::class, 'update'])->name('update');
                Route::get('delete', [AkunController::class, 'delete'])->name('delete');
            });
        });
    });   
    
    Route::name('admin.')->group(function(){
        Route::prefix('desa')->name('desa.')->group(function(){
            Route::get('/', [DesaController::class, 'index'])->name('index');
            Route::get('json', [DesaController::class, 'json']);
            Route::get('onlyDesaJson', [DesaController::class, 'onlyDesaJson']);
            Route::get('datatable', [DesaController::class, 'datatable']);
            Route::get('print', [DesaController::class, 'print']);
            Route::get('create', [DesaController::class, 'create'])->name('create');
            Route::post('store', [DesaController::class, 'store'])->name('store');
            Route::prefix('{id}')->group(function(){
                Route::get('edit', [DesaController::class, 'edit'])->name('edit');
                Route::put('update', [DesaController::class, 'update'])->name('update');
                Route::get('delete', [DesaController::class, 'delete'])->name('delete');
            });
        });

        Route::prefix('perangkat')->name('perangkat.')->group(function(){
            Route::get('/', [PerangkatDesaController::class, 'index'])->name('index');
            Route::get('/datatable', [PerangkatDesaController::class, 'datatable']);
            Route::get('print', [PerangkatDesaController::class, 'print']);
            Route::get('create', [PerangkatDesaController::class, 'create'])->name('create');
            Route::post('store', [PerangkatDesaController::class, 'store'])->name('store');
            Route::prefix('{id}')->group(function(){
                Route::get('edit', [PerangkatDesaController::class, 'edit'])->name('edit');
                Route::put('update', [PerangkatDesaController::class, 'update'])->name('update');
                Route::get('delete', [PerangkatDesaController::class, 'delete'])->name('delete');
            });
        });

        Route::prefix('kegiatan')->name('kegiatan.')->group(function(){
            Route::get('/', [KegiatanDesaController::class, 'index'])->name('index');
            Route::get('datatable', [KegiatanDesaController::class, 'datatable']);
            Route::get('print', [KegiatanDesaController::class, 'print']);
            Route::get('create', [KegiatanDesaController::class, 'create'])->name('create');
            Route::post('store', [KegiatanDesaController::class, 'store'])->name('store');
            Route::prefix('{id}')->group(function(){
                Route::get('edit', [KegiatanDesaController::class, 'edit'])->name('edit');
                Route::put('update', [KegiatanDesaController::class, 'update'])->name('update');
                Route::get('delete', [KegiatanDesaController::class, 'delete'])->name('delete');
            });
        });

        Route::prefix('statistik')->name('statistik.')->group(function(){
            Route::get('/', [StatistikDesaController::class, 'index'])->name('index');
            Route::get('datatable', [StatistikDesaController::class, 'datatable']);
            Route::get('print', [StatistikDesaController::class, 'print']);
            Route::get('create', [StatistikDesaController::class, 'create'])->name('create');
            Route::post('store', [StatistikDesaController::class, 'store'])->name('store');
            Route::prefix('{id}')->group(function(){
                Route::get('edit', [StatistikDesaController::class, 'edit'])->name('edit');
                Route::put('update', [StatistikDesaController::class, 'update'])->name('update');
                Route::get('delete', [StatistikDesaController::class, 'delete'])->name('delete');
            });
        });

        Route::prefix('blt')->name('blt.')->group(function(){
            Route::get('/', [BltController::class, 'index'])->name('index');
            Route::get('datatable', [BltController::class, 'datatable']);
            Route::get('print', [BltController::class, 'print']);
            Route::get('create', [BltController::class, 'create'])->name('create');
            Route::post('store', [BltController::class, 'store'])->name('store');
            Route::prefix('{id}')->group(function(){
                Route::get('edit', [BltController::class, 'edit'])->name('edit');
                Route::put('update', [BltController::class, 'update'])->name('update');
                Route::get('delete', [BltController::class, 'delete'])->name('delete');
            });
        });
    });
});