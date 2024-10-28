<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use Kreait\Firebase\Database;

class ProductoController extends Controller
{
    protected $database;
    protected $productoModel;

    public function __construct()
    {
        $this->productoModel = new Producto(); // Inicializa el modelo
        $this->database = (new \Kreait\Firebase\Factory)
        ->withServiceAccount(storage_path('app/forgedream-firebase-adminsdk-1jxfy-ba1ad72f1f.json'))
        ->withDatabaseUri('https://forgedream-default-rtdb.firebaseio.com/')
        ->createDatabase();
    }
    

    public function edit($key)
{
    // Obtener el producto de Firebase
    $producto = $this->database->getReference('productos/' . $key)->getValue();
    
    // Verificar si el producto fue encontrado
    if ($producto === null) {
        return redirect()->route('products.productos')->with('error', 'Producto no encontrado.');
    }
    
    return view('products.create', compact('producto', 'key')); // Redirigir a la vista de edición
}

    
    


    public function update(Request $request, $key)
    {
        // Validar los datos
        $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        // Actualizar el producto en Firebase
        $this->database->getReference('productos/' . $key)->update([
            'name' => $request->input('name'),
            'brand' => $request->input('brand'),
            'category' => $request->input('category'),
            'price' => $request->input('price'),
            'stock' => $request->input('stock'),
        ]);

        return redirect()->route('products.productos')->with('success', 'Producto actualizado exitosamente.');

       
    }

    public function create() // Método para agregar un producto
    {
        return view('products.create', ['producto' => null, 'key' => null]); // Retorna la vista para agregar producto
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

        $this->productoModel->add([ // Usa el método `add` del modelo
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
        $productos = $this->productoModel->all(); // Obtiene todos los productos
        return view('products.productos', compact('productos'));
    }

    public function deleteProduct($key)
    {
        $this->productoModel->delete($key); // Elimina el producto directamente
        return redirect()->route('products.productos')->with('success', 'Producto eliminado con éxito');
    }

  
}
