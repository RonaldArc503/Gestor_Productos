<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($producto) ? 'Editar Producto' : 'Agregar Producto' }}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<!-- Menú de navegación -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Mi Tienda</a>
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
                <a class="nav-link" href="#">Contacto</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container mt-5">
    <h1>{{ isset($producto) ? 'Editar Producto' : 'Agregar Producto' }}</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Mostrar datos del producto si está definido 
    @if(isset($producto))
        <p><strong>Datos del producto:</strong></p>
        <p><strong>Nombre:</strong> {{ $producto['name'] }}</p>
        <p><strong>Marca:</strong> {{ $producto['brand'] }}</p>
        <p><strong>Categoría:</strong> {{ $producto['category'] }}</p>
        <p><strong>Precio:</strong> {{ $producto['price'] }}</p>
        <p><strong>Stock:</strong> {{ $producto['stock'] }}</p>
    @endif-->

    <form action="{{ isset($producto) ? route('products.update', $key) : route('products.store') }}" method="POST">
    @csrf
    @if(isset($producto))
        @method('PUT')
    @endif

    <input type="text" name="name" value="{{ $producto['name'] ?? '' }}" required>
    <input type="text" name="brand" value="{{ $producto['brand'] ?? '' }}" required>
    <input type="text" name="category" value="{{ $producto['category'] ?? '' }}" required>
    <input type="number" name="price" value="{{ $producto['price'] ?? '' }}" required>
    <input type="number" name="stock" value="{{ $producto['stock'] ?? '' }}" required>
    <button type="submit" class="btn btn-success">{{ isset($producto) ? 'Actualizar' : 'Agregar' }}</button>
</form>

</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
