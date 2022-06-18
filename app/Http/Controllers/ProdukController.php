<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\Merk;
use App\Models\Produk;
use App\Models\Stock;
use PDF;

class ProdukController extends Controller
{
    public function index()
    {
        $kategori = Kategori::all()->pluck('nama_kategori', 'id_kategori');
        $merk = Merk::all()->pluck('nama_merk', 'id_merk');

        return view('produk.index', compact('kategori', 'merk'));
    }

    public function data()
    {
        $produk = Produk::leftJoin('kategori', 'kategori.id_kategori', 'produk.id_kategori')
            ->leftJoin('merk', 'merk.id_merk', 'produk.id_merk')
            ->rightJoin('stock', 'stock.id_produk', 'produk.id_produk')
            ->select('produk.*', 'nama_kategori', 'produk.*', 'nama_merk', 'produk.*', 'harga_beli', 'produk.*', 'harga_jual', 'produk.*', 'stock', 'produk.*', 'status')
            ->orderBy('id_produk', 'desc')
            ->where('status', '0')
            ->get();

        return datatables()
            ->of($produk)
            ->addIndexColumn()
            ->addColumn('select_all', function ($produk) {
                return '
                    <input type="checkbox" name="id_produk[]" value="' . $produk->id_produk . '">
                ';
            })
            ->addColumn('kode_produk', function ($produk) {
                return '<span class="label label-success">' . $produk->kode_produk . '</span>';
            })
            ->addColumn('harga_beli', function ($produk) {
                $stock = Stock::with('produk')->where('id_produk', $produk->id_produk)->where('status', '1')->first();
                if($stock) {
                    return format_uang($stock->harga_beli);
                }
                else {
                    return format_uang($produk->harga_beli);
                }
            })
            ->addColumn('harga_jual', function ($produk) {
                $stock = Stock::with('produk')->where('id_produk', $produk->id_produk)->where('status', '1')->first();
                if($stock) {
                    return format_uang($stock->harga_jual);
                }
                else {
                    return format_uang($produk->harga_jual);
                }
            })
            ->addColumn('stock', function ($produk) {
                $semuaproduk = Stock::with('produk')->where('id_produk', $produk->id_produk)->get()->sum("stock");
                return $semuaproduk;
            })
            ->addColumn('aksi', function ($produk) {
                return '
                <div class="btn-group">
                    <button type="button" onclick="editForm(`' . route('produk.update', $produk->id_produk) . '`)" class="btn btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                    <button type="button" onclick="deleteData(`' . $produk->id_produk . '`)" class="btn btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi', 'kode_produk', 'select_all'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validasiproduk = Produk::where("nama_produk", $request->nama_produk)->where("id_merk", $request->id_merk)->first();

        if (isset($validasiproduk)) {
            return response()->json(["gagal" => "Nama produk dengan merk ini sudah tersedia"]);
        } else {
            $produk = Produk::latest()->first() ?? new Produk();
            Produk::create([
                "id_kategori" => $request->id_kategori,
                "id_merk" => $request->id_merk,
                "nama_produk" => $request->nama_produk,
                "kode_produk" => 'P' . tambah_nol_didepan((int)$produk->id_produk + 1, 6),
            ]);

            $produkbaru = Produk::orderBy('id_produk', 'DESC')->first();

            $stock = new Stock();
            $stock->id_produk = $produkbaru->id_produk;
            $stock->harga_beli = $request->harga_beli;
            $stock->harga_jual = $request->harga_jual;
            $stock->stock = $request->stock;
            $stock->status = '0';
            $stock->save();


            // $request['kode_produk'] = 'P' . tambah_nol_didepan((int)$produk->id_produk + 1, 6);


            return response()->json(["berhasil" => "Berhasil Disimpan"]);
        }

        // $this->validate($request, [
        //     'nama_produk' => 'unique:produk'
        // ]);


        // $produk = Produk::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $produk = Produk::with('stock')->where('id_produk', $id)->first();

        if(count($produk->stock) > 1){
            $stock = Stock::with('produk')->where('id_produk', $id)->where('status', '1')->first();
            $stocklama = Stock::with('produk')->where('id_produk', $id)->first()->stock;
            $totalstock = Stock::with('produk')->where('id_produk', $id)->sum('stock');

            return response()->json(["stock" => $stock, "stocklama" => $stocklama, "totalstock" => $totalstock]);
        }
        else {
            $stock = Stock::with('produk')->where('id_produk', $id)->where('status', '0')->first();
            return response()->json(["produk" => $stock]);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!empty($request->status)) {
            $produk = Produk::latest()->first() ?? new Produk();

            $produkbaru = Produk::orderBy('id_produk', 'DESC')->first();

            $stock = new Stock();
            $stock->id_produk = $id;
            $stock->harga_beli = $request->harga_beli;
            $stock->harga_jual = $request->harga_jual;
            $stock->stock = $request->stock;
            $stock->status = '1';
            $stock->save();
        } else {
            Produk::where('id_produk', $id)->update([
                "id_kategori" => $request->id_kategori,
                "id_merk" => $request->id_merk,
                "nama_produk" => $request->nama_produk
            ]);

            Stock::where('id_stock', $request->id_stock)->update([
                "id_produk" => $id,
                "harga_beli" => $request->harga_beli,
                "harga_jual" => $request->harga_jual,
                "stock" => $request->stock,
            ]);
        }


        // $request['kode_produk'] = 'P' . tambah_nol_didepan((int)$produk->id_produk + 1, 6);


        return response()->json(["berhasil" => "Berhasil Disimpan"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $produk = Produk::where('id_produk', $id)->delete();
        Stock::where('id_produk', $id)->delete();

        if ($produk) {
            return response()->json([
                'status' => 'success'
            ]);
        } else {
            return response()->json([
                'status' => 'error'
            ]);
        }
    }

    public function deleteSelected(Request $request)
    {
        foreach ($request->id_produk as $id) {
            $produk = Produk::find($id);
            $produk->delete();
        }

        return response(null, 204);
    }

    public function cetakBarcode(Request $request)
    {
        $dataproduk = array();
        foreach ($request->id_produk as $id) {
            $produk = Stock::with("produk")->where("id_produk", $id)->where("status", "0")->first();
            $stock = Stock::with('produk')->where('id_produk', $produk->id_produk)->where('status', '1')->first();
            if($stock) {
                 $dataproduk[] = $stock;
            }
            else {
                $dataproduk[] = $produk;
            }

        }
        $no = 1;
        $pdf = PDF::loadView('produk.barcode', compact('dataproduk', 'no'));
        $pdf->setPaper('a4', 'potrait');
        return $pdf->stream('produk.pdf');
    }
}
