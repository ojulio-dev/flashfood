$(document).ready(function() {

    // Create
    $('#button-create-category').click(function(event) {
        let form = new FormData($('#form-category-create')[0]);

        const result = fetch(API_URL + 'api/?api=category&action=createCategory',{
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
                        window.location.replace(BASE_URL + '?page=category'); 
                    }
                })

                $('#form-category-create')[0].reset()
            } else {
                Swal.fire({
                    title: 'Atenção!',
                    text: result.message,
                    icon: 'error'
                
                })
            }
        })
    });

    // readProducts
    $('#button-read-products-category').click(function(event) {

        var idCategory = $(this).data('product-id');

        $.ajax({
            url: API_URL + 'api/?api=category&action=listProductByCategory',
            type: 'GET',
            data: { idCategory },
            dataType: 'json',
            success: function (data, status, xhr) {
                if (!data) {
                    Swal.fire({
                        title: 'Oops',
                        text: 'Esta categoria não possui produtos',
                        icon: 'info'
                    })
                }
                $('#read-items-category').html('');
                data.map(product=>{
                    $('#read-items-category').append(`
                    <tr>
                        <td class="read-image-wrapper"><img src="${API_URL}/assets/images/products/${ product.banner }" alt=""></td>
                        <td>${ product.name }</td>
                        <td>${ new Intl.NumberFormat('pt-BR', {
                            style: 'currency',
                            currency: 'BRL',
                            minimumFractionDigits: 2 }).format( product.special_price )}</td>

                        <td class="read-table-status">
                            <form>
                                <input name="status" onclick="changeStatus(${ product.product_id }, 'product')" type="checkbox" ${ product.status == 1 ? 'checked' : '' }/>
                                <label></label>
                            </form>
                        </td>

                        <td>
                            <div class="read-icons-wrapper">
                                <a class="read-icons-action noHover" href="?page=products&action=update&slug=${ product.slug }">
                                    <img class="icon-no-hover" src="${BASE_URL}/assets/images/system/editar.png">
                                </a>
                            </div>
                        </td>
                    </tr>
                    `)
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

    });

    // Update
    $('#button-update-category').click(function(event) {

        var dataCategory = {

            name: $('#update-name-category').val(),

            status: $('#update-status-category').val(),

            categoryId: $(this).data('category-id')

        }

        $.ajax({
            url: API_URL + 'api/?api=category&action=updateCategory',
            type: 'POST',
            data: dataCategory,
            dataType: 'json',
            success: function (data, status, xhr) {

                Swal.fire({
                    title: data.response ? 'Succeso!' : 'Oops...',
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
    $('#button-delete-category').click(function(event) {

        var categoryId = $(this).data('category-id')

        Swal.fire({
            title: 'Cuidado',
            text: "Tem certeza que deseja excluir esta categoria? Todos os Produtos da Categoria selecionada será deletados!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, certeza',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            
            if (result.isConfirmed) {
                $.ajax({
                    url: API_URL + 'api/?api=category&action=deleteCategory',
                    type: 'POST',
                    data: { categoryId },
                    dataType: 'json',
                    success: function (data, status, xhr) {
                        if (data) {
                                Swal.fire({
                                title: 'Foi!',
                                text: 'Categoria deletada com sucesso!',
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'Ok'
                            }).then((result) => {
                                
                                window.location.replace(BASE_URL + '?page=category'); 
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
        });

    });

    $('#category-search').keyup(function(event) {
        // Pega o valor do Search
        var search = event.target.value.toLowerCase();
        
        // Pegamos todas as tr da tabela
        var rows = $('#read-table-category-items tr');


        rows.each(function(index, tr) {
            // find procura elementos HTML dentro de elementos
            // Aqui pegamos o nome da categoria no Loop
            var category = $(tr).find('td:nth-child(2)')[0].innerHTML.toLowerCase();

            // Fazemos a verificação se dentro da variavel category existe o valor da variavel search
            // Se não tiver incluido o valor, ele esconde o elemento, se não ele mostra
            !category.includes(search) ? $(tr).hide() : $(tr).show();

        });
    });

});