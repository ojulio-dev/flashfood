const addCategory = () => {
    
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

};

const listProductByCategory = async (idCategory) => {

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
                    <td class="read-image-wrapper"><img src="assets/images/products/${ product.banner }" alt=""></td>
                    <td>${ product.name }</td>
                    <td>${ new Intl.NumberFormat('pt-BR', {
                        style: 'currency',
                        currency: 'BRL',
                        minimumFractionDigits: 2 }).format( product.special_price )}</td>

                    <td class="product-table-status">
                        <form>
                            <input id="status" name="status" onclick="changeStatus(${ product.product_id }, 'product')" type="checkbox" ${ product.status == 1 ? 'checked' : '' }/>
                            <label for="status"></label>
                        </form>
                    </td>

                    <td>
                        <div class="read-icons-wrapper">
                            <a class="read-icons-action" href="?page=products&action=update&id=${ product.product_id }">
                                <img src="${BASE_URL}/assets/images/system/editar.png">
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
};

const deleteCategory = (categoryId) => {

    Swal.fire({
        title: 'Cuidado',
        text: "Tem certeza que deseja excluir esta categoria?",
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
    })

};