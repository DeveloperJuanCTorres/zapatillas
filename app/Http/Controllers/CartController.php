<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Cart;

class CartController extends Controller
{
    public function add(Request $request)
    {
        try {
            $producto = Product::find($request->id);
            if (empty($producto)) {
                return redirect('/');
            }
            $imagen = json_decode($producto->images);
            if ($imagen) {
                $img = 'storage/' . $imagen[0];
            }
            else{
                $img = 'storage/defecto/defecto.jpg';
            }
            Cart::add(
                $producto->id,
                $producto->name,
                1,
                $producto->price,
                ["image"=>$img]
            );

            return response()->json(['status' => true, 'msg' => 'Porducto se agrego a su carrito', 'count' => Cart::count()]);

        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => $th->getMessage()]);
        }        
    }

    public function cart()
    {
        return view('cart');
    }

    public function removeItem(Request $request)
    {
        Cart::remove($request->rowId);
        return redirect()->back()->with("success","Item eliminado");
    }

    public function clear()
    {
        Cart::destroy();
        return redirect()->back()->with("success","Carrito vacio");
    }
}
