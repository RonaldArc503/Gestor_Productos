<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class ProductoController extends Controller
{
    protected $productoModel;

    public function __construct()
    {
        // Inicializa el modelo de Producto que interactúa con Firebase
        $this->productoModel = new Producto();
    }

    /**
     * Mostrar el formulario para crear un nuevo producto.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Devuelve la vista de creación de producto
        return view('products.create', ['producto' => null, 'key' => null]);
    }

    /**
     * Almacenar un nuevo producto en Firebase.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addProduct(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'name' => 'required|string',
            'brand' => 'required|string',
            'category' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        // Agregar el producto usando el modelo
        $this->productoModel->add([
            'name' => $request->name,
            'brand' => $request->brand,
            'category' => $request->category,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);

        // Redirigir a la lista de productos con un mensaje de éxito
        return redirect()->route('products.productos')->with('success', 'Producto agregado con éxito');
    }

    /**
     * Mostrar el formulario para editar un producto existente.
     *
     * @param string $key
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit($key)
    {
        // Obtener el producto desde Firebase usando el modelo
        $producto = $this->productoModel->get($key);
    
        // Verificar si el producto fue encontrado
        if ($producto === null) {
            return redirect()->route('products.productos')->with('error', 'Producto no encontrado.');
        }
    
        // Retorna la vista de edición con los datos del producto
        return view('products.create', compact('producto', 'key'));
    }

    /**
     * Actualizar un producto en Firebase.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $key
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $key)
    {
        // Validar los datos de entrada
        $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        // Actualizar el producto en Firebase usando el modelo
        $this->productoModel->update($key, [
            'name' => $request->input('name'),
            'brand' => $request->input('brand'),
            'category' => $request->input('category'),
            'price' => $request->input('price'),
            'stock' => $request->input('stock'),
        ]);

        // Redirigir a la lista de productos con un mensaje de éxito
        return redirect()->route('products.productos')->with('success', 'Producto actualizado exitosamente.');
    }

    /**
     * Mostrar una lista de todos los productos.
     *
     * @return \Illuminate\View\View
     */
    public function productos()
    {
        // Obtener todos los productos desde Firebase usando el modelo
        $productos = $this->productoModel->all();

        // Retorna la vista con la lista de productos
        return view('products.productos', compact('productos'));
    }

    /**
     * Eliminar un producto de Firebase.
     *
     * @param string $key
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteProduct($key)
    {
        // Eliminar el producto usando el modelo
        $this->productoModel->delete($key);

        // Redirigir a la lista de productos con un mensaje de éxito
        return redirect()->route('products.productos')->with('success', 'Producto eliminado con éxito');
    }
}
