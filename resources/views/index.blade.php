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
    <input type="text" id="filter-name" class="form-control mt-3" placeholder="Filtrar por nombre" style="width: 300px;">
    <button class="btn btn-success float-right" onclick="window.location='{{ route('productos.export') }}'">Exportar a CSV</button>
    <!-- Tabla de Productos -->
    <table class="table mt-4">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Marca</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="productTableBody">
            @foreach($productos as $producto)
                <tr id="producto-{{ $producto->id }}">
                    <td>{{ $producto->id }}</td>
                    <td>{{ $producto->nombre }}</td>
                    <td>{{ $producto->marca }}</td>
                    <td>
                        <button class="btn btn-warning btn-sm edit-button" data-id="{{ $producto->id }}" data-toggle="modal" data-target="#editProductModal">Editar</button>
                        <button class="btn btn-danger btn-sm delete-button" data-id="{{ $producto->id }}" data-toggle="modal" data-target="#deleteProductModal">Eliminar</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal Crear Producto -->
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

    <!-- Modal Editar Producto -->
    <div class="modal fade" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="editProductModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProductModalLabel">Editar Producto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editProductForm">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="edit-product-id" name="id">
                        <div class="form-group">
                            <label for="edit-nombre">Nombre</label>
                            <input type="text" class="form-control" id="edit-nombre" name="nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-marca">Marca</label>
                            <input type="text" class="form-control" id="edit-marca" name="marca" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Eliminar Producto -->
    <div class="modal fade" id="deleteProductModal" tabindex="-1" role="dialog" aria-labelledby="deleteProductModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteProductModalLabel">Eliminar Producto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>¿Estás seguro de que deseas eliminar este producto?</p>
                    <form id="deleteProductForm">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" id="delete-product-id" name="id">
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    var storeUrl;
    var storeUrl = @json(route('productos.store'));
    var indexUrl = @json(route('productos.index'));
    var editUrl = @json(route('productos.edit', ':id'));
    var updateUrl = @json(route('productos.update', ':id'));
    var deleteUrl = @json(route('productos.destroy', ':id'));
    var filterUrl = @json(route('productos.filter'));

    $('#createProductForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            type: 'POST',
            url: storeUrl,
            data: $(this).serialize(),
            success: function(response) {
                alert(response.success);
                $('#createProductModal').modal('hide');
                $('#createProductForm')[0].reset();
                var producto = response.producto;
                $('#productTableBody').append('<tr id="producto-' + producto.id + '"><td>' + producto.id
                 + '</td><td>' + producto.nombre + '</td><td>' + producto.marca + 
                 '</td><td><button class="btn btn-warning btn-sm edit-button" data-id="' + producto.id +
                  '" data-toggle="modal" data-target="#editProductModal">Editar</button> <button class="btn btn-danger btn-sm delete-button" data-id="'
                  + producto.id + '" data-toggle="modal" data-target="#deleteProductModal">Eliminar</button></td></tr>');
            },
            error: function(response) {
                console.log(response);
                alert('Error al crear el producto');
            }
        });
    });

    $(document).on('click', '.edit-button', function() {
        var id = $(this).data('id');
        $.ajax({
            type: 'GET',
            url: editUrl.replace(':id', id),
            success: function(producto) {
                $('#edit-product-id').val(producto.id);
                $('#edit-nombre').val(producto.nombre);
                $('#edit-marca').val(producto.marca);
            },
            error: function(response) {
                console.log(response);
                alert('Error al obtener los datos del producto');
            }
        });
    });

    $('#editProductForm').on('submit', function(e) {
        e.preventDefault();
        var id = $('#edit-product-id').val();
        $.ajax({
            type: 'PUT',
            url: updateUrl.replace(':id', id),
            data: $(this).serialize(),
            success: function(response) {
                alert(response.success);
                $('#editProductModal').modal('hide');
                var producto = response.producto;
                $('#producto-' + producto.id + ' td:nth-child(2)').text(producto.nombre);
                $('#producto-' + producto.id + ' td:nth-child(3)').text(producto.marca);
            },
            error: function(response) {
                console.log(response);
                alert('Error al actualizar el producto');
            }
        });
    });

    $(document).on('click', '.delete-button', function() {
        var id = $(this).data('id');
        $('#delete-product-id').val(id);
    });

    $('#deleteProductForm').on('submit', function(e) {
        e.preventDefault();
        var id = $('#delete-product-id').val();
        $.ajax({
            type: 'DELETE',
            url: deleteUrl.replace(':id', id),
            data: $(this).serialize(),
            success: function(response) {
                alert(response.success);
                $('#deleteProductModal').modal('hide');
                $('#producto-' + id).remove();
            },
            error: function(response) {
                console.log(response);
                alert('Error al eliminar el producto');
            }
        });
    });
    $('#filter-name').on('keyup', function() {
        var nombre = $(this).val();
        $.ajax({
            type: 'GET',
            url: filterUrl,
            data: { nombre: nombre },
            success: function(productos) {
                $('#productTableBody').empty();
                productos.forEach(function(producto) {
                    $('#productTableBody').append('<tr id="producto-' + producto.id + '"><td>' + producto.id + 
                    '</td><td>' + producto.nombre + '</td><td>' + producto.marca 
                    + '</td><td><button class="btn btn-warning btn-sm edit-button" data-id="' + producto.id + 
                    '" data-toggle="modal" data-target="#editProductModal">Editar</button> <button class="btn btn-danger btn-sm delete-button" data-id="' + producto.id + 
                    '" data-toggle="modal" data-target="#deleteProductModal">Eliminar</button></td></tr>');
                });
            },
            error: function(response) {
                console.log(response);
                alert('Error al filtrar los productos');
            }
        });
    });
});
</script>
</body>
</html>
