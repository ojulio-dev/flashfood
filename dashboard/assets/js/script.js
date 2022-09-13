$(document).ready(function() {
    $('.main-dashboard-aside li').click(function(event) {
        
        var item = event.target.closest('li');
        
        if ($(item).hasClass('active')) {
            $(item).removeClass('active');
            
        } else {
            $('.main-dashboard-aside li').removeClass('active');
            
            $(item).addClass('active');
        }
    });
});