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
                <a class="nav-link" href="#">Tienda Vista</a>
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

   

    <form action="{{ isset($producto) ? route('products.update', $key) : route('products.store') }}" method="POST">
        @csrf
        @if(isset($producto))
            @method('PUT') <!-- Esto es importante para las actualizaciones -->
        @endif

        <div class="form-group">
            <label for="name">Nombre:</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $producto['name'] ?? '') }}" required>
        </div>

        <div class="form-group">
            <label for="brand">Marca:</label>
            <input type="text" class="form-control" id="brand" name="brand" value="{{ old('brand', $producto['brand'] ?? '') }}" required>
        </div>

        <div class="form-group">
            <label for="category">Categoría:</label>
            <select class="form-control" id="category" name="category" required>
                <option value="">Seleccionar categoría</option>
                <option value="Electrónica" {{ (isset($producto) && $producto['category'] == 'Electrónica') ? 'selected' : '' }}>Electrónica</option>
                <option value="Ropa" {{ (isset($producto) && $producto['category'] == 'Ropa') ? 'selected' : '' }}>Ropa</option>
                <option value="Alimentos" {{ (isset($producto) && $producto['category'] == 'Alimentos') ? 'selected' : '' }}>Alimentos</option>
                <option value="Hogar" {{ (isset($producto) && $producto['category'] == 'Hogar') ? 'selected' : '' }}>Hogar</option>
                <option value="Deportes" {{ (isset($producto) && $producto['category'] == 'Deportes') ? 'selected' : '' }}>Deportes</option>
            </select>
        </div>

        <div class="form-group">
            <label for="price">Precio:</label>
            <input type="number" class="form-control" id="price" name="price" step="0.01" value="{{ old('price', $producto['price'] ?? '') }}" required>
        </div>

        <div class="form-group">
            <label for="stock">Stock:</label>
            <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock', $producto['stock'] ?? '') }}" required>
        </div>

        <button type="submit" class="btn btn-primary">{{ isset($producto) ? 'Actualizar Producto' : 'Agregar Producto' }}</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
