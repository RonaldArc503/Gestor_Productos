<?php

namespace App\Models;

use Kreait\Firebase\Database;
use Kreait\Firebase\Factory;

class DefaultOrder
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
     * Agregar un nuevo pedido a Firebase.
     *
     * @param array $data
     * @return void
     */
    public function add(array $data)
    {
        // Crear una nueva referencia en 'default_orders' con una nueva clave
        $this->database->getReference('default_orders')->push($data);
    }

    /**
     * Obtener todos los pedidos desde Firebase.
     *
     * @return array
     */
    public function all()
    {
        // Obtener todos los pedidos desde Firebase
        $orders = $this->database->getReference('default_orders')->getValue();

        // Devolver los pedidos como un array, o un array vacío si no hay pedidos
        return $orders ? $orders : [];
    }

    /**
     * Obtener un pedido específico desde Firebase.
     *
     * @param string $key
     * @return array|null
     */
    public function get($key)
    {
        // Obtener un pedido por su clave desde Firebase
        $order = $this->database->getReference('default_orders/' . $key)->getValue();

        // Añadir la clave al pedido si existe
        if ($order) {
            $order['key'] = $key;
        }

        return $order;
    }

    /**
     * Actualizar un pedido en Firebase.
     *
     * @param string $key
     * @param array $data
     * @return void
     */
    public function update($key, array $data)
    {
        // Actualizar los datos del pedido con la clave especificada
        $this->database->getReference('default_orders/' . $key)->update($data);
    }

    /**
     * Eliminar un pedido de Firebase.
     *
     * @param string $key
     * @return void
     */
    public function delete($key)
    {
        // Eliminar un pedido de Firebase por su clave
        $this->database->getReference('default_orders/' . $key)->remove();
    }
}
