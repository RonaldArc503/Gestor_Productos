<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Productos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/style2.css') }}">
    <style>
        .category-btn.active-category {
            background-color: #343a40; /* Fondo oscuro */
            color: white; /* Color del texto */
        }

        #searchInput {
            border-radius: 50px;
        }

        /* Estilo para la celda de descripción */
        .description-cell {
            max-width: 200px; /* Ancho máximo para la celda de descripción */
            overflow-wrap: break-word; /* Permitir que el texto se divida en palabras */
            word-wrap: break-word; /* Compatibilidad con navegadores más antiguos */
            hyphens: auto; /* Permitir guiones si es necesario */
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#" style="font-weight: bold;">Mi Tienda</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('products.productos') }}">Productos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('products.create') }}">Agregar Producto</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Tienda Vista</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">Iniciar Sesión</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container-fluid mt-5" style="padding-left: 40px; padding-right: 40px;">
        <h1>Gestor de Productos</h1>

        @if(session('success'))
        <div id="success-message" class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <script>
            // Espera 4 segundos y luego oculta el mensaje de éxito
            setTimeout(function() {
                var message = document.getElementById('success-message');
                if (message) {
                    message.style.display = 'none';
                }
            }, 2000); // 2000 ms = 2 segundos
        </script>

        <div class="form-group">
            <input type="text" id="searchInput" class="form-control" placeholder="Buscar por nombre de producto"
                onkeyup="filterProducts()">
        </div>

        <div class="form-group">
            <button class="btn btn-secondary category-btn" onclick="filterByCategory('', this)">Todas</button>
            <button class="btn btn-secondary category-btn"
                onclick="filterByCategory('Alimentos', this)">Alimentos</button>
            <button class="btn btn-secondary category-btn"
                onclick="filterByCategory('Electrónica', this)">Electrónica</button>
            <button class="btn btn-secondary category-btn" onclick="filterByCategory('Ropa', this)">Ropa</button>
            <button class="btn btn-secondary category-btn" onclick="filterByCategory('Hogar', this)">Hogar</button>
            <button class="btn btn-secondary category-btn"
                onclick="filterByCategory('Deportes', this)">Deportes</button>
        </div>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Descripción</th>
                        <th>Marca</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Stock</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="productTableBody">
    @if($productos && count($productos) > 0)
    @foreach($productos as $key => $producto)
    <tr>
        <td>
            @if(isset($producto['photo_url']) && $producto['photo_url'] !== '')
            <img src="{{ $producto['photo_url'] }}" alt="Foto de {{ $producto['name'] }}" width="80" height="80">
            @else
            <span>No Image</span>
            @endif
        </td>
        <td class="description-cell">{{ $producto['name'] }}</td>
        <td>{{ $producto['brand'] }}</td>
        <td>{{ $producto['category'] }}</td>
        <td>{{ $producto['price'] }}</td>
        <td>{{ $producto['cantidad'] ?? 'N/A' }}</td>
        <td>{{ $producto['stock'] }}</td>
        <td>
            <a href="{{ route('products.edit', $key) }}" class="btn btn-warning">Editar</a>
            <form action="{{ route('products.delete', $key) }}" method="POST" style="display:inline;"
                onsubmit="return confirm('¿Estás seguro de que deseas eliminar este producto?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Eliminar</button>
            </form>
            <!-- Botón para generar QR -->
            <button class="btn btn-info" onclick="generateQRCode(
                                                        '{{ $producto['name'] }}', 
                                                        '{{ $producto['brand'] }}', 
                                                        '{{ $producto['category'] }}', 
                                                        '{{ $producto['price'] }}', 
                                                        '{{ $producto['cantidad'] ?? 'N/A' }}', 
                                                        '{{ $producto['stock'] }}'
                                                    )">QR</button>
            <!-- Botón para enviar pedido -->
    <a href="{{ route('products.config', $key) }}" class="btn btn-success">Solicitar Pedido</a>
        </td>
    </tr>
    @endforeach
    @else
    <tr id="noResultsRow" style="display:none;">
        <td colspan="7" class="text-center">No hay productos disponibles</td>
    </tr>
    @endif
</tbody>

            </table>
        </div>

        <div class="no-results text-center" id="noResultsMessage" style="display:none;">
            <h5>No se encontraron resultados.</h5>
        </div>
    </div>

    <!-- Modal para mostrar el QR -->
    <div class="modal fade" id="qrModal" tabindex="-1" role="dialog" aria-labelledby="qrModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="qrModalLabel">Código QR del Producto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <canvas id="qrCanvas"></canvas>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/qrious@4.0.2/dist/qrious.min.js"></script>

    <script>
        let selectedCategory = ''; // Variable para almacenar la categoría seleccionada

        function filterProducts() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toLowerCase();
            const table = document.getElementById('productTableBody');
            const rows = table.getElementsByTagName('tr');
            let hasResults = false;

            for (let i = 0; i < rows.length; i++) {
                const cells = rows[i].getElementsByTagName('td');
                if (cells.length > 0) {
                    const productName = cells[1].textContent || cells[1].innerText;
                    const productCategory = cells[3].textContent || cells[3].innerText;

                    if (productName.toLowerCase().indexOf(filter) > -1 && 
                        (selectedCategory === '' || productCategory === selectedCategory)) {
                        rows[i].style.display = '';
                        hasResults = true;
                    } else {
                        rows[i].style.display = 'none';
                    }
                }
            }

            // Muestra el mensaje si no hay resultados
            document.getElementById('noResultsMessage').style.display = hasResults ? 'none' : 'block';
            document.getElementById('noResultsRow').style.display = hasResults ? 'none' : '';
        }

        function filterByCategory(category, btn) {
            selectedCategory = category; // Actualiza la categoría seleccionada
            const buttons = document.querySelectorAll('.category-btn');

            buttons.forEach(button => {
                button.classList.remove('active-category'); // Quita la clase activa de todos los botones
            });

            btn.classList.add('active-category'); // Agrega clase activa al botón presionado
            filterProducts(); // Filtra productos con la nueva categoría
        }

        function generateQRCode(name, brand, category, price, cantidad, stock) {
            const qrCanvas = document.getElementById('qrCanvas');
            const qr = new QRious({
                element: qrCanvas,
                value: `Nombre: ${name}\nMarca: ${brand}\nCategoría: ${category}\nPrecio: ${price}\nCantidad: ${cantidad}\nStock: ${stock}`,
                size: 200
            });
            $('#qrModal').modal('show'); // Muestra el modal
        }
    </script>
</body>

</html>
