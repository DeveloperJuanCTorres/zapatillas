<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function editarStock(Request $request)
    {
        try {
            foreach ($request->listado as $key => $item) {
                $producto = Product::where('id_sistema',$item['id_sistema'])->get();
                $producto[0]->update([
                    'stock' => $producto[0]->stock - $item['cantidad']
                ]);
            }
            return response()->json(['status' => true, 'msg' => 'Se edito con exito']); 
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => $th->getMessage()]);
        }
    }

}
