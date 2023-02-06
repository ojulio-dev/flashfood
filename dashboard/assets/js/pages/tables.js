
// Create
$('#button-create-tables').click(function() {
    let formData = new FormData($('#form-tables-create')[0]);

    const result = fetch(SERVER_HOST + '/api/?api=tables&action=create', {
        method: 'POST',
        body: formData
    })
    .then((data) => data.json())
    .then((data) => {
        if (data.response) {

            Swal.fire({
                title: 'Foi!',
                text: data.message,
                icon: 'success',
                showCancelButton: true,
                confirmButtonColor: '#17a2b8',
                cancelButtonColor: '#17a2b8',
                confirmButtonText: 'Ir para Home',
                cancelButtonText: 'Ficar'
            }).then((result) => {

                if (result.isConfirmed) {

                    window.location.replace(DIR_PATH + '/?page=tables'); 
                }
            })

            $('#form-tables-create')[0].reset();

        } else {

            Swal.fire({
                title: 'Oops...',
                text: data.message,
                icon: 'warning'
            
            })
        }

    })
    .catch(error => {
        
        Swal.fire({
            title: 'Oops...',
            text: 'Um problema inesperado aconteceu. Avise os administradores o mais rápido possível!',
            icon: 'error'
        })
    });
})

// Update
$('#button-update-tables').click(function(){

    let formData = new FormData($('#form-tables-update')[0]);

    formData.append('tableId', $(this).data('table-id'));

    $.ajax({
        url: SERVER_HOST + '/api/?api=tables&action=update',
        type: 'POST',
        data: formData,
        dataType: 'JSON',
        processData: false,
        contentType: false,
        success: function(data) {

            Swal.fire({
                title: data.response ? 'Sucesso!' : 'Oops...',
                icon: data.response ? 'success' : 'error',
                text: data.message
            })

        },
        error: function() {
            Swal.fire({
                title: 'Erro!',
                text: 'Um problema inesperado aconteceu. Avise os administradores o mais rápido possível!',
                icon: 'error'
            })
        }

    })

});

// Delete
$('.remove-action.-tables').click(function() {
    let tableId = $(this).data('table-id');

    Swal.fire({
        title: 'Cuidado',
        text: "Tem certeza que deseja excluir esta Mesa?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim, certeza',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        
        if (result.isConfirmed) {
            $.ajax({
                url: SERVER_HOST + '/api/?api=tables&action=delete',
                type: 'POST',
                data: {
                    tableId
                },
                dataType: 'JSON',
                success: function (data) {
                    if (data) {
                            Swal.fire({
                            title: 'Foi!',
                            text: 'Mesa deletada com sucesso!',
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok'
                        }).then((result) => {
                            
                            window.location.replace(DIR_PATH + '/?page=tables'); 
                        })
                    } else {
                        
                        Swal.fire({
                            title: 'Erro!',
                            text: 'Um problema inesperado aconteceu. Avise os administradores o mais rápido possível!',
                            icon: 'error'
                        })
                    }
                },
                error: function () {
                    Swal.fire({
                        title: 'Erro!',
                        text: 'Um problema inesperado aconteceu. Avise os administradores o mais rápido possível!',
                        icon: 'error'
                    })
                }
            });
        }
    })
})