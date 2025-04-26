<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Color;
use App\Models\Company;
use App\Models\Product;
use App\Models\Taxonomy;
use Illuminate\Console\View\Components\Alert;
use Illuminate\Http\Request;
use TCG\Voyager\Models\Category;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categories = Taxonomy::all();
        $products = Product::all();
        return view('home', compact('categories','products'));
    }

    public function tienda()
    {
        $categories = Taxonomy::with('products')->get();
        $brands = Brand::with('products')->get();
        $colors = Color::all();
        $products = Product::all();
        return view('tienda',compact('categories','brands','colors','products'));
    }

    public function contact()
    {
        return view('contact');
    }

    public function detail()
    {
        return view('product-detail');
    }

    public function checkout()
    {
        return view('checkout');
    }

    public function apiBrand()
    {
        try {
            $business = Company::find(1);
            $ruta = "https://erp2024.keyoficiales.com/api/Grupo/Listagruposxcodigo_web";

            $response = Http::post($ruta, [
                "ruc_empresa" => $business->ruc,
                "codigo_grupo" => 0
            ]);

            if ($response->successful() == true) {
                $body = json_decode($response->body());
                foreach ($body->listadoGrupo as $key => $item) {
                    Brand::create([
                        'name' => $item->descripcion,
                        'id_sistema' => $item->codigo
                    ]);
                }
                return response()->json(['status' => true, 'msg' => 'Registro masivo de Marcas con éxito']); 
            }
            else{
                return response()->json(['status' => true, 'msg' => 'Algo aslio mal']); 
            }

            
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => 'Error:'.$th->getMessage()]);
        }
    }

    public function apiCategory()
    {
        try {
            $business = Company::find(1);
            $ruta = "https://erp2024.keyoficiales.com/api/Linea/Listalineasxcodigo_web";

            $response = Http::post($ruta, [
                "ruc_empresa" => $business->ruc,
                "codigo_liena" => 0
            ]);

            if ($response->successful() == true) {
                $body = json_decode($response->body());
                foreach ($body->listadoLinea as $key => $item) {
                    Taxonomy::create([
                        'name' => $item->descripcion,
                        'id_sistema' => $item->codigo
                    ]);
                }
                return response()->json(['status' => true, 'msg' => 'Registro masivo de Categorías con éxito']); 
            }
            else{
                return response()->json(['status' => true, 'msg' => 'Algo aslio mal']); 
            }

            
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => 'Error:'.$th->getMessage()]);
        }
    }

    public function apiProduct()
    {
        try {
            $business = Company::find(1);
            $ruta = "https://erp2024.keyoficiales.com/api/Inventario/ProductosWeb";

            $response = Http::post($ruta, [
                "ruc_empresa" => $business->ruc,
                "idlinea" => 0,
                'idgrupo' => 0,
                'idalmacen' => 0,
                'descripcion' => '',
                'cantidad_producto' => 10,
                'paginas' => 1,
                'estado' => 'P',
                'fechainicial' => '2025-04-25T14:54:34.307Z',
                'fechafinal' => '2025-04-25T14:54:34.307Z'
            ]);

            if ($response->successful() == true) {
                $body = json_decode($response->body());
                foreach ($body->listadoCatalogoWeb as $key => $item) {
                    $marca = Brand::where('id_sistema',$item->grupo)->get();
                    $categoria = Taxonomy::where('id_sistema',$item->linea)->get();
                    if ($marca) {
                        if ($categoria) {
                            
                            Product::create([
                                'name' => $item->descripcion,
                                'slug' => Str::slug($item->descripcion),
                                'price' => $item->precio_venta,
                                'taxonomy_id' => $categoria[0]->id,
                                'brand_id' => $marca[0]->id,
                                'id_sistema' => $item->codigo,
                                'unidad_medida' => $item->presentacion,
                                'stock' =>$item->stock
                            ]);
                        }
                    }             
                } 
                return response()->json(['status' => true, 'msg' => 'Registro masivo de Productos con éxito']);                
            }
            else{
                return response()->json(['status' => true, 'msg' => 'Algo aslio mal']); 
            }

            
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => 'Error:'.$th->getMessage()]);
        }
    }

    public function pedido(Request $request)
    {
        try {
            $data = ['nombre' => $request->nombre,
                    'apellidos' => $request->apellidos,
                    'empresa' => $request->empresa,
                    'telefono' => $request->telefono,
                    'email' => $request->email,
                    'direccion' => $request->direccion];

            $pdf = Pdf::loadView('pdf', $data);    

            // Generar el PDF y guardarlo en el storage/app/public/facturas/
            $pdfPath = 'pedidos/pedido3.pdf';
            Storage::put('public/' . $pdfPath, $pdf->output());

            $ruta = "https://mensajex.com/api/ChatBot/apisend";

            $mensaje = Http::post($ruta, [
                "numero_celular" => $request->telefono,
                "mensaje" => 'Aquí le enviamos el detalle de su pedido',
                "ruta_imagen" => 'https://zapatillas.mastersoftstore.com/storage/' . $pdfPath,
            ]);

            return response()->json(['status' => true, 'msg' => $mensaje->body()]); 
        } catch (\Throwable $th) {
            //throw $th;
        }        
    }
}
