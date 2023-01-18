// Modal Observação
$('#button-modal-obs').click(function(){
    $('#main-modal-obs').show()
})

$('#cancelar-modal-obs').click(function(){
    $('#main-modal-obs').hide()
})

// Modal Menu Hamburguer
$('.header-menu-wrapper #header-burguer-icon').click(function() {
    $('#modal-header-menu').css('display', 'flex');
}) 

$('#modal-header-menu #close-modal-header').click(function() {
    $('#modal-header-menu').hide();
})