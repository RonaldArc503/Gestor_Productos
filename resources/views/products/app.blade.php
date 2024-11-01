<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galería de Productos</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        /* Aplicar la fuente Roboto */
        body {
            font-family: 'Roboto', sans-serif;
        }
        
        /* Estilos para el contenedor de la imagen del producto */
        .product-image-container {
            padding: 10px; /* Ajusta el valor según tus preferencias */
        }

        /* Estilos para la imagen del producto */
        .product-image {
            width: 100%;
            height: 150px;
            object-fit: contain; /* Mostrar imagen completa */
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
            background-color: #f8f9fa; /* Fondo gris claro para contraste */
        }

        /* Estilos para el título de la tarjeta y el botón */
        .card-title {
            font-weight: 500;
            font-size: 1rem;
            margin-bottom: 0.5rem;
        }

        .btn-primary i {
            margin-right: 5px;
        }

        .no-results {
            display: none; /* Hidden by default */
            text-align: center;
            margin-top: 20px;
            font-weight: bold;
        }

        /* Estilos para el buscador */
        .search-container {
            position: relative;
            margin-bottom: 20px;
        }

        .search-container input {
            width: 100%;
            padding: 10px 40px 10px 40px; /* Espacio para el ícono */
            border-radius: 25px;
            border: 1px solid #ced4da;
        }

        .search-container input::placeholder {
            color: #aaa;
        }

        .search-icon {
            position: absolute;
            left: 15px; /* Ajusta según el espacio que necesites */
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
        }

        /* Estilos para el botón de categoría */
        .category-btn {
            margin-right: 5px;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Mi Tienda</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Productos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contacto</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Carrito</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-5">
       

        <!-- Search Input -->
        <div class="search-container">
            <i class="fas fa-search search-icon"></i>
            <input type="text" id="searchInput" class="form-control" placeholder="  Busca todo lo que necesites..." onkeyup="filterProducts()">
        </div>

        <!-- Category Buttons -->
        <div class="form-group">
            <button class="btn btn-secondary category-btn" onclick="filterByCategory('', this)">Todas</button>
            <button class="btn btn-secondary category-btn" onclick="filterByCategory('Alimentos', this)">Alimentos</button>
            <button class="btn btn-secondary category-btn" onclick="filterByCategory('Electrónica', this)">Electrónica</button>
            <button class="btn btn-secondary category-btn" onclick="filterByCategory('Ropa', this)">Ropa</button>
            <button class="btn btn-secondary category-btn" onclick="filterByCategory('Hogar', this)">Hogar</button>
            <button class="btn btn-secondary category-btn" onclick="filterByCategory('Deportes', this)">Deportes</button>
        </div>

        <!-- Product Cards -->
        <div class="row" id="productTableBody">
            @foreach($productos as $producto)
            <div class="col-6 col-md-4 col-lg-3 mb-4" data-category="{{ $producto['category'] }}">
                <div class="card h-100 shadow-sm">
                    <div class="product-image-container">
                        <img src="{{ $producto['photo_url'] ?? asset('images/default-product.jpg') }}" class="product-image" alt="Foto del producto">
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h3 class="card-title">${{ number_format($producto['price'], 2) }}</h3> 
                        <p>{{ ucwords(strtolower($producto['name'])) }}</p>
                        <p class="card-text">{{ $producto['brand'] }}<br></p>
                        <button class="btn btn-primary mt-auto" onclick="agregarProducto('{{ $producto['name'] }}')">
                            <i class="fas fa-shopping-cart"></i> Agregar
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="no-results">No se encontraron resultados.</div> <!-- No results message -->
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let selectedCategory = ''; // Variable para almacenar la categoría seleccionada
        function filterProducts() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toLowerCase();
            const table = document.getElementById('productTableBody');
            const rows = table.getElementsByClassName('col-6'); // Get product rows
            let hasResults = false;

            for (let i = 0; i < rows.length; i++) {
                const productCard = rows[i].getElementsByClassName('card-body')[0];
                const name = productCard.getElementsByTagName('p')[0].textContent.toLowerCase(); // Product name
                const category = rows[i].getAttribute('data-category').toLowerCase(); // Get category from data attribute

                // Check if the product matches the search name and selected category
                if (name.indexOf(filter) > -1 &&
                    (selectedCategory === '' || category === selectedCategory.toLowerCase())) {
                    rows[i].style.display = ""; // Show the row
                    hasResults = true;
                } else {
                    rows[i].style.display = "none"; // Hide the row
                }
            }

            // Show/hide the no results message
            document.querySelector('.no-results').style.display = hasResults ? 'none' : '';
        }

        function filterByCategory(category, button) {
            selectedCategory = category; // Update the selected category
            filterProducts(); // Filter products after category selection

            // Remove active class from all category buttons
            const buttons = document.querySelectorAll('.category-btn');
            buttons.forEach(btn => btn.classList.remove('active-category'));

            // Add active class to the selected category button
            button.classList.add('active-category');
        }

        function agregarProducto(nombreProducto) {
            alert("Producto " + nombreProducto + " agregado al carrito");
            // Aquí puedes agregar lógica para manejar el carrito de compras
        }
    </script>
</body>
</html>
