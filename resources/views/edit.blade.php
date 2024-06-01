<!-- resources/views/posts/edit.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Editar </title>
    
</head>
<body>
    <div class="container">
        <h1>Editar</h1>

        <form action="{{ route('update', $producto->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre', $producto->nombre) }}">
            </div>

            <div class="form-group">
                <label for="marca">Marca:</label>
                <textarea class="form-control" id="marca" name="marca">{{ old('content', $producto->marca) }}</textarea>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>

    
</body>
</html>
