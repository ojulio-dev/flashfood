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

$('.header-responsivo .header-search-wrapper .header-button-search').click(function() {
    let inputWidth = $('.header-responsivo .header-search-wrapper input').css('width');

    if (inputWidth == '65px') {
        $('.header-responsivo > img').css('opacity', '0');

        $('.header-responsivo .header-search-wrapper input').css('width', '111%');
    } else {
        $('.header-responsivo > img').css('opacity', '1');

        $('.header-responsivo .header-search-wrapper input').css('width', '65px');
    }
})