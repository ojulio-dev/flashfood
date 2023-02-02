$(document).ready(function() {

    $('.date').inputmask({"mask": "99/99/9999", "placeholder": "_"});

})

$("#form-create-mobile").submit(function(event) {
    event.preventDefault();
    
    let formData = new FormData($(this)[0]);

    var values = $(this).serializeArray();

    var isValid = Inputmask.isValid(values[2].value, { alias: "datetime", inputFormat: "dd/mm/yyyy"});

    if (!isValid) {
       
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Data Inválida'
        })

        return;
    }
    
    let birthdate = Inputmask.unmask(values[2].value, { alias: "datetime", inputFormat: "dd/mm/yyyy", outputFormat: "yyyy-mm-dd"});

    formData.append('birthdate', birthdate);

    formData.append('role_id', 2);

    $.ajax({
        url : `${BASE_URL}/api/?api=user&action=createUser`,
        type: 'POST',
        data: formData,
        dataType: 'json',
        processData: false,
        contentType: false,
        success: function(data) {

            if (data.response) {

                Swal.fire({
                    icon: 'success',
                    title: 'Tudo certo!',
                    text: 'Sua conta foi cadastrada com Sucesso! Obrigado por utilizar o nosso sistema <3',
                    confirmButtonText: 'Continuar'
                })
                .then(result => {
                    window.location = '?page=scanTable&action=login'
                })

            } else {

                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: data.message
                })

            }

        },
        error: function() {

            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Um problema inesperado aconteceu. Avise os administradores o mais rápido possível!'
            })

        }
    })
});

$('#form-login-mobile').submit(function(event) {
    event.preventDefault();

    let formData = new FormData($(this)[0]);

    $.ajax({
        url : `${BASE_URL}/api/?api=user&action=loginUser`,
        type: 'POST',
        data: formData,
        dataType: 'json',
        processData: false,
        contentType: false,
        success: function(data) {

            if (data.response) {

                Swal.fire({
                    icon: 'success',
                    title: 'Tudo certo!',
                    text: 'Encontramos a sua conta! Obrigado por utilizar o FlashFood <3',
                    showCancelButton: true,
                    confirmButtonText: 'Ir para o Cardápio',
                    cancelButtonText: 'Página Inicial'
                })
                .then(result => {

                    if (result.isConfirmed) {

                        window.location.replace(BASE_URL + '?page=mobile'); 
                    } else {

                        window.location.replace(BASE_URL + '?page=home'); 
                    }

                })

            } else {

                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: data.message
                })

            }

        },
        error: function() {

            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Um problema inesperado aconteceu. Avise os administradores o mais rápido possível!'
            })

        }
    })
})