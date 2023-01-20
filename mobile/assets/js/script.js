// Modal Observação
$('#button-modal-obs').click(function(){
    $('#main-modal-obs').show()
})

$('#cancelar-modal-obs,#modal-obs-close').click(function(){
    $('#main-modal-obs').hide()
    $('.input-modal-obs').val("")
})

$('#enviar-modal-obs').click(function(){
    $('#main-modal-obs').toggle()
})

// Modal Menu Hamburguer
$('.header-menu-wrapper #header-burguer-icon').click(function() {
    $('#modal-header-menu').css('display', 'flex');
}) 

$('#modal-header-menu #close-modal-header,#header-menu-close').click(function() {
    $('#modal-header-menu').hide();
})
