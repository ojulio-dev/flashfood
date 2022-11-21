$('#button-login-user').click(() => {
    let formData = new FormData($('#form-login-user')[0]);

    $.ajax({

        url: BASE_URL + 'api/?api=user&action=loginUser',
        type: 'POST',
        processData: false,
        contentType: false,
        dataType: 'json',
        data: formData,
        success: (data, status, xhr) => {

            if (data.response) {
                Swal.fire({
                    title: 'Sucesso!',
                    text: data.message,
                    icon: 'success',
                    showCancelButton: true,
                    confirmButtonColor: '#17a2b8',
                    cancelButtonColor: '#17a2b8',
                    confirmButtonText: 'Gerenciar',
                    cancelButtonText: 'Ir para a Home'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.replace(BASE_URL + '?page=portal'); 
                    } else {
                        window.location.replace(BASE_URL + '?page=home'); 
                    }
                })

            } else {
                Swal.fire({
                    title: 'Oops...',
                    text: data.message,
                    icon: 'error'
                })
            }
        },
        error: (jqXhr, textStatus, errorMessage) => {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Um problema inesperado aconteceu. Avise os administradores o mais rápido possível!'
            })
        }

    });
});