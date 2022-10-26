$(document).ready(function() {

    // Create
    $('#button-create-products').click(function(event) {
        let form = new FormData($('#form-products-create')[0]);

        const result = fetch(API_URL + 'api/?api=products&action=createProduct',{
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
                        window.location.replace(BASE_URL + '?page=products'); 
                    }
                })

                $('#form-products-create')[0].reset()
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
            url: API_URL + 'api/?api=products&action=updateProduct',
            type: 'POST',
            data: form,
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function (data, status, xhr) {

                Swal.fire({
                    title: 'Foi!',
                    text: 'Produto Atualizado com sucesso!',
                    icon: 'success'
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
                    url: API_URL + 'api/?api=products&action=deleteProduct',
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
                                
                                window.location.replace(BASE_URL + '?page=products'); 
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
            url: API_URL + `api/?api=products&action=${action}`,
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
                            <td class="read-image-wrapper"><img src="assets/images/products/${product.banner}" alt=""></td>
                            <td>${product.category}</td>
                            <td>${product.name}</td>
                            <td>R$ ${Number(product.special_price).toFixed(2).replace('.', ',')}</td>
                            <td class="product-table-status">
                                <form>
                                    <input name="status" type="checkbox" onclick="changeStatus(${product.product_id}, 'product')"  ${product.status == 1 ? 'checked' : ''}>
                                    <label for="status"></label>
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

    
});