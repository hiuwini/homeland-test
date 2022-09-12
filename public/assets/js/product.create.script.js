$(document).ready(function(){

    var products_table = $('#products_table').DataTable({
        serverSide: true,
        ordering: false,
        searching: false,
        processing: true,
        footer: false,
        ajax: "products/",
        columns:[
            {data: 'code', name: 'Codigo' },
            {data: 'name', name: 'Nombre' },
            {data: 'quantity', name: 'Cantidad' },
            {data: 'price', name: 'Precio' },
            {data: 'entry_date', name: 'Ingreso' },
            {data: 'due_date', name: 'Vencimiento' },
            {data: 'picture', name: 'Fotografia' },
            {data: 'action', name: 'Acción' },
        ],
        order: [[4, 'desc']],
    });

    jQuery.validator.addMethod("lessThan",
        function(value, element, params) {

            if (!/Invalid|NaN/.test(new Date(value))) {
                return new Date(value) < new Date($(params).val());
            }

            return isNaN(value) && isNaN($(params).val())
                || (Number(value) < Number($(params).val()));
        },'La fecha debe ser menor a la fecha de vencimiento.');

    jQuery.validator.addMethod("checkCode",
        function(value, element) {
            var result = false
            $.ajax({
                type:"POST",
                async: false,
                url: "/products/findbycode",
                data: {code: value},
                success: function(data) {
                    result = (data == "exists") ? false : true;
                }
            });
            return result;
        },'Este código de producto ya existe.');

    $('#form-product').validate({
      rules:{
          product_cod:{
              required: true,
              minlength: 3,
              alphanumeric: true,
              checkCode: true
          },
          product_name:{
              required: true,
              minlength: 3,
              alphanumeric: true
          },
          product_entrydate:{
              lessThan: "#product_duedate"
          },
          product_duedate:{
              greaterThan: "#product_entrydate"
          },
          product_picture:{
              required: true,
              extension: "jpg|jpeg|png|gif"
          }

      }
    })

    $('#form-product').submit(function (e){
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            data: new FormData(this),
            url: "/products/store",
            type: "POST",
            processData: false,
            contentType: false,
            success: function (data) {
                $('#form-product').trigger("reset");
                $('#productModal').modal('hide');
                products_table.draw();
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
        return false;
    });

    $('body').on('click', '#createProduct', function () {
        $('#form-product').trigger("reset");
        $('#modal_title').html("Nuevo Producto");
        $('#actionProduct').html("Crear");
        $('#typeAction').val('create');

    });
    $('body').on('click', '.editProduct', function () {
        var product_id = $(this).data('id');
        $.get("products" +'/' + product_id +'/edit', function (data) {
            $('#modal_title').html("Actualizar Producto");
            $('#actionProduct').html("Actualizar");
            $('#typeAction').val('update');
            $('#productModal').modal('show');
            $('#product_id').val(data.id);
            $('#product_cod').val(data.code);
            $('#product_name').val(data.name);
            $('#product_price').val(data.price);
            $('#product_quantity').val(data.quantity);
            $('#product_entrydate').val(data.entry_date);
            $('#product_duedate').val(data.due_date);
            //picture pending
        })
    });
    $('body').on('click', '.deleteProduct', function () {
        var product_id = $(this).data("id");
        $('#product_remove').modal('show');
        $( "#delete_product_button" ).click(function() {
            $.ajax({
                type: "DELETE",
                url: "products"+'/'+product_id,
                success: function (data) {
                    products_table.draw();
                    $('#product_remove').modal('hide');
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        });
    });
});
