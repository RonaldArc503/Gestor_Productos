<?php

namespace App\Models;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Database;

class Producto
{
    protected $database;
    protected $dbname = 'productos';

    public function __construct()
    {
        // Inicializar Firebase
        $this->database = (new Factory())
            ->withServiceAccount(storage_path('app/forgedream-firebase-adminsdk-1jxfy-ba1ad72f1f.json'))
            ->withDatabaseUri('https://forgedream-default-rtdb.firebaseio.com/')
            ->createDatabase();
    }

    /**
     * Agregar un nuevo producto a Firebase.
     *
     * @param array $data
     * @return void
     */
    public function add(array $data)
    {
        // Crear un nuevo registro en la colección 'productos'
        $this->database->getReference($this->dbname)->push($data);
    }

    /**
     * Obtener todos los productos desde Firebase.
     *
     * @return array
     */
    public function all()
    {
        // Obtener todos los productos
        $productos = $this->database->getReference($this->dbname)->getValue();
        return $productos ? $productos : [];
    }

    /**
     * Eliminar un producto por su clave (key).
     *
     * @param string $key
     * @return void
     */
    public function delete($key)
    {
        // Eliminar un producto por su clave en Firebase
        $this->database->getReference($this->dbname . '/' . $key)->remove();
    }

    /**
     * Obtener un producto por su clave (key).
     *
     * @param string $key
     * @return array|null
     */
    public function get($key)
    {
        // Obtener un producto específico por su clave
        $producto = $this->database->getReference($this->dbname . '/' . $key)->getValue();
        return $producto;
    }
}
