$('#button-login-admin').click(() => {
    let formData = new FormData($('#form-login-admin')[0]);

    $.ajax({

        url: BASE_URL + 'api/?api=admin&action=loginUser',
        type: 'POST',
        processData: false,
        contentType: false,
        dataType: 'json',
        data: formData,
        success: (data, status, xhr) => {

            if (!data.return) {

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