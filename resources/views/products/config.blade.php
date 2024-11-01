<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configurar Pedido</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> 
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.5;
            background-color: #f8f9fa; 
        }
        header {
            background-color: #343a40; 
            color: white;
            padding: 20px 0;
            position: relative;
        }
        .back-button {
            position: absolute;
            top: 10px;
            left: 10px;
        }
        .container {
            margin-top: 60px; 
            background-color: white; 
            padding: 20px;
            border-radius: 8px; 
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); 
        }
        footer {
            text-align: center;
            margin-top: 20px;
            padding: 10px 0;
            background-color: #343a40;
            color: white;
        }
        .form-group {
            margin-bottom: 15px; 
        }
        .mt-4 {
            margin-top: 1.5rem; /* Espacio superior para el formulario predeterminado */
        }
    </style>
</head>
<body>
    <header>
        <a href="{{ route('products.productos') }}" class="btn btn-secondary back-button"><i class="fas fa-arrow-left"></i> Regresar</a>
    </header>

    <main>
        <div class="container">
            <h2 class="text-center">Configurar Pedido para: {{ $producto['name'] }}</h2>
            
            <!-- Formulario para enviar un pedido -->
            <form action="{{ route('send.mail') }}" method="POST" id="orderForm">
                @csrf
                <input type="hidden" name="product_name" value="{{ $producto['name'] }}"> 
                <input type="hidden" name="product_brand" value="{{ $producto['brand'] }}">

                <div class="form-group">
                    <label for="orderQuantity">Cantidad de Pedido:</label>
                    <input type="number" class="form-control" id="orderQuantity" name="quantity" min="1" required>
                </div>

                <div class="form-group">
                    <label for="recipient">Correo Electrónico:</label>
                    <input type="email" class="form-control" id="recipient" name="recipient" required>
                </div>

                <div class="text-center">
                    <button type="button" class="btn btn-primary" onclick="confirmOrder()">Enviar Pedido</button>
                </div>
            </form>

            <hr class="mt-4">

            <!-- Formulario para configurar el pedido predeterminado -->
            <h3 class="text-center mt-4">Configurar Pedido Predeterminado</h3>
            <form action="{{ route('set.default.order') }}" method="POST" id="defaultOrderForm">
                @csrf
                <input type="hidden" name="product_name" value="{{ $producto['name'] }}">
                <input type="hidden" name="quantity" id="defaultOrderQuantity" value="10"> <!-- Cantidad predeterminada -->
                <input type="hidden" name="recipient" id="defaultRecipient" value="{{ old('recipient') }}">
                <div class="text-center">
                    <button type="submit" class="btn btn-info ml-2">Configurar Predeterminado</button>
                </div>
            </form>
        </div>
    </main>

    <footer>
        <p>&copy; {{ date('Y') }} Mi Aplicación</p>
    </footer>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> 
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function confirmOrder() {
            const quantity = document.getElementById('orderQuantity').value;
            const recipient = document.getElementById('recipient').value;

            // Muestra un cuadro de confirmación
            if (confirm(`¿Está seguro de que desea enviar un pedido de ${quantity} unidades al correo ${recipient}?`)) {
                document.getElementById('orderForm').submit(); // Envía el formulario si el usuario confirma
            }
        }
    </script>
</body>
</html>
