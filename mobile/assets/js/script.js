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

$('#button-header-search').click(function() {
    $('#modal-header-search').css('display', 'flex');

    $('#modal-header-search .modal-item-wrapper input').focus();
})

$('.header-search-wrapper .header-search-close').click(function() {
    $('#modal-header-search').hide();
})

$('#modal-header-search .modal-item-wrapper input').click(function() {
    $('#modal-header-search .modal-item-wrapper label').css('top', '0');

    $('#modal-header-search .modal-item-wrapper label').css('border-top', '1px solid #000');

})