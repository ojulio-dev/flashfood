$(document).ready(function() {

    // Create
    $('#button-create-users').click(function() {
        let formData = new FormData($('#form-users-create')[0]);

        $.ajax({
            url: API_URL + 'api/?api=user&action=createUser',
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
            url: API_URL + 'api/?api=user&action=updateUser',
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