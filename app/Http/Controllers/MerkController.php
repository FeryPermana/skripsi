<?php

namespace App\Http\Controllers;

use App\Models\Merk;
use App\Models\Produk;
use Illuminate\Http\Request;

class MerkController extends Controller
{
    public function index()
    {
        return view('merk.index');
    }

    public function data()
    {
        $merk = Merk::orderBy('id_merk', 'desc')->get();

        return datatables()
            ->of($merk)
            ->addIndexColumn()
            ->addColumn('aksi', function ($merk) {
                return '
                <div class="btn-group">
                    <button onclick="editForm(`'. route('merk.update', $merk->id_merk) .'`)" class="btn btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                    <button onclick="deleteData(`'. $merk->id_merk .'`)" class="btn btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'nama_merk' => 'unique:Merk',
         ]);

        $merk = new Merk();
        $merk->nama_merk = $request->nama_merk;
        $merk->save();
        return response()->json($merk, 200);
    }

    public function show($id)
    {
        $merk = Merk::find($id);

        return response()->json($merk);
    }

    public function update(Request $request, $id)
    {
        $merk = Merk::find($id);
        $merk->nama_merk = $request->nama_merk;
        $merk->update();

        return response()->json('Data berhasil diupdate', 200);
    }

    public function destroy($id)
    {
        $merk = Merk::find($id);
        $produk = Produk::where('id_merk', $merk->id_merk)->first();

        if ($produk) {
            return response()->json([
                'status' => 'notworking'
            ]);
        }

        if ($merk) {
            $merk->delete();
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
