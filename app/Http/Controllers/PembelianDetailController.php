<?php

namespace App\Http\Controllers;

use App\Models\Merk;
use App\Models\Pembelian;
use App\Models\PembelianDetail;
use App\Models\Produk;
use App\Models\Stock;
use App\Models\Supplier;
use Illuminate\Http\Request;

class PembelianDetailController extends Controller
{
    public function index()
    {
        $id_pembelian = session('id_pembelian');
        $produk       = Produk::orderBy('nama_produk')->get();
        $supplier     = Supplier::find(session('id_supplier'));

        if (!$supplier) {
            abort(404);
        }

        return view('pembelian_detail.index', compact('id_pembelian', 'produk', 'supplier'));
    }

    public function data($id)
    {
        $detail = PembelianDetail::with('produk')
            ->where('id_pembelian', $id)
            ->get();
        $data = array();
        $total = 0;
        $total_item = 0;

        foreach ($detail as $item) {
            $merk = Merk::where("id_merk", $item->produk['id_merk'])->first();
            $row = array();
            $row['nama_produk'] = $item->produk['nama_produk'] . '<div class="myproduk" id="myproduk' . $item->produk['id_produk'] . '" data-id="' . $item->produk['id_produk'] . '" style="display: none;">' . $item->produk['id_produk'] . '</div>';
            $row['id_merk'] = $merk->nama_merk;
            $stock = Stock::where("id_produk", $item->produk['id_produk'])->get()->sum("stock");
            $row['stock'] = '<div class="mystock" id="mystock' . $item->produk['id_produk'] . '">' . $stock . '</div>';
            $status = Stock::where("id_produk", $item->produk['id_produk'])->where("status", "1")->first();
            $row['harga_beli']  = $status ? format_uang($status->harga_beli) : '<div id="hargakontainer"><button type="button" class="btn btn-warning btn-sm" name="harga_berubah" id="harga_berubah" onclick="ubahHarga(`' . route('pembelian_detail.ubahharga', $item->produk['id_produk']) . '`)"> Ubah Harga </button> &nbsp;&nbsp;&nbsp;&nbsp;' . format_uang($item->harga_beli) . '</div>';
            $row['jumlah']      = '<div class="form-group">
                                        <input type="number" class="form-control input-sm quantity" id="quantity' . $item->produk['id_produk'] . '" data-id="' . $item->id_pembelian_detail . '" data-produk="' . $item->produk['id_produk'] . '" value="' . $item->jumlah . '">
                                    </div>';
            $row['subtotal']   = 'Rp. ' . format_uang($item->subtotal);
            $row['aksi']        = '<div class="btn-group">
                                    <button onclick="deleteData(`' . $item->id_pembelian_detail . '`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                                </div>';

            $data[] = $row;

            $total += $item->harga_beli * $item->jumlah;
            $total_item += $item->jumlah;
        }

        $data[] = [
            'nama_produk' => '<div class="total hide">' . $total . '</div>
            <div class="total_item hide">' . $total_item . '</div>',
            'id_merk'  => '',
            'stock'  => '',
            'harga_beli'  => '',
            'jumlah'      => '',
            'subtotal'    => '',
            'aksi'    => '',
        ];

        // return $data;

        // return $detail;
        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->rawColumns(['aksi', 'nama_produk', 'jumlah', 'stock', 'harga_beli'])
            ->make(true);
    }

    public function dataProduk()
    {
        $produk = Stock::with("produk")->orderBy('id_produk', 'desc')
            ->where("status", '0')
            ->get();

        // return $produk;
        return datatables()
            ->of($produk)
            ->addIndexColumn()
            ->addColumn('nama_produk', function ($produk) {
                return $produk->produk->nama_produk;
            })
            ->addColumn('stock', function ($produk) {
                $stock = Stock::where("id_produk", $produk->produk->id_produk)->get()->sum("stock");
                return $stock;
            })
            ->addColumn('nama_merk', function ($produk) {
                $merk = Merk::where("id_merk", $produk->produk->id_merk)
                    ->first();
                return $merk->nama_merk;
            })
            ->addColumn('harga_beli', function ($produk) {
                $stock = Stock::where("id_produk", $produk->produk->id_produk)->where("status", "1")->first();
                if ($stock) {
                    return format_uang($stock->harga_beli);
                }
                return format_uang($produk->harga_beli);
            })
            ->addColumn('kode_produk', function ($produk) {
                return '<span class="label label-success">' . $produk->produk->kode_produk . '</span>';
            })
            ->addColumn('aksi', function ($produk) {
                return '
                <a href="#" class="btn btn-primary btn-xs btn-flat" onclick="pilihProduk(`' . $produk->produk->id_produk . '`)">
                        <i class="fa fa-check-circle"></i>
                                    Pilih
                </a>
                ';
            })
            ->rawColumns(['aksi', 'kode_produk'])
            ->make(true);
    }

    public function store(Request $request)
    {

        $produkbaru = Stock::with("produk")->where('id_produk', $request->id_produk)->where("status", "1")->first();
        $produk = Stock::with("produk")->where('id_produk', $request->id_produk)->where("status", "0")->first();
        if (!$produk) {
            return response()->json('Data gagal disimpan', 400);
        }

        if ($produkbaru) {
            $detail = new PembelianDetail();
            $detail->id_pembelian = $request->id_pembelian;
            $detail->id_produk = $produkbaru->id_produk;
            $detail->harga_beli = $produkbaru->harga_beli;
            $detail->jumlah = 1;
            $detail->subtotal = $produkbaru->harga_beli;
            $detail->save();

            return response()->json('Data berhasil disimpan', 200);
        } else {
            $detail = new PembelianDetail();
            $detail->id_pembelian = $request->id_pembelian;
            $detail->id_produk = $produk->id_produk;
            $detail->harga_beli = $produk->harga_beli;
            $detail->jumlah = 1;
            $detail->subtotal = $produk->harga_beli;
            $detail->save();

            return response()->json('Data berhasil disimpan', 200);
        }
    }

    public function update(Request $request, $id)
    {
        $detail = PembelianDetail::find($id);
        $detail->jumlah = $request->jumlah;
        $detail->subtotal = $detail->harga_beli * $request->jumlah;
        $detail->update();
    }

    public function destroy($id)
    {
        $detail = PembelianDetail::find($id);
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

    public function loadForm($total)
    {
        $bayar = $total;
        $data = [
            'totalrp' => format_uang($total),
            'bayar'   => $bayar,
            'bayarrp' => format_uang($bayar),
            'terbilang' => ucwords(terbilang($bayar) . ' Rupiah')
        ];

        return response()->json($data);
    }

    public function ubahHarga(Request $request, $id)
    {
        if (!empty($request->status)) {
            $stock = new Stock();
            $stock->id_produk = $id;
            $stock->harga_beli = $request->harga_beli;
            $stock->harga_jual = $request->harga_jual;
            $stock->stock = 0;
            $stock->status = '1';
            $stock->save();

            $jumlah = PembelianDetail::where("id_produk", $id)->where("id_pembelian", $request->id_pembelian)->first()->jumlah;

            PembelianDetail::where("id_produk", $id)->where("id_pembelian", $request->id_pembelian)->update([
                "harga_beli" =>  $request->harga_beli,
                "subtotal"   => $request->harga_beli * $jumlah,
            ]);

            return redirect()->route('pembelian_detail.index');
        }
    }
}
