<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct(){
        $stock = Stock::where('stock', '0')->where('status', '1')->first();
        if($stock){
            Stock::where('id_produk', $stock->id_produk)->where('status', '1')->update([
                "status" => "0"
            ]);
            $stock->delete();
        }
    }
}
