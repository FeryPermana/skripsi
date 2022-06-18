<?php

namespace App\Http\Controllers;


use App\Models\Merk;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Produk;
use App\Models\Setting;
use App\Models\Stock;
use Illuminate\Http\Request;

class PenjualanDetailController extends Controller
{
    public function index()
    {
        $produk = Produk::leftJoin('merk', 'merk.id_merk', 'produk.id_merk')->orderBy('nama_produk')->get();

        $penjualan = Penjualan::orderBy('id_penjualan', 'desc')->first()->total_item;

        $setting = Setting::first();

        // cek apakah ada transaksi yang sedang berjalan
        if ($id_penjualan = session('id_penjualan')) {
            if ($penjualan) {
                $message = "Transaksi Berhasil anda bisa cetak nota atau membuat transaksi baru";
                $penjualan = Penjualan::find($id_penjualan);
                return view('penjualan_detail.index', compact('produk', 'id_penjualan', 'penjualan', 'setting', 'message'));
            }
            $penjualan = Penjualan::find($id_penjualan);
            return view('penjualan_detail.index', compact('produk', 'id_penjualan', 'penjualan', 'setting'));
        } else {
            if (auth()->user()->level == 1) {
                return redirect()->route('transaksi.baru');
            } else {
                return redirect()->route('home');
            }
        }
    }

    public function data($id)
    {
        $detail = PenjualanDetail::with('produk')
            ->where('id_penjualan', $id)
            ->get();
        $penjualan = Penjualan::orderBy('id_penjualan', 'desc')->first()->total_item;

        $data = array();
        $total = 0;
        $total_item = 0;
        foreach ($detail as $item) {
            $merk = Merk::where("id_merk", $item->produk['id_merk'])->first();
            $row = array();
            $row['nama_produk'] = $item->produk['nama_produk'] . '<div class="myproduk" id="myproduk' . $item->produk['id_produk'] . '" data-id="' . $item->produk['id_produk'] . '" style="display: none;">' . $item->produk['id_produk'] . '</div>';
            $row['id_merk'] = $merk->nama_merk;
            $stock = Stock::where('id_produk', $item->id_produk)->get()->sum("stock");
            $row['stock'] = '<div class="mystock" id="mystock' . $item->id_produk . '">' . $stock . '</div>';
            $row['harga_jual']  = 'Rp. ' . format_uang($item->harga_jual);
            $row['jumlah']      = $penjualan ? '<input type="number" class="form-control input-sm quantity" id="quantity' . $item->produk['id_produk'] . '" data-id="' . $item->id_penjualan_detail . '" data-produk="' . $item->produk['id_produk'] . '" value="' . $item->jumlah . '" readonly>' : '<input type="number" class="form-control input-sm quantity" id="quantity' . $item->produk['id_produk'] . '" data-id="' . $item->id_penjualan_detail . '" data-produk="' . $item->produk['id_produk'] . '" value="' . $item->jumlah . '">';
            $row['subtotal']   = 'Rp. ' . format_uang($item->subtotal);
            $row['aksi']        = '<div class="btn-group">
                                    <button onclick="deleteData(`' . $item->id_penjualan_detail . '`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                                </div>';

            $data[] = $row;

            $total += $item->harga_jual * $item->jumlah;
            $total_item += $item->jumlah;
        }

        $data[] = [
            'nama_produk' => '<div class="total hide">' . $total . '</div><div class="total_item hide">' . $total_item . '<div>',
            'id_merk'  => '',
            'stock'  => '',
            'harga_jual'  => '',
            'jumlah'      => '',
            'subtotal'    => '',
            'aksi'    => '',
        ];

        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->rawColumns(['aksi', 'nama_produk', 'jumlah', 'stock'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $produk = Produk::where('id_produk', $request->id_produk)->first();
        $stockbaru = Stock::where('id_produk', $request->id_produk)->where("status", "1")->first();
        $stocklama = Stock::where('id_produk', $request->id_produk)->where("status", "0")->first();
        if (!$produk) {
            return response()->json('data gagal disimpan', 400);
        }

        if(!empty($stockbaru))
        {
            $detail = new PenjualanDetail();
            $detail->id_penjualan = $request->id_penjualan;
            $detail->id_produk = $produk->id_produk;
            $detail->harga_beli = $stocklama->harga_beli;
            $detail->harga_jual = $stockbaru->harga_jual;
            $detail->jumlah = 1;
            $detail->keuntungan = ($stockbaru->harga_jual - $stocklama->harga_beli) * 1;
            $detail->subtotal = $stockbaru->harga_jual;
            $detail->save();

            return response()->json('Data berhasil disimpan', 200);
        }
        else{
            $detail = new PenjualanDetail();
            $detail->id_penjualan = $request->id_penjualan;
            $detail->id_produk = $produk->id_produk;
            $detail->harga_beli = $stocklama->harga_beli;
            $detail->harga_jual = $stocklama->harga_jual;
            $detail->jumlah = 1;
            $detail->keuntungan = ($stocklama->harga_jual - $stocklama->harga_beli) * 1;
            $detail->subtotal = $stocklama->harga_jual;
            $detail->save();

            return response()->json('Data berhasil disimpan', 200);
        }
    }

    public function update(Request $request, $id)
    {
        $detail = PenjualanDetail::find($id);
        $detail->jumlah = $request->jumlah;
        $detail->keuntungan = $detail->keuntungan * $request->jumlah;
        $detail->subtotal = $detail->harga_jual * $request->jumlah;
        $detail->update();
    }

    public function destroy($id)
    {
        $detail = PenjualanDetail::find($id);
        $detail->delete();

        if ($detail) {
            return response()->json([
                'status' => 'success'
            ]);
        } else {
            return response()->json([
                'status' => 'error'
            ]);
        }
    }

    public function loadForm($total, $diterima)
    {
        $bayar = $total;
        $kembali = ($diterima != 0) ? $diterima - $bayar : 0;
        $data = [
            'totalrp' => format_uang($total),
            'bayar'    => $bayar,
            'bayarrp' => format_uang($bayar),
            'terbilang' => ucwords(terbilang($bayar) . ' Rupiah'),
            'kembalirp' => format_uang($kembali),
            'kembali_terbilang' => ucwords(terbilang($kembali) . ' Rupiah'),
        ];

        return response()->json($data);
    }
}
