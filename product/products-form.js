$(document).ready(function() {
    function loadProducts() {
        $.ajax({
            url: 'product/product_actions.php',
            method: 'POST',
            data: { action: 'read' },
            success: function(response) {
                var products = JSON.parse(response);
                var html = '';
                for (var i = 0; i < products.length; i++) {
                    html += '<tr>';
                    html += '<td>' + products[i].id + '</td>';
                    html += '<td>' + products[i].name + '</td>';
                    html += '<td>' + products[i].price + '</td>';
                    html += '<td>' + products[i].description + '</td>';
                    html += '<td><button onclick="editProduct(' + products[i].id + ')">Editar</button></td>';
                    html += '<td><button onclick="deleteProduct(' + products[i].id + ')">Eliminar</button></td>';
                    html += '</tr>';
                }
                $('#product-list').html(html);
            }
        });
    }

    $('#create-product').on('submit', function(e) {
        e.preventDefault();
        var action = $('#id').val() ? 'update' : 'create';
        var productData = {
            action: action,
            id: $('#id').val(),
            name: $('#name').val(),
            description: $('#description').val(),
            price: $('#price').val(),
            stock: $('#stock').val()
        };

        $.ajax({
            url: 'product/product_actions.php',
            method: 'POST',
            data: productData,
            success: function() {
                loadProducts();
                clearForm();
            }
        });
    });

    window.deleteProduct = function(id) {
        $.ajax({
            url: 'product/product_actions.php',
            method: 'POST',
            data: { action: 'delete', id: id },
            success: function() {
                loadProducts();
            }
        });
    };

    window.editProduct = function(id) {
        $.ajax({
            url: 'product/product_actions.php',
            method: 'POST',
            data: { action: 'getProduct', id: id },
            success: function(response) {
                var product = JSON.parse(response);
                $('#id').val(product.id);
                $('#name').val(product.name);
                $('#description').val(product.description);
                $('#price').val(product.price);
                $('#stock').val(product.stock);
                $('#create-product button').text('Actualizar Producto');
            }
        });
    };

    function clearForm() {
        $('#id').val('');
        $('#name').val('');
        $('#description').val('');
        $('#price').val('');
        $('#stock').val('');
        $('#create-product button').text('Crear Producto');
    }

    loadProducts();
});
