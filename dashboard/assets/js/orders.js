$('#menu-search').keyup(function(event) {
    var search = event.target.value.toLowerCase();
    
    var rows = $('.main-orders');

    rows.each(function(index, div) {

        var category = $(div).find('strong')[0].innerHTML.toLowerCase();

        !category.includes(search) ? $(div).hide() : $(div).show();

    });

    var hasEmpty = !!rows.filter((_, row) => {
        if (row.style.display != 'none') {
            return row;
        }

    }).length;

    // if (hasEmpty) {
    //     $('#read-table-category-items').append(`

    //         <tr>
    //             <td>Nenhuma Categoria cadastrada, cadastre clicando <a class="link-no-results" href="?page=category&action=create">aqui</a></td> 
    //         </tr>
        
    //     `);
    // }

    if (!rows.length) {
        console.log('oi');
    }
});