$(document).ready(function() {
    // Create
    $('#button-create-ingredient').click(function() {
        
        let formData = new FormData($('#form-ingredient-create')[0]);

        $.ajax({
            url: SERVER_HOST + '/api/?api=ingredient&action=createIngredient',
            type: 'POST',
            data: formData,
            dataType: 'JSON',
            processData: false,
            contentType: false,
            success: function(data, status, xhr) {

                if (data.response) {

                    Swal.fire({
                        title: 'Sucesso!',
                        icon: 'success',
                        text: data.message,
                        showCancelButton: true,
                        confirmButtonColor: '#17a2b8',
                        cancelButtonColor: '#17a2b8',
                        confirmButtonText: 'Ir para Home',
                        cancelButtonText: 'Ficar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.replace(DIR_PATH + '/?page=ingredient'); 
                        }
                    })

                    $('#form-ingredient-create')[0].reset()
                } else {

                    Swal.fire({
                        title: 'Oops...',
                        icon: 'error',
                        text: data.message
                    });
                }
            },
            error: function(jqXhr, textStatus, errorMessage) {
                Swal.fire({
                    title: 'Erro!',
                    text: 'Um problema inesperado aconteceu. Avise os administradores o mais rápido possível!',
                    icon: 'error'
                })
            }
        })
    });

    // Update
    $('#button-update-ingredient').click(function() {

        let formData = new FormData($('#form-update-ingredient')[0]);

        formData.append('ingredientId', $(this).data('ingredient-id'));

        $.ajax({
            url: SERVER_HOST + '/api/?api=ingredient&action=updateIngredient',
            type: 'POST',
            data: formData,
            dataType: 'JSON',
            contentType: false,
            processData: false,
            success: function(data) {
                
                if (data.response) {

                    Swal.fire({
                        title: 'Sucesso!',
                        icon: 'success',
                        text: data.message
                    });
                } else {

                    Swal.fire({
                        title: 'Oops...',
                        icon: 'error',
                        text: data.message
                    });
                }

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
    $('#button-delete-ingredient').click(function() {

        Swal.fire({
            title: 'Cuidado',
            text: "Tem certeza que deseja excluir este Ingrediente?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, certeza',
            cancelButtonText: 'Cancelar'
        }).then((result) => {

            let id = $(this).data('ingredient-id');
            
            if (result.isConfirmed) {
                $.ajax({
                    url: SERVER_HOST + '/api/?api=ingredient&action=deleteIngredient',
                    type: 'POST',
                    data: { id },
                    dataType: 'json',
                    success: function (data, status, xhr) {

                        if (data) {
                                Swal.fire({
                                title: 'Sucesso!',
                                text: data.message,
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'Ok'
                            }).then((result) => {
                                
                                window.location.replace(DIR_PATH + '/?page=ingredient'); 
                            })
                        } else {
                            
                            Swal.fire({
                                title: 'Erro!',
                                text: data.message,
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

    $('#ingredient-search').keyup(function(event) {
        // Pega o valor do Search
        var search = event.target.value.toLowerCase();
        
        // Pegamos todas as tr da tabela
        var rows = $('#read-table-ingredients-items tr');


        rows.each(function(index, tr) {
            // find procura elementos HTML dentro de elementos
            // Aqui pegamos o nome da categoria no Loop
            var ingredient = $(tr).find('td:nth-child(2)')[0].innerHTML.toLowerCase();

            !ingredient.includes(search) ? $(tr).hide() : $(tr).show();

        });
    });
})