const addProduct = () => {
    
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

};

const updateProduct = (productId) => {

    let form = new FormData($('#form-products-update')[0]);

    const result = fetch(API_URL + 'api/?api=products&action=updateProduct',{
        method: 'POST',
        body: JSON.stringify({
            ...Object.fromEntries(form.entries()), productId 
        }),
        headers: { 'Content-Type' : 'application/json' }
    })
    .then((response)=>response.json())
    .then((result)=> {
        alert(`oi`);
    })

};

const deleteProduct = (productId) => {

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

};