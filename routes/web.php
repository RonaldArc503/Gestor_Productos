<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FirebaseTestController;
use Kreait\Firebase\Factory;
use App\Http\Controllers\ProductoController;

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

Route::prefix('products')->group(function () {
    Route::get('/create', [ProductoController::class, 'create'])->name('products.create'); // Ruta para crear un producto
    Route::post('/store', [ProductoController::class, 'addProduct'])->name('products.store'); // Guardar nuevo producto
    Route::get('/productos', [ProductoController::class, 'productos'])->name('products.productos'); // Listar productos
   
    Route::get('/{key}/editar', [ProductoController::class, 'edit'])->name('products.edit'); // Ruta para editar producto

    Route::put('/update/{key}', [ProductoController::class, 'update'])->name('products.update'); // Actualizar producto
    Route::delete('/{key}', [ProductoController::class, 'deleteProduct'])->name('products.delete'); // Eliminar producto
    Route::get('/search', [ProductoController::class, 'search'])->name('products.search'); // Buscar productos
});

