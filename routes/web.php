<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/register', function () {
    return redirect()->route('login');
});
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('home');
})->name('dashboard');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::group(['middleware' => 'level:1'], function () {

        Route::get('/kategori/data', [KategoriController::class, 'data'])->name('kategori.data');
        Route::resource('/kategori', KategoriController::class);

        Route::get('/merk/data', [MerkController::class, 'data'])->name('merk.data');
        Route::resource('/merk', MerkController::class);

        Route::get('/produk/data', [ProdukController::class, 'data'])->name('produk.data');
        Route::post('/produk/delete-selected', [ProdukController::class, 'deleteSelected'])->name('produk.delete_selected');
        Route::post('/produk/cetak-barcode', [ProdukController::class, 'cetakBarcode'])->name('produk.cetak_barcode');
        Route::resource('/produk', ProdukController::class);

        Route::get('/supplier/data', [SupplierController::class, 'data'])->name('supplier.data');
        Route::resource('/supplier', SupplierController::class);

        Route::get('/pengeluaran/data', [PengeluaranController::class, 'data'])->name('pengeluaran.data');
        Route::resource('/pengeluaran', PengeluaranController::class);

        Route::get('/pembelian/data', [PembelianController::class, 'data'])->name('pembelian.data');
        Route::get('/pembelian/{id}/create', [PembelianController::class, 'create'])->name('pembelian.create');
        Route::resource('/pembelian', PembelianController::class)
            ->except('create');


        Route::get('/pembelian_detail/{id}/data', [PembelianDetailController::class, 'data'])->name('pembelian_detail.data');

        Route::get('/pembelian_detail/loadform/{total}', [PembelianDetailController::class, 'loadForm'])->name('pembelian_detail.load_form');
        Route::get('/pembelian_detail/data_produk', [PembelianDetailController::class, 'dataProduk'])->name('pembelian_detail.dataproduk');
        Route::post('/pembelian_detail/{id}/ubahharga', [PembelianDetailController::class, 'ubahHarga'])->name('pembelian_detail.ubahharga');
        Route::resource('/pembelian_detail', PembelianDetailController::class)
            ->except('create', 'show', 'edit');

        Route::get('/penjualan/data', [PenjualanController::class, 'data'])->name('penjualan.data');
        Route::get('/penjualan', [PenjualanController::class, 'index'])->name('penjualan.index');
        Route::get('/penjualan/{id}', [PenjualanController::class, 'show'])->name('penjualan.show');
        Route::delete('/penjualan/{id}', [PenjualanController::class, 'destroy'])->name('penjualan.destroy');
    });


    Route::get('/transaksi/baru', [PenjualanController::class, 'create'])->name('transaksi.baru');
    Route::post('/transaksi/simpan', [PenjualanController::class, 'store'])->name('transaksi.simpan');
    Route::get('/transaksi/nota-kecil', [PenjualanController::class, 'notaKecil'])->name('transaksi.nota_kecil');
    Route::get('/transaksi/nota-besar', [PenjualanController::class, 'notaBesar'])->name('transaksi.nota_besar');

    Route::get('/transaksi/{id}/data', [PenjualanDetailController::class, 'data'])->name('transaksi.data');
    Route::get('/transaksi/loadform/{total}/{diterima}', [PenjualanDetailController::class, 'loadForm'])->name('transaksi.load_form');
    Route::resource('/transaksi', PenjualanDetailController::class)
        ->except('show');
    Route::get('/transaksi/batalkan', [PenjualanDetailController::class, 'batalkanTransaksi'])->name('transaksi.batalkan');

    Route::group(['middleware' => 'level:1'], function () {
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::post('/laporan', [LaporanController::class, 'refresh'])->name('laporan.refresh');
        Route::get('/laporan/data/{awal}/{akhir}/{idproduk}', [LaporanController::class, 'data'])->name('laporan.data');
        Route::get('/laporan/pdf/{awal}/{akhir}/{idproduk}', [LaporanController::class, 'exportPDF'])->name('laporan.export_pdf');

        Route::get('/laporankeuangan', [LaporanKeuanganController::class, 'index'])->name('laporankeuangan.index');
        Route::post('/laporankeuangan', [LaporanKeuanganController::class, 'refresh'])->name('laporankeuangan.refresh');
        Route::get('/laporankeuangan/data/{awal}/{akhir}', [LaporanKeuanganController::class, 'data'])->name('laporankeuangan.data');
        Route::get('/laporankeuangan/pdf/{awal}/{akhir}', [LaporanKeuanganController::class, 'exportPDF'])->name('laporankeuangan.export_pdf');

        Route::get('/user/data', [UserController::class, 'data'])->name('user.data');
        Route::resource('/user', UserController::class);
        Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
        Route::get('/setting/first', [SettingController::class, 'show'])->name('setting.show');
        Route::post('/setting', [SettingController::class, 'update'])->name('setting.update');
    });


    Route::get('/profil', [UserController::class, 'profil'])->name('user.profile');
    Route::post('/profil', [UserController::class, 'updateProfil'])->name('user.update_profil');
});
