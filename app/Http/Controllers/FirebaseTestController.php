<?php

namespace App\Http\Controllers;

use Kreait\Firebase\Factory;
use Illuminate\Http\Request;

class FirebaseTestController extends Controller
{
    public function index()
    {
        try {
            // Crear una instancia del cliente de Firebase
            $firebase = (new Factory)->withServiceAccount(storage_path('app/forgedream-firebase-adminsdk-1jxfy-ba1ad72f1f.json'));

            // Probar la conexión autenticando al usuario
            $auth = $firebase->createAuth();

            // Si se obtiene el objeto de autenticación, significa que la conexión es exitosa
            // Puedes pasar información a la vista si lo necesitas
            return view('firebase-test', ['status' => 'Conexión exitosa a Firebase']);
        } catch (\Exception $e) {
            // Manejo de errores
            return view('firebase-test', ['status' => 'Error de conexión', 'message' => $e->getMessage()]);
        }
    }
}
