<?php

namespace App\Models;

use Kreait\Firebase\Database; // Asegúrate de importar la clase de la base de datos
use Kreait\Firebase\Factory;

class Producto
{
    protected $database;

    public function __construct()
    {
        // Inicializa la conexión con Firebase
        $this->database = (new Factory)
            ->withServiceAccount(storage_path('app/forgedream-firebase-adminsdk-1jxfy-ba1ad72f1f.json'))
            ->withDatabaseUri('https://forgedream-default-rtdb.firebaseio.com/')
            ->createDatabase();
    }

    // Método para agregar un producto
    public function add($data)
    {
        // Validación básica
        if (empty($data['name']) || empty($data['brand']) || empty($data['category']) || empty($data['price']) || !isset($data['stock'])) {
            throw new \InvalidArgumentException("Todos los campos son requeridos.");
        }
        
        // Agregar el producto a la base de datos
        return $this->database->getReference('productos')->push($data);
    }
    
    // Método para obtener todos los productos
    public function all()
    {
        // Recuperar todos los productos y manejar la posible ausencia de datos
        $productos = $this->database->getReference('productos')->getValue();
        return $productos ? $productos : [];
    }

    // Método para encontrar un producto por su clave
    public function find($key)
    {
        // Recuperar el producto por clave y manejar la posible ausencia de datos
        $producto = $this->database->getReference('productos/' . $key)->getValue();
        return $producto ? $producto : null; // Retorna null si no se encuentra
    }

    // Método para actualizar un producto
    public function update($key, $data)
    {
        // Validación básica
        if (empty($data['name']) || empty($data['brand']) || empty($data['category']) || empty($data['price']) || !isset($data['stock'])) {
            throw new \InvalidArgumentException("Todos los campos son requeridos.");
        }

        return $this->database->getReference('productos/' . $key)->update($data);
    }

    // Método para eliminar un producto
    public function delete($key)
    {
        return $this->database->getReference('productos/' . $key)->remove();
    }
}
