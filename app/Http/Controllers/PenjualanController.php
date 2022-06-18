<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\PembelianDetail;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Produk;
use App\Models\Setting;
use App\Models\Stock;
use PDF;
use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    public function index()
    {
        // $cekdata = Penjualan::where('total_item', "=", "0")->first();

        // Penjualan::where('total_item', "=", "0")->delete();
        // if ($cekdata) {
        //     PenjualanDetail::where('id_penjualan', $cekdata->id_penjualan)->delete();
        // }

        return view('penjualan.index');
    }

    public function data()
    {
        $penjualan = Penjualan::orderBy('id_penjualan', 'desc')->get();

        return datatables()
            ->of($penjualan)
            ->addIndexColumn()
            ->addColumn('total_item', function ($penjualan) {
                return format_uang($penjualan->total_item);
            })
            ->addColumn('total_harga', function ($penjualan) {
                return 'Rp. ' . format_uang($penjualan->total_harga);
            })
            ->addColumn('bayar', function ($penjualan) {
                return 'Rp. ' . format_uang($penjualan->bayar);
            })
            ->addColumn('tanggal', function ($penjualan) {
                return tanggal_indonesia($penjualan->created_at, false);
            })
            ->editColumn('kasir', function ($penjualan) {
                return $penjualan->user->name ?? '';
            })
            ->addColumn('aksi', function ($penjualan) {
                return '
                <div class="btn-group">
                    <button type="button" onclick="showDetail(`' . route('penjualan.show', $penjualan->id_penjualan) . '`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-eye"></i></button>
                    <button type="button" onclick="deleteData(`' . $penjualan->id_penjualan . '`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        $cekdata = Penjualan::where('total_item', "=", "0")->first();

        Penjualan::where('total_item', "=", "0")->delete();
        if ($cekdata) {
            PenjualanDetail::where('id_penjualan', $cekdata->id_penjualan)->delete();
        }

        $penjualan = new Penjualan();
        $penjualan->total_item = 0;
        $penjualan->total_harga = 0;
        $penjualan->bayar = 0;
        $penjualan->diterima = 0;
        $penjualan->id_user = auth()->id();
        $penjualan->save();

        session(['id_penjualan' => $penjualan->id_penjualan]);

        return redirect()->route('transaksi.index');
    }

    public function store(Request $request)
    {
        $penjualan = Penjualan::findOrFail($request->id_penjualan);
        $penjualan->total_item = $request->total_item;
        $penjualan->total_harga = $request->total;
        $penjualan->bayar = $request->bayar;
        $penjualan->diterima = $request->diterima;
        $penjualan->update();

        $detail = PenjualanDetail::where('id_penjualan', $penjualan->id_penjualan)->get();

        foreach ($detail as $item) {
            $stocklama = Stock::where("id_produk", $item->id_produk)->where("status", "0")->first();
            $stockbaru = Stock::where("id_produk", $item->id_produk)->where("status", "1")->first();
            if ($stocklama->stock < $item->jumlah) {
                $stock = Stock::find($stocklama->id_stock);
                $stock->stock -= $item->jumlah;
                $stock->update();

                $stockbaru = Stock::find($stockbaru->id_stock);
                $stockbaru->stock = $stock->stock + $stockbaru->stock;
                $stockbaru->update();

                Stock::where("stock", "<", "0")->update([
                    "stock" => '0'
                ]);

                $stock = Stock::where('status', '1')->where('stock', '0')->first();
                if($stock){
                    Stock::where('id_produk', $stock->id_produk)->where('status', '1')->update([
                        "status" => "0"
                    ]);
                }

            }else{
                $stock = Stock::find($stocklama->id_stock);
                $stock->stock -= $item->jumlah;
                $stock->update();

            }
        }


        $cekdata = Penjualan::where('total_item', "=", "0")->first();
        Penjualan::where('total_item', "=", "0")->delete();
        if ($cekdata) {
            PenjualanDetail::where('id_penjualan', $cekdata->id_penjualan)->delete();
        }



        return redirect()->route('transaksi.index');
    }

    public function show($id)
    {
        $detail = PenjualanDetail::with('produk')->where('id_penjualan', $id)->get();

        return datatables()
            ->of($detail)
            ->addIndexColumn()
            ->addColumn('nama_produk', function ($detail) {
                return $detail->produk->nama_produk;
            })
            ->addColumn('harga_jual', function ($detail) {
                return 'Rp. ' . format_uang($detail->harga_jual);
            })
            ->addColumn('jumlah', function ($detail) {
                return format_uang($detail->jumlah);
            })
            ->addColumn('subtotal', function ($detail) {
                return 'Rp. ' . format_uang($detail->subtotal);
            })
            ->make(true);
    }

    public function destroy(Request $request, $id)
    {
        $penjualan = Penjualan::find($id);
        $detail    = PenjualanDetail::where('id_penjualan', $penjualan->id_penjualan)->get();
        if (isset($detail)) {
            foreach ($detail as $item) {
                $produk = Stock::where('id_produk', $item->id_produk)->where('status', '0')->first();
                if ($produk) {
                    $produk->stock += $item->jumlah;
                    $produk->update();
                }
                $item->delete();
            }
        }
        $request->session()->forget('id_penjualan');
        $penjualan->delete();

        if ($penjualan) {
            return response()->json([
                'status' => 'success'
            ]);
        } else {
            return response()->json([
                'status' => 'error'
            ]);
        }
    }

    public function notaKecil()
    {
        $setting = Setting::first();
        $penjualan = Penjualan::find(session('id_penjualan'));
        if (!$penjualan) {
            abort(404);
        }
        $detail = PenjualanDetail::with('produk')
            ->where('id_penjualan', session('id_penjualan'))
            ->get();

        return view('penjualan.nota_kecil', compact('setting', 'penjualan', 'detail'));
    }

    public function notaBesar()
    {
        $setting = Setting::first();
        $penjualan = Penjualan::find(session('id_penjualan'));
        if (!$penjualan) {
            abort(404);
        }
        $detail = PenjualanDetail::with('produk')
            ->where('id_penjualan', session('id_penjualan'))
            ->get();

        $pdf = PDF::loadView('penjualan.nota_besar', compact('setting', 'penjualan', 'detail'));
        $pdf->setPaper(0, 0, 609, 440, 'potrait');
        return $pdf->stream('Transaksi-' . date('Y-m-d-his') . '.pdf');
    }
}
