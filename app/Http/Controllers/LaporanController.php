<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\Pengeluaran;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Produk;
use Illuminate\Http\Request;
use PDF;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $produk = Produk::all();
        $tanggalAwal = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
        $tanggalAkhir = date('Y-m-d');
        $idproduk = $request->get("produk") ?? 0;

        $messageproduk = Produk::where('id_produk', $idproduk)->first();

        if ($request->has('tanggal_awal') && $request->tanggal_awal != "" && $request->has('tanggal_akhir') && $request->tanggal_akhir) {
            $tanggalAwal = $request->tanggal_awal;
            $tanggalAkhir = $request->tanggal_akhir;
        }

        return view('laporan.index', compact('tanggalAwal', 'tanggalAkhir', 'produk', 'idproduk', 'messageproduk'));
    }

    public function getData($awal, $akhir, $idproduk)
    {
        $no = 1;
        $data = array();
        $namaproduk = "-";
        $hargajual = 0;
        $hargabeli = 0;
        $jumlahproduk = 0;
        $keuntunganproduk = 0;
        $jumlah = array();
        $total_keuntungan = array();

        while (strtotime($awal) <= strtotime($akhir)) {
            $tanggal = $awal;
            $awal = date('Y-m-d', strtotime("+1 day", strtotime($awal)));
            if ($idproduk != '0') {
                $keuntungan = PenjualanDetail::with('produk')->where('created_at', 'LIKE', "%$tanggal%")->where("id_produk", $idproduk)->get();
            }else{
                $keuntungan = PenjualanDetail::with('produk')->where('created_at', 'LIKE', "%$tanggal%")->get();
            }
            foreach ($keuntungan as $k) {
                $row = array();
                $row['DT_RowIndex'] = $no++;
                $row['tanggal'] = tanggal_indonesia($tanggal, false);
                $produk = Produk::where("id_produk", $k->id_produk)->first();
                $row['produk'] = $produk->nama_produk ?? $namaproduk;
                $row['harga_jual'] = $k->harga_jual ?? $hargajual;
                $row['harga_beli'] = $k->harga_beli ?? $hargabeli;
                $row['jumlah'] = $k->jumlah ?? $jumlahproduk;
                $row['keuntungan'] = ($k->harga_jual - $k->harga_beli) * $k->jumlah ?? $keuntunganproduk;
                $data[] = $row;
                $total_keuntungan[] = ($k->harga_jual - $k->harga_beli) * $k->jumlah;
                $jumlah[] = $k->jumlah;
            }
        }

        if(empty($jumlah))
        {
            $data[] = [
                'DT_RowIndex' => '',
                'tanggal' => '',
                'produk' => '',
                'harga_jual' => $jumlah == 0 ? '<input type="hidden" id="pesan" name="pesan">' : '',
                'harga_beli' => '',
                'keuntungan' => '',
                'jumlah' => '',
            ];
        }else{
            $data[] = [
                'DT_RowIndex' => '',
                'tanggal' => '',
                'produk' => '',
                'harga_jual' => $jumlah == 0 ? '<input type="hidden" id="pesan" name="pesan">' : '',
                'harga_beli' => '',
                'keuntungan' => 'Total Jumlah & Keuntungan',
                'jumlah' => array_sum($jumlah) . " = " . format_uang(array_sum($total_keuntungan)),
            ];
        }

        return $data;
    }

    public function data($awal, $akhir, $idproduk)
    {
        $data = $this->getData($awal, $akhir, $idproduk);

        return datatables()
            ->of($data)
            ->make(true);
    }

    public function exportPDF($awal, $akhir, $idproduk)
    {
        $data = $this->getData($awal, $akhir, $idproduk);

        if($idproduk != '0'){
            $produk = Produk::where("id_produk", $idproduk)->first()->nama_produk;
        } else {
            $produk = "Semua Produk";
        }
        $pdf  = PDF::loadView('laporan.pdf', compact('awal', 'akhir', 'produk', 'data'));
        $pdf->setPaper('a4', 'potrait');

        return $pdf->stream('Laporan-pendapatan-' . date('Y-m-d-his') . '.pdf');
    }
}
