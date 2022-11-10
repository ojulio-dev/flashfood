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

            if (!data.response) {

                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: data.message
                });
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

$('#button-create-user').click(() => {
    let formData = new FormData($('#form-create-user')[0]);

    $.ajax({
        url: BASE_URL + 'api/?api=user&action=createUser',
        type: 'POST',
        processData: false,
        contentType: false,
        dataType: 'JSON',
        data: formData,
        success: (data, status, xhr) => {
            if (!data.response) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: data.message
                });

                exit();
            }

            Swal.fire({
                icon: 'success',
                title: 'Sucesso!',
                text: data.message,
                showCancelButton: true,
                confirmButtonColor: '#17a2b8',
                cancelButtonColor: '#17a2b8',
                confirmButtonText: 'Ir para o Login',
                cancelButtonText: 'Ficar',
            })
            .then((result) => {
                if (result.isConfirmed) {
                    window.location.replace(BASE_URL + '?page=login'); 
                }
            })

            $('#form-create-user')[0].reset();
        },
        error: (jqXhr, textStatus, errorMessage) => {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Um problema inesperado aconteceu. Avise os administradores o mais rápido possível!'
            });
        }
    });
})