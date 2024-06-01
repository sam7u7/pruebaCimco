<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <h1>Productos</h1>
    <button class="btn btn-primary" data-toggle="modal" data-target="#createProductModal">Agregar Producto</button>
    
    <!-- Modal -->
    <div class="modal fade" id="createProductModal" tabindex="-1" role="dialog" aria-labelledby="createProductModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createProductModalLabel">Agregar Producto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createProductForm">
                        @csrf
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="marca">Marca</label>
                            <input type="text" class="form-control" id="marca" name="marca" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#createProductForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            type: POST,
            url: '{{ route(productos.store) }}',
            data: $(this).serialize(),
            success: function(response) {
                alert(response.success);
                $('#createProductModal').modal('hide');
                $('#createProductForm')[0].reset();
            },
            error: function(response) {
                console.log(response);
                alert('Error al crear el producto');
            }
        });
    });
});
</script>
</body>
</html>
