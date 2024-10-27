<?php

namespace App\Http\Controllers;

use Kreait\Firebase\Factory;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    protected $database;

    public function __construct()
    {
        // Inicializa la conexión con Firebase
        $this->database = (new Factory)
            ->withServiceAccount(storage_path('app/forgedream-firebase-adminsdk-1jxfy-ba1ad72f1f.json'))
            ->withDatabaseUri('https://forgedream-default-rtdb.firebaseio.com/') // Asegúrate de incluir la URL de la base de datos
            ->createDatabase();
    }

    // Método para mostrar el formulario de agregar producto
    public function create()
    {
        return view('products.create'); // Asegúrate de que la vista se llama 'create.blade.php'
    }

    // Método para agregar un producto
    public function addProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'brand' => 'required|string',
            'category' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'stock' => 'required|integer',
        ]);

        // Agregar el producto a Firebase
        $this->database->getReference('productos')->push([
            'name' => $request->name,
            'brand' => $request->brand,
            'category' => $request->category,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'stock' => $request->stock,
        ]);

       // return response()->json(['status' => 'Producto agregado con éxito']);
    }
}
