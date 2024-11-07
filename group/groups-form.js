$(document).ready(function() {
    function loadProductsForGroup() {
        $.ajax({
            url: 'product/product_actions.php',
            method: 'POST',
            data: { action: 'read' },
            success: function(response) {
                var products = JSON.parse(response);
                var html = '';
                for (var i = 0; i < products.length; i++) {
                    html += '<option value="' + products[i].id + '">' + products[i].name + '</option>';
                }
                $('#product-select').html(html);
            }
        });
    }

    $('#create-group').on('submit', function(e) {
        e.preventDefault();
        var groupName = $('#group-name').val();
        var selectedProducts = $('#product-select').val();

        $.ajax({
            url: 'group/group_actions.php',
            method: 'POST',
            data: {
                action: 'createGroup',
                name: groupName,
                products: selectedProducts
            },
            success: function() {
                loadGroups();
                clearGroupForm();
            }
        });
    });

    function clearGroupForm() {
        $('#group-id').val('');
        $('#group-name').val('');
        $('#product-select').val([]);
    }

    function loadGroups() {
        $.ajax({
            url: 'group/group_actions.php',
            method: 'POST',
            data: { action: 'getAllGroups' },
            success: function(response) {
                var groups = JSON.parse(response);
                var html = '';
                for (var i = 0; i < groups.length; i++) {
                    html += '<tr>';
                    html += '<td>' + groups[i].id + '</td>';
                    html += '<td>' + groups[i].name + '</td>';
                    html += '<td><button onclick="editGroup(' + groups[i].id + ')">Editar</button></td>';
                    html += '<td><button onclick="deleteGroup(' + groups[i].id + ')">Eliminar</button></td>';
                    html += '</tr>';
                }
                $('#group-list').html(html);
            }
        });
    }

    window.deleteGroup = function(id) {
        $.ajax({
            url: 'group/group_actions.php',
            method: 'POST',
            data: { action: 'deleteGroup', id: id },
            success: function() {
                loadGroups();
            }
        });
    };

    window.editGroup = function(id) {
        $.ajax({
            url: 'group/group_actions.php',
            method: 'POST',
            data: { action: 'getGroup', id: id },
            success: function(response) {
                var group = JSON.parse(response);
                $('#group-id').val(group.id);
                $('#group-name').val(group.name);
                $('#product-select').val(group.products);
            }
        });
    };

    loadProductsForGroup();
    loadGroups();
});

