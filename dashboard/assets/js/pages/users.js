$(document).ready(function() {

    // Create
    $('#button-create-users').click(function() {
        let formData = new FormData($('#form-users-create')[0]);

        $.ajax({
            url: SERVER_HOST + '/api/?api=user&action=createUser',
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

                data.response && $('#form-users-create')[0].reset();

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

    // Update
    $('#button-update-users').click(function(){

        let formData = new FormData($('#form-users-update')[0]);

        formData.append('userId', $(this).data('user-id'));

        $.ajax({
            url: SERVER_HOST + '/api/?api=user&action=updateUser',
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
    $('#button-delete-users').click(function() {
        let userId = $(this).data('user-id');

        Swal.fire({
            title: 'Cuidado',
            text: "Tem certeza que deseja excluir este Usuário?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, certeza',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            
            if (result.isConfirmed) {
                $.ajax({
                    url: SERVER_HOST + '/api/?api=user&action=deleteUser',
                    type: 'POST',
                    data: {
                        userId
                    },
                    dataType: 'JSON',
                    success: function (data) {
                        if (data) {
                                Swal.fire({
                                title: 'Foi!',
                                text: 'Usuário deletado com sucesso!',
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'Ok'
                            }).then((result) => {
                                
                                window.location.replace(DIR_PATH + '/?page=users'); 
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

    // Search
    $('#user-search').keyup(function(event) {
        // Pega o valor do Search
        var search = event.target.value.toLowerCase();
        
        // Pegamos todas as tr da tabela
        var rows = $('#read-table-users-items tr');


        rows.each(function(index, tr) {
            // find procura elementos HTML dentro de elementos
            // Aqui pegamos o nome da categoria no Loop
            var user = $(tr).find('td:nth-child(2)')[0].innerHTML.toLowerCase();

            !user.includes(search) ? $(tr).hide() : $(tr).show();

        });
    });

});