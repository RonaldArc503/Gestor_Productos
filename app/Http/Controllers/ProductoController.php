<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Storage;

class ProductoController extends Controller
{
    protected $productoModel;
    protected $storage;

    public function __construct()
    {
        // Inicializa el modelo de Producto que interactúa con Firebase
        $this->productoModel = new Producto();

        // Inicializa Firebase usando el archivo JSON de credenciales
        $firebase = (new Factory)
            ->withServiceAccount(storage_path('app/forgedream-firebase-adminsdk-1jxfy-ba1ad72f1f.json'));

        // Crear la instancia de Storage
        $this->storage = $firebase->createStorage();
    }

    /**
     * Mostrar el formulario para crear un nuevo producto.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
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
            'cantidad' => 'required|integer',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validación de la imagen
        ]);

        // Manejar la subida de la imagen
        $photoUrl = null;
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();

            // Cargar la imagen en Firebase Storage
            $bucket = $this->storage->getBucket();
            $bucket->upload(
                fopen($file->getRealPath(), 'r'),
                [
                    'name' => 'product_photos/' . $filename,
                ]
            );

            // Obtener la URL pública de la imagen
            $photoUrl = $bucket->object('product_photos/' . $filename)->signedUrl(new \DateTime('9999-12-31'));
        }

        // Determinar el estado del stock
        $stockStatus = $request->cantidad == 0 ? 'agotado' : 'en stock';

        // Agregar el producto usando el modelo y guardando la URL de la imagen
        $this->productoModel->add([
            'name' => strtoupper($request->name), // Convertir a mayúsculas
            'brand' => $request->brand,
            'category' => $request->category,
            'price' => $request->price,
            'cantidad' => $request->cantidad,
            'stock' => $stockStatus, // Guardar el estado del stock
            'photo_url' => $photoUrl, // Guardar la URL de la foto
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
        $producto = $this->productoModel->get($key);

        if ($producto === null) {
            return redirect()->route('products.productos')->with('error', 'Producto no encontrado.');
        }

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
            'cantidad' => 'required|integer', // Add validation for cantidad
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Manejar la subida de la imagen si existe
        $photoUrl = null;
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();

            // Cargar la imagen en Firebase Storage
            $bucket = $this->storage->getBucket();
            $bucket->upload(
                fopen($file->getRealPath(), 'r'),
                [
                    'name' => 'product_photos/' . $filename,
                ]
            );

            // Obtener la URL pública de la imagen
            $photoUrl = $bucket->object('product_photos/' . $filename)->signedUrl(new \DateTime('9999-12-31'));
        }

        // Determinar el estado del stock
        $stockStatus = $request->cantidad == 0 ? 'agotado' : 'en stock';

        // Actualizar el producto en Firebase usando el modelo, incluyendo la URL de la imagen si se ha subido una nueva
        $updateData = [
            'name' => strtoupper($request->input('name')),
            'brand' => $request->input('brand'),
            'category' => $request->input('category'),
            'price' => $request->input('price'),
            'cantidad' => $request->input('cantidad'),
            'stock' => $stockStatus, // Actualiza el estado del stock
        ];

        if ($photoUrl) {
            $updateData['photo_url'] = $photoUrl; // Actualiza la URL de la foto si se ha subido una nueva
        }

        $this->productoModel->update($key, $updateData);

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
