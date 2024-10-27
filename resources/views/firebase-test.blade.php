<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Firebase Test</title>
</head>
<body>
    <h1>Prueba de Firebase</h1>
    <p>{{ $status }}</p>
    @if(isset($message))
        <p style="color: red;">{{ $message }}</p>
    @endif
</body>
</html>
