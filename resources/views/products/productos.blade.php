<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Productos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .no-results {
            display: none;
            /* Ocultar inicialmente el mensaje de no resultados */
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Mi Tienda</a>
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
        </div>
    </nav>

    <div class="container mt-5">
        <h1>Gestor de Productos</h1>

        <!-- Mensajes de éxito/error -->
 

        @if(session('success'))
            <div id="success-message" class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <script>
            // Espera 4 segundos y luego oculta el mensaje de éxito
            setTimeout(function () {
                var message = document.getElementById('success-message');
                if (message) {
                    message.style.display = 'none';
                }
            }, 2000); // 4000 ms = 4 segundos
        </script>

        <!-- Campo de búsqueda -->
        <div class="form-group">
            <input type="text" id="searchInput" class="form-control" placeholder="Buscar por nombre de producto"
                onkeyup="filterProducts()">
        </div>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Marca</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="productTableBody">
                    @if($productos && count($productos) > 0) <!-- Verificar si hay productos -->
                        @foreach($productos as $key => $producto)
                            <tr>
                                <td>{{ $producto['name'] }}</td>
                                <td>{{ $producto['brand'] }}</td>
                                <td>{{ $producto['category'] }}</td>
                                <td>{{ $producto['price'] }}</td>
                                <td>{{ $producto['stock'] }}</td>
                                <td>
                                    <a href="{{ route('products.edit', $key) }}" class="btn btn-warning">Editar</a>

                                    <form action="{{ route('products.delete', $key) }}" method="POST" style="display:inline;"
                                        onsubmit="return confirm('¿Estás seguro de que deseas eliminar este producto?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="text-center">No hay productos disponibles</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <div class="no-results text-center">
            <h5>No se encontraron resultados.</h5>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function filterProducts() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toLowerCase();
            const table = document.getElementById('productTableBody');
            const rows = table.getElementsByTagName('tr');
            let hasResults = false;

            for (let i = 0; i < rows.length; i++) {
                const cells = rows[i].getElementsByTagName('td');
                if (cells.length > 0) {
                    const name = cells[0].textContent.toLowerCase(); // Nombre del producto
                    if (name.indexOf(filter) > -1) {
                        rows[i].style.display = ""; // Mostrar la fila
                        hasResults = true;
                    } else {
                        rows[i].style.display = "none"; // Ocultar la fila
                    }
                }
            }

            // Mostrar/ocultar el mensaje de no resultados
            document.querySelector('.no-results').style.display = hasResults ? 'none' : 'block';
        }
    </script>
</body>

</html>