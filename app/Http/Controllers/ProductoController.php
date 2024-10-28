<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class ProductoController extends Controller
{
    protected $productoModel;

    public function __construct()
    {
        $this->productoModel = new Producto(); // Instanciar el modelo
    }

    // Método para mostrar el formulario de agregar o editar producto
    public function create($key = null)
    {
        $producto = null; // Inicializar variable
        if ($key) {
            // Si se proporciona una clave, recuperar el producto para editar
            $producto = $this->productoModel->find($key); // Cambia get por find
            if (!$producto) {
                return redirect()->route('products.productos')->with('error', 'Producto no encontrado');
            }
        }
        return view('products.create', compact('producto', 'key')); // Pasa el producto y su clave a la vista
    }

    public function addProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'brand' => 'required|string',
            'category' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        $this->productoModel->add([
            'name' => $request->name,
            'brand' => $request->brand,
            'category' => $request->category,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);

        return redirect()->route('products.productos')->with('success', 'Producto agregado con éxito');
    }

    public function productos()
    {
        $productos = $this->productoModel->all();
        return view('products.productos', compact('productos'));
    }

    public function deleteProduct($key)
    {
        $this->productoModel->delete($key);
        return redirect()->route('products.productos')->with('success', 'Producto eliminado con éxito');
    }

    // Método para actualizar el producto
    public function update(Request $request, $key)
    {
        $request->validate([
            'name' => 'required|string',
            'brand' => 'required|string',
            'category' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        // Actualizar el producto
        $this->productoModel->update($key, [
            'name' => $request->name,
            'brand' => $request->brand,
            'category' => $request->category,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);

        return redirect()->route('products.productos')->with('success', 'Producto actualizado con éxito');
    }
}
