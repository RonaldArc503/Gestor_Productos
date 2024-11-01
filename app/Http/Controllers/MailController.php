<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\PedidosMail;
use Kreait\Firebase\Factory;
use App\Models\Producto;
use App\Models\DefaultOrder;

class MailController extends Controller
{
    protected $database;
    protected $productoModel;
    protected $defaultOrderModel;

    public function __construct()
    {
        // Crear la fábrica de Firebase con la cuenta de servicio
        $firebase = (new Factory)
            ->withServiceAccount(config('firebase.projects.forgedream.credentials'))
            ->withDatabaseUri(config('firebase.database_url'));

        // Inicializar la base de datos y modelos
        $this->database = $firebase->createDatabase();
        $this->productoModel = new Producto();
        $this->defaultOrderModel = new DefaultOrder(); 
    }

    // Método para enviar correo al agotarse el producto según la configuración predeterminada
    protected function sendEmailIfZeroQuantity($recipient, $productName)
    {
        $content = "La cantidad del producto '{$productName}' ha llegado a 0. Por favor, realiza un nuevo pedido.";

        try {
            Mail::to($recipient)->send(new PedidosMail($content));
        } catch (\Exception $e) {
            // Manejar errores si es necesario
        }
    }

    // Configura y guarda un pedido predeterminado en Firebase
    public function setDefaultOrder(Request $request)
    {
        // Validar los datos del pedido
        $request->validate([
            'product_name' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'recipient' => 'required|email',
            'price' => 'required|numeric',
        ]);

        // Datos del pedido predeterminado
        $defaultOrderData = [
            'product_name' => $request->input('product_name'),
            'quantity' => $request->input('quantity'),
            'recipient' => $request->input('recipient'),
            'price' => $request->input('price'),
        ];

        // Verificar si el pedido predeterminado ya existe
        $existingOrder = $this->defaultOrderModel->all();
        foreach ($existingOrder as $key => $order) {
            if ($order['product_name'] === $request->input('product_name') && $order['recipient'] === $request->input('recipient')) {
                return back()->with('error', 'Este pedido predeterminado ya existe.');
            }
        }

        // Guardar el pedido predeterminado
        $this->defaultOrderModel->add($defaultOrderData);
        return back()->with('success', 'Pedido configurado como predeterminado correctamente.');
    }

    // Revisa las cantidades de los pedidos predeterminados y envía un correo si la cantidad es cero
    public function checkDefaultOrders()
    {
        $orders = $this->defaultOrderModel->all();
        
        foreach ($orders as $key => $order) {
            if ($order['quantity'] == 0) {
                // Enviar correo de notificación al destinatario configurado
                $this->sendEmailIfZeroQuantity($order['recipient'], $order['product_name']);
            }
        }
    }

    // Guardar pedido y verificar cantidad para notificación
    public function saveOrder(Request $request)
    {
        // Validar datos
        $request->validate([
            'product_name' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric',
            'is_default' => 'nullable|boolean',
        ]);

        $orderData = [
            'product_name' => $request->input('product_name'),
            'quantity' => $request->input('quantity'),
            'price' => $request->input('price'),
            'created_at' => now()->toDateTimeString()
        ];

        try {
            // Guardar como orden predeterminada o regular
            if ($request->input('is_default')) {
                $this->defaultOrderModel->add($orderData);
                return back()->with('success', 'Configuración de orden predeterminada guardada en Firebase correctamente.');
            } else {
                $this->database->getReference('orders')->push($orderData);
                return back()->with('success', 'Pedido guardado en Firebase correctamente.');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error al guardar en Firebase: ' . $e->getMessage());
        }
    }

    // Actualiza la cantidad de un producto en el pedido predeterminado y verifica si se agotó
    public function updateDefaultOrderQuantity($productName, $newQuantity)
    {
        $orders = $this->defaultOrderModel->all();
        
        foreach ($orders as $key => $order) {
            if ($order['product_name'] === $productName) {
                $this->defaultOrderModel->update($key, ['quantity' => $newQuantity]);

                if ($newQuantity == 0) {
                    $this->sendEmailIfZeroQuantity($order['recipient'], $productName);
                }
            }
        }
    }

    public function showConfig($key)
    {
        $producto = $this->productoModel->get($key);

        if ($producto === null) {
            return redirect()->route('products.productos')->with('error', 'Producto no encontrado.');
        }

        return view('products.config', compact('producto'));
    }

    // MailController.php

// Agrega este método al controlador
protected function validateOrder(Request $request)
{
    $request->validate([
        'product_name' => 'required|string',
        'quantity' => 'required|integer|min:1',
        'recipient' => 'required|email',
        'price' => 'required|numeric',
    ]);
}


   // Envía el correo usando PedidosMail
   public function sendMail(Request $request)
   {
       // Validar los datos del correo
       $request->validate([
           'recipient' => 'required|email',
           'quantity' => 'required|integer|min:1',
           'product_name' => 'required|string',
           'product_brand' => 'required|string',
       ]);
   
       $recipient = $request->input('recipient');
       $quantity = $request->input('quantity');
       $productName = $request->input('product_name');
       $productBrand = $request->input('product_brand');
   
       // Crear contenido del correo en el nuevo formato
       $content = "Solicitud de pedido\n";
       $content .= "Producto: {$productName}\n"; // Asegúrate de que el nombre del producto se está pasando correctamente desde el formulario
       $content .= "Marca: {$productBrand}\n"; // Agrega la marca
       $content .= "Cantidad solicitada: {$quantity}\n"; // Añade la cantidad solicitada
   
       // Enviar el correo de pedido
       try {
           Mail::to($recipient)->send(new PedidosMail($content));
           return back()->with('success', 'Correo enviado correctamente.');
       } catch (\Exception $e) {
           return back()->with('error', 'Error al enviar el correo: ' . $e->getMessage());
       }
   }

   // Guarda el pedido en la base de datos de Firebase

}
