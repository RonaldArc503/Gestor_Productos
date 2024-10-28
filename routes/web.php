<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FirebaseTestController;
use Kreait\Firebase\Factory;
use App\Http\Controllers\ProductoController; // Asegúrate de que el nombre coincida con el controlador

Route::get('/', function () {
    try {
        $firebase = (new Factory)->withServiceAccount(storage_path('app/forgedream-firebase-adminsdk-1jxfy-ba1ad72f1f.json'));
        $auth = $firebase->createAuth();

        return view('firebase-test', ['status' => 'Conexión exitosa a Firebase']);
    } catch (\Exception $e) {
        return view('firebase-test', ['status' => 'Error de conexión', 'message' => $e->getMessage()]);
    }
});

// Ruta para la prueba de Firebase
Route::get('/firebase-test', [FirebaseTestController::class, 'index']);

// Rutas para agregar productos
// Rutas para agregar productos
Route::get('/products/create/{key?}', [ProductoController::class, 'create'])->name('products.create'); // Ruta para mostrar el formulario
Route::post('/products/store', [ProductoController::class, 'addProduct'])->name('products.store');
Route::put('/products/update/{key}', [ProductoController::class, 'update'])->name('products.update');
Route::delete('/productos/{key}', [ProductoController::class, 'deleteProduct'])->name('products.delete');
Route::get('/products/productos', [ProductoController::class, 'productos'])->name('products.productos');

// Ruta para mostrar productos
Route::get('/products/search', [ProductoController::class, 'search'])->name('products.search'); // Ruta para buscar productos
