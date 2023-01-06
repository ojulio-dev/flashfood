$(document).ready(function() {

    // Create
    $('#button-create-products').click(function(event) {
        let form = new FormData($('#form-products-create')[0]);

        const result = fetch(SERVER_HOST + '/api/?api=products&action=createProduct',{
            method: 'POST',
            body: form
        })
        .then((response)=>response.json())
        .then((result)=> {
            if (result.response) {
                
                Swal.fire({
                    title: 'Foi!',
                    text: result.message,
                    icon: 'success',
                    showCancelButton: true,
                    confirmButtonColor: '#17a2b8',
                    cancelButtonColor: '#17a2b8',
                    confirmButtonText: 'Ir para Home',
                    cancelButtonText: 'Ficar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.replace(DIR_PATH + '/?page=products'); 
                    }
                })

                $('#form-products-create')[0].reset();
                $('#ingredients-create-products').val(null).trigger('change');
            } else {
                Swal.fire({
                    title: 'Atenção!',
                    text: result.message,
                    icon: 'error'
                
                })
            }
        })
    })

    // Update
    $('#button-update-products').click(function(event) {

        let form = new FormData($('#form-products-update')[0]);

        form.append('productId', $(this).data('product-id'));

        $.ajax({
            url: SERVER_HOST + '/api/?api=products&action=updateProduct',
            type: 'POST',
            data: form,
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function (data, status, xhr) {

                Swal.fire({
                    title: data.response ? 'Foi!' : 'Oops...',
                    text: data.message,
                    icon: data.response ? 'success' : 'error'
                })

            },
            error: function (jqXhr, textStatus, errorMessage) {
                Swal.fire({
                    title: 'Erro!',
                    text: 'Um problema inesperado aconteceu. Avise os administradores o mais rápido possível!',
                    icon: 'error'
                })
            }
        });
    })

    // Delete
    $('#button-delete-products').click(function(event) {
        var productId = $(this).data('product-id');

        Swal.fire({
            title: 'Cuidado',
            text: "Tem certeza que deseja excluir este produto?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, certeza',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            
            if (result.isConfirmed) {
                $.ajax({
                    url: SERVER_HOST + '/api/?api=products&action=deleteProduct',
                    type: 'POST',
                    data: { productId },
                    dataType: 'json',
                    success: function (data, status, xhr) {
                        if (data) {
                                Swal.fire({
                                title: 'Foi!',
                                text: 'Produto deletado com sucesso!',
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'Ok'
                            }).then((result) => {
                                
                                window.location.replace(DIR_PATH + '/?page=products'); 
                            })
                        } else {
                            
                            Swal.fire({
                                title: 'Erro!',
                                text: 'Um problema inesperado aconteceu. Avise os administradores o mais rápido possível!',
                                icon: 'error'
                            })
                        }
                    },
                    error: function (jqXhr, textStatus, errorMessage) {
                        Swal.fire({
                            title: 'Erro!',
                            text: 'Um problema inesperado aconteceu. Avise os administradores o mais rápido possível!',
                            icon: 'error'
                        })
                    }
                });
            }
        })
    });

    //Change ListProducts
    $('#options-list-products').change(function(event) {
        var categoryId = event.target.value;

        var action = categoryId == 'all' ? 'listProducts' : 'listProductsByCategory';


        $.ajax({
            url: SERVER_HOST + `/api/?api=products&action=${action}`,
            type: 'POST',
            data: {
                categoryId
            },
            dataType: 'json',
            success: function (data, status, xhr) {

                if (!data) {
                    $('#read-table-products-items').html(`
                        <tr>
                            <td>Essa categoria não possui produtos, cadastre clicando <a class="link-no-results" href="?page=products&action=create">aqui</a></td>
                        </tr>
                    `);

                    return false;
                }

                var list = data.map(function(product) {
                      return `
                        <tr>
                            <td class="read-image-wrapper"><img src="${SERVER_HOST}/assets/images/products/${product.banner}" alt=""></td>
                            <td>${product.category}</td>
                            <td>${product.name}</td>
                            <td>R$ ${Number(product.special_price).toFixed(2).replace('.', ',')}</td>
                            <td class="read-table-status">
                                <form>
                                    <input name="status" id="status-read-products" type="checkbox" onclick="changeStatus(${product.product_id}, 'product')"  ${product.status == 1 ? 'checked' : ''}>
                                    <label for="status-read-products"></label>
                                </form>
                            </td>
                            <td>
                                <div class="read-icons-wrapper">
                                    <a class="read-icons-action" href="?page=products&action=update&slug=${product.slug}">
                                        <img src="assets/images/system/editar.png">
                                    </a>
                                </div>
                            </td>
                        </tr>
                    `;
                });

                $('#read-table-products-items').html(list);

            },
            error: function (jqXhr, textStatus, errorMessage) {
                Swal.fire({
                    title: 'Erro!',
                    text: 'Um problema inesperado aconteceu. Avise os administradores o mais rápido possível!',
                    icon: 'error'
                })
            }
        });
    });

    function matchCustom(params, data) {
        // If there are no search terms, return all of the data
        if ($.trim(params.term) === '') {
          return data;
        }
    
        // Do not display the item if there is no 'text' property
        if (typeof data.text === 'undefined') {
          return null;
        }
    
        // `params.term` should be the term that is used for searching
        // `data.text` is the text that is displayed for the data object
        if (data.text.indexOf(params.term) > -1) {
          var modifiedData = $.extend({}, data, true);
          modifiedData.text += ' (matched)';
    
          // You can return modified objects from here
          // This includes matching the `children` how you want in nested data sets
          return modifiedData;
        }

        // Return `null` if the term should not be displayed
        return null;
    }

    $('.js-example-basic-multiple').select2({
        matcher: matchCustom,
        theme: "classic"
    });
});