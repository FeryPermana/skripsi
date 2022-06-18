<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembelian;
use App\Models\PembelianDetail;
use App\Models\Produk;
use App\Models\Stock;
use App\Models\Supplier;

class PembelianController extends Controller
{
    public function index()
    {
        $supplier = Supplier::orderBy('nama')->get();

        return view('pembelian.index', compact('supplier'));
    }

    public function data()
    {
        $pembelian = Pembelian::orderBy('id_pembelian', 'desc')->get();

        return datatables()
            ->of($pembelian)
            ->addIndexColumn()
            ->addColumn('total_item', function ($pembelian) {
                return format_uang($pembelian->total_item);
            })
            ->addColumn('total_harga', function ($pembelian) {
                return 'Rp. ' . format_uang($pembelian->total_harga);
            })
            ->addColumn('bayar', function ($pembelian) {
                return 'Rp. ' . format_uang($pembelian->bayar);
            })
            ->addColumn('tanggal', function ($pembelian) {
                return tanggal_indonesia($pembelian->created_at, false);
            })
            ->addColumn('supplier', function ($pembelian) {
                return $pembelian->supplier->nama;
            })
            ->addColumn('aksi', function ($pembelian) {
                return '
                <div class="btn-group">
                    <button type="button" onclick="showDetail(`' . route('pembelian.show', $pembelian->id_pembelian) . '`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-eye"></i></button>
                    <button type="button" onclick="deleteData(`' . $pembelian->id_pembelian . '`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function show($id)
    {
        $detail = PembelianDetail::with('produk')->where('id_pembelian', $id)->get();
        // return $detail;
        return datatables()
            ->of($detail)
            ->addIndexColumn()
            ->addColumn('nama_produk', function ($detail) {
                return $detail->produk->nama_produk ?? "produk tidak ada";
            })
            ->addColumn('kode_produk', function ($detail) {
                if(isset($detail->produk->kode_produk)){
                    return '<span class="label label-success">' . $detail->produk->kode_produk . '</span>';
                }else {
                    return 'produk tidak ada';
                }
            })
            ->addColumn('harga_beli', function ($detail) {
                return 'Rp. ' . format_uang($detail->harga_beli);
            })
            ->addColumn('jumlah', function ($detail) {
                return format_uang($detail->jumlah);
            })
            ->addColumn('subtotal', function ($detail) {
                return 'Rp. ' . format_uang($detail->subtotal);
            })
            ->rawColumns(['kode_produk'])
            ->make(true);
    }

    public function create($id)
    {
        $cekdata = Pembelian::where('total_item', "=", "0")->first();

        Pembelian::where('total_item', "=", "0")->delete();
        if ($cekdata) {
            PembelianDetail::where('id_pembelian', $cekdata->id_pembelian)->delete();
        }


        $pembelian = new Pembelian();
        $pembelian->id_supplier = $id;
        $pembelian->total_item  = 0;
        $pembelian->total_harga = 0;
        $pembelian->bayar       = 0;
        $pembelian->save();

        session(['id_pembelian' => $pembelian->id_pembelian]);
        session(['id_supplier' => $pembelian->id_supplier]);

        return redirect()->route('pembelian_detail.index');
    }

    public function store(Request $request)
    {
        $pembelian = Pembelian::findOrFail($request->id_pembelian);
        $pembelian->total_item = $request->total_item;
        $pembelian->total_harga = $request->total;
        $pembelian->bayar = $request->bayar;
        $pembelian->update();

        $detail = PembelianDetail::where('id_pembelian', $pembelian->id_pembelian)->get();

        foreach ($detail as $item) {
            $stockbaru = Stock::where("id_produk", $item->id_produk)->where("status", "1")->first();
            if ($stockbaru) {
                $stockbaru = Stock::find($stockbaru->id_stock);
                $stockbaru->stock += $item->jumlah;
                $stockbaru->update();
            } else {
                $stocklama = Stock::where("id_produk", $item->id_produk)->where("status", "0")->first();
                $stocklama = Stock::find($stocklama->id_stock);
                $stocklama->stock += $item->jumlah;
                $stocklama->update();
            }
        }

        return redirect()->route('pembelian.index');
    }


    public function destroy(Request $request, $id)
    {
        $pembelian = Pembelian::find($id);
        $detail    = PembelianDetail::where('id_pembelian', $pembelian->id_pembelian)->get();
        if ($detail) {
            foreach ($detail as $item) {
                $stock = Stock::where("id_produk", $item->id_produk)->where("status", "1")->first();
                if ($stock) {
                    $stock = Stock::find($stock->id_stock);
                    $stock->stock -= $item->jumlah;
                    $stock->update();
                } else {
                    $stock = Stock::where("id_produk", $item->id_produk)->where("status", "0")->first();
                    $stocklama = Stock::find($stock->id_stock);
                    $stocklama->stock -= $item->jumlah;
                    $stocklama->update();
                }
                $item->delete();
            }
        }

        $request->session()->forget('id_pembelian');

        $pembelian->delete();

        if ($pembelian) {
            return response()->json([
                'status' => 'success'
            ]);
        } else {
            return response()->json([
                'status' => 'error'
            ]);
        }
    }
}
