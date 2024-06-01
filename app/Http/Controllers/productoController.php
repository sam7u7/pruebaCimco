<?php

namespace App\Http\Controllers;

use App\Models\producto;
use Illuminate\Http\Request;

class productoController extends Controller
{
    //
    public function index(){
        $productos = producto::all();
        
        return view('index', compact('productos'));
    }

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

    public function edit($id)
    {
        $producto = producto::find($id);
        return response()->json($producto);
    }

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

    public function destroy($id)
    {
        $producto = producto::find($id);
        $producto->delete();

        return response()->json(['success' => 'Producto eliminado exitosamente']);
    }
}
