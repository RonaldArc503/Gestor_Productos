<?php

namespace App\Models;

use Kreait\Firebase\Database;
use Kreait\Firebase\Factory;

class Producto
{
    protected $database;

    public function __construct()
    {
        // Inicializa la conexión a Firebase
        $this->database = (new Factory)
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
        // Crear una nueva referencia en 'productos' con una nueva clave
        $this->database->getReference('productos')->push($data);
    }

    /**
     * Obtener todos los productos desde Firebase.
     *
     * @return array
     */
    public function all()
    {
        // Obtener todos los productos desde Firebase
        $productos = $this->database->getReference('productos')->getValue();

        // Devolver los productos como un array, o un array vacío si no hay productos
        return $productos ? $productos : [];
    }

    /**
     * Obtener un producto específico desde Firebase.
     *
     * @param string $key
     * @return array|null
     */
    public function get($key)
    {
        // Obtener un producto por su clave desde Firebase
        return $this->database->getReference('productos/' . $key)->getValue();
    }

    /**
     * Actualizar un producto en Firebase.
     *
     * @param string $key
     * @param array $data
     * @return void
     */
    public function update($key, array $data)
    {
        // Actualizar los datos del producto con la clave especificada
        $this->database->getReference('productos/' . $key)->update($data);
    }

    /**
     * Eliminar un producto de Firebase.
     *
     * @param string $key
     * @return void
     */
    public function delete($key)
    {
        // Eliminar un producto de Firebase por su clave
        $this->database->getReference('productos/' . $key)->remove();
    }
}
