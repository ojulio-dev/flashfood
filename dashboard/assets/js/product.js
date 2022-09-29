const addProduct = () => {
    
    let form = new FormData($('#main-products-form')[0]);

    const result = fetch(BASE_URL + 'api/?api=products&action=createProduct',{
        method: 'POST',
        body: form
    })
    .then((response)=>response.json())
    .then((result)=> {
            Swal.fire({
            title: result.response == true ? 'Foi!' : 'Atenção!',
            text: result.message,
            icon: result.response == true ? 'success' : 'error'
          })
        result.retorno == 'ok' ? $('#form-usuarios')[0].reset() : ''
    })

};