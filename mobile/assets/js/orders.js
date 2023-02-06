$(document).ready(function() {
    setInterval(readOrders, 10000);
})

const readOrders = () => {

    const result = fetch(`${SERVER_HOST}/api/?api=orders&action=listByUserId`)
    .then((response) => response.json())
    .then((result) => {

        if (result.length) {

            $('.main-section-orders .infos-wrapper .orders-wrapper').html('');

            result.map(order => {
    
                $('.main-section-orders .infos-wrapper .orders-wrapper').append(`
                    <li>
                        <span>${order.quantity}</span>

                        <strong>#${parseInt(order.order_number)}</strong>

                        <p style="background-color: ${order.status_color};" class="order-status">${order.status_name[0].toUpperCase() + order.status_name.substr(1)}</p>
                    </li>
                `);
            })
        } else {

            $('.main-section-orders .infos-wrapper').html('<p class="notfound">Nenhum pedido foi encontrado :/</p>');

        }

    })

}