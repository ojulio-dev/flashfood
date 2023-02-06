$('#icon-menu-burguer').click(function() {
    $('#modal-menu-hamburguer .main-modal').css('display', 'flex');
})

$('#modal-menu-hamburguer .main-modal .main-modal-close').click(function() {
    $('#modal-menu-hamburguer .main-modal').hide();

    $('#modal-menu-hamburguer .main-modal-item.-navigation').show();
    $('#modal-menu-hamburguer .main-modal-item.-profile').hide();
})

$('#modal-menu-hamburguer .main-modal-item.-navigation ul .profile-anchor').click(function() {
    $('#modal-menu-hamburguer .main-modal-item.-navigation').hide();
    $('#modal-menu-hamburguer .main-modal-item.-profile').css('display', 'flex');
})

$('body').on('click', '#modal-menu-hamburguer .main-modal-item.-profile form .return-image-wrapper i', function() {
    $('#modal-menu-hamburguer .main-modal-item.-navigation').show();
    $('#modal-menu-hamburguer .main-modal-item.-profile').hide();
})

$('body').on('change', '#modal-menu-hamburguer .main-modal-item.-profile form input', function() {
    $('#modal-menu-hamburguer .main-modal-item.-profile form .buttons-wrapper').css('display', 'flex');

    $(this).blur();

    $(this).addClass('disabled');
})

$('body').on('change', '#modal-menu-hamburguer .main-modal-item.-profile form .input-image-wrapper input', () => readUserIcon());

$('body').on('click', '#modal-menu-hamburguer .main-modal-item.-profile form .input-wrapper label', function() {
    $('#modal-menu-hamburguer .main-modal-item.-profile form .input-wrapper input').addClass('disabled');

    let inputId = $(this).attr('for');

    let input = $(`#modal-menu-hamburguer .main-modal-item.-profile form .input-wrapper #${inputId}`)

    input.removeClass('disabled');
    input.prop('autofocus', true);
})

$('body').on('click', '#modal-menu-hamburguer .main-modal-item.-profile .button-wrapper button', function() {
    $.ajax({
        url : `${BASE_URL}/api/?api=user&action=logoutUser`,
        dataType: 'json',
        success: function(data) {
            window.location = BASE_URL;
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

$('body').on('click', '#modal-menu-hamburguer .main-modal-item.-profile form .buttons-wrapper .button-action.-cancel', function() {
    readUser();
})

$('body').on('click', '#modal-menu-hamburguer .main-modal-item.-profile form .buttons-wrapper .button-action.-save', function() {
    let form = new FormData($('#form-profile-user')[0]);

    const result = fetch(`${BASE_URL}/api/?api=user&action=updateHomePage`, {
        method: 'POST',
        body: form
    })
    .then((response) => response.json())
    .then(result => {

        if (result.response) {

            $('#modal-menu-hamburguer .main-modal-item.-profile form .buttons-wrapper').hide();
        } else {
            
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: result.message
            })

            readUser();
        }
    })
    .catch(error => {

        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Um problema inesperado aconteceu. Avise os administradores o mais rápido possível!'
        })

    })
})

const readUser = () => {
    $.ajax({
        url : `${BASE_URL}/api/?api=user&action=readUserById`,
        dataType: 'json',
        success: function(data) {

            $('#modal-menu-hamburguer .main-modal-item.-profile form .input-image-wrapper img').hide();

            $('#modal-menu-hamburguer #form-profile-user').html('');
            
            $('#modal-menu-hamburguer #form-profile-user').html(`
                <form id="form-profile-user">
                    <div class="return-image-wrapper">
                        <i class="fa-solid fa-arrow-left"></i>

                        <div class="input-image-wrapper">
                            <label for="user-image"><img src="${data.image}" alt="User Icon"></label>
                            <input type="file" accept="image/png, image/gif, image/jpeg, image/jpg, image/webp" name="image" id="user-image">
                        </div>
                    </div>

                    <div class="inputs-wrapper">
                        <div class="input-wrapper">
                            <label for="user-name"><i class="fa-solid fa-pen-to-square"></i></label>
                            <input class="disabled" type="text" name="name" id="user-name" value="${data.name}">
                        </div>

                        <div class="input-wrapper">
                            <label for="user-email"><i class="fa-solid fa-pen-to-square"></i></label>
                            <input class="disabled" type="email" name="email" id="user-email" value="${data.email}">
                        </div>
                    </div>

                    <div class="buttons-wrapper">
                        <button class="button-action -cancel" type="button">Cancelar</button>
                        <button class="button-action -save" type="button">Salvar</button>
                    </div>
                </form>
            `);

        },
        error: function() {

            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Um problema inesperado aconteceu. Avise os administradores o mais rápido possível!'
            })

        }
    })
}

const readUserIcon = () => {

    let userIcon = document.querySelector('#modal-menu-hamburguer .main-modal-item.-profile form .input-image-wrapper img');

    let inputFile = $('#modal-menu-hamburguer .main-modal-item.-profile form .input-image-wrapper input')[0];

    if (inputFile.files.length) {

        // Leitor
        const reader = new FileReader();

        // Leia o último arquivo enviado
        reader.readAsDataURL(inputFile.files[0]);

        // Quando for lido algum arquivo, execute esta função
        reader.onload = () => {
            userIcon.src = reader.result;
        }
    }
}