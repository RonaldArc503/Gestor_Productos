<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Productos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .category-btn.active-category {
            background-color: #343a40; /* Fondo oscuro */
            color: white; /* Color del texto */
        }
    </style>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#" style="font-weight: bold;">Mi Tienda</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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
        setTimeout(function () {
            var message = document.getElementById('success-message');
            if (message) {
                message.style.display = 'none';
            }
        }, 2000); // 2000 ms = 2 segundos
    </script>

    <div class="form-group">
        <input type="text" id="searchInput" class="form-control" placeholder="Buscar por nombre de producto" onkeyup="filterProducts()">
    </div>

    <div class="form-group">
        <button class="btn btn-secondary category-btn" onclick="filterByCategory('', this)">Todas</button>
        <button class="btn btn-secondary category-btn" onclick="filterByCategory('Alimentos', this)">Alimentos</button>
        <button class="btn btn-secondary category-btn" onclick="filterByCategory('Electrónica', this)">Electrónica</button>
        <button class="btn btn-secondary category-btn" onclick="filterByCategory('Ropa', this)">Ropa</button>
        <button class="btn btn-secondary category-btn" onclick="filterByCategory('Hogar', this)">Hogar</button>
        <button class="btn btn-secondary category-btn" onclick="filterByCategory('Deportes', this)">Deportes</button>
    </div>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Descripcion</th>
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
                            <td>{{ $producto['name'] }}</td>
                            <td>{{ $producto['brand'] }}</td>
                            <td>{{ $producto['category'] }}</td>
                            <td>{{ $producto['price'] }}</td>
                            <td>{{ $producto['cantidad'] ?? 'N/A' }}</td>
                            <td>{{ $producto['stock'] }}</td>
                            <td>
                                <a href="{{ route('products.edit', $key) }}" class="btn btn-warning">Editar</a>
                                <form action="{{ route('products.delete', $key) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este producto?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                </form>
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

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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
                const name = cells[1].textContent.toLowerCase(); // Product name
                const category = cells[3].textContent.toLowerCase(); // Category updated to index 3

                // Check if the product matches the search name and selected category
                if (name.indexOf(filter) > -1 && 
                    (selectedCategory === '' || category === selectedCategory.toLowerCase())) {
                    rows[i].style.display = ""; // Show the row
                    hasResults = true;
                } else {
                    rows[i].style.display = "none"; // Hide the row
                }
            }
        }

        // Show/hide the no results message
        document.querySelector('.no-results').style.display = hasResults ? 'none' : 'block';
    }

    function filterByCategory(category, button) {
        selectedCategory = category;
        console.log(`Selected category: ${selectedCategory}`); // Debugging line

        // Remove the active class from all buttons
        const buttons = document.querySelectorAll('.category-btn');
        buttons.forEach(btn => {
            btn.classList.remove('active-category');
        });

        // Add the active class to the clicked button
        button.classList.add('active-category');

        // Call the filterProducts function to apply the filter
        filterProducts();
    }
</script>

</body>
</html>
