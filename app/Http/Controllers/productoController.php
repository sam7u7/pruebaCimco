<?php

namespace App\Http\Controllers;

use App\Models\producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class productoController extends Controller
{
    //funcion para traer los productos de la DB
    public function index(){
        $productos = producto::all();
        
        return view('index', compact('productos'));
    }

    //Funcion donde se validan los campos y luego almacenamos el contenido en la DB
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'marca' => 'required|string|max:255',
        ]);

        producto::create([
            'nombre' => $request->nombre,
            'marca' => $request->marca,
        ]);

        return response()->json(['success' => 'Producto creado exitosamente']);
    }

    //Funcion para buscar un id de un producto 
    public function edit($id)
    {
        $producto = producto::find($id);
        return response()->json($producto);
    }

    //de encontrarse el producto se envia al modal y luego procedemos a validar la informacion que retorna el usuario y almacenarla
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'marca' => 'required|string|max:255',
        ]);

        $producto = producto::find($id);
        $producto->update([
            'nombre' => $request->nombre,
            'marca' => $request->marca,
        ]);

        return response()->json(['success' => 'Producto actualizado exitosamente', 'producto' => $producto]);
    }

    //funcion donde primero buscamos el producto en caso de existir este es eliminado 
    public function destroy($id)
    {
        $producto = producto::find($id);
        $producto->delete();

        return response()->json(['success' => 'Producto eliminado exitosamente']);
    }

    //funcion para filtro de productos
    public function filter(Request $request)
    {
        $nombre = $request->get('nombre');
        $productos = producto::where('nombre', 'like', '%' . $nombre . '%')->get();

        return response()->json($productos);
    }

    //funcion para exportar productos a un CSV
    public function exportCSV()
    {
        $productos = Producto::all();
        $filename = "productos.csv";
        $handle = fopen($filename, 'w+');
        fputcsv($handle, ['ID', 'Nombre', 'Marca']);

        foreach($productos as $producto) {
            fputcsv($handle, [$producto->id, $producto->nombre, $producto->marca]);
        }

        fclose($handle);

        $headers = array(
            'Content-Type' => 'text/csv',
        );

        return Response::download($filename, $filename, $headers);

    }
}
