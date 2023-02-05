$(document).ready(function() {

    setInterval(readOrders, 25000);
})

$('body').on('click', '.button-action-order.-pendente, .button-action-order.-processando', function() {
    let orderId = $(this).closest('#main-orders .elements-order').data('order-id');

    let statusId = $(this).closest('#main-orders .elements-order').data('status-id');

    statusId = statusId == 1 ? 2 : 3;

    $.ajax({
        url: `${SERVER_HOST}/api/?api=orders&action=changeStatus`,
        type: 'POST',
        data: {
            orderId,
            statusId
        },
        dataType: 'json',
        success: function(data) {

            if (data) {

                readOrders();

                Swal.fire({
                    title: 'Tudo Certo!',
                    html: `O status do pedido foi alterado para <b>${statusId == 2 ? 'Processando' : 'Finalizado'}</b>!`,
                    icon: 'success'
                })

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
})

const readOrders = () => {

    $.ajax({
        url: `${SERVER_HOST}/api/?api=orders&action=listOrdersKitchen`,
        dataType: 'json',
        success: function(data) {

            $('#main-orders').html('');

            data.map(order => {

                let orderItems = order.order_items.map(item => {
                    let additionals = item.additionals.map(additional => {
                        return `<li>
                                <i class="fa-solid fa-plus symbol-additional"></i>
                                <small>${additional.additional_name} (${additional.quantity})</small>
                            </li>`
                    }).join('')

                    return `<li class="order-wrapper">
                            <h5><span>${item.quantity}</span> ${item.product_name}</h5>

                            ${item.additionals.length >= 1 ? `
                            
                                <ul class="additionals-wrapper">${additionals}</ul>
                            
                            ` : ''}

                            ${item.note ? `
                                <div class="obs-wrapper">
                                    <span>* ${item.note}</span>
                                </div>
                            ` : ''}
                        </li>`
                }).join('')

                $('#main-orders').append(`
                
                    <div class="elements-order" data-order-id="${order.order_id}" data-status-id="${order.status_id}">
                        <div class="order-info">
                            <div class="position-number-wrapper">
                                <span>${order.table_number}</span>
                
                                <h4>#${order.order_number}</h4>
                            </div>
                            <div class="user-time-wrapper">
                                <p><i class="fa-solid fa-user"></i> ${order.user_name}</p>
                                <span><i class="fa-regular fa-clock"></i> ${order.timeSpent}</span>
                            </div>
                        </div>
                
                        <div class="products-wrapper">
                            <ul>${orderItems}</ul>
                        </div>
                
                        <button class="button-action-order -${order.status_name}">${order.status_id == 1 ? 'Começar' : 'Finalizar'}</button>
                    </div>
                
                `);

            });

        },
        error: function() {

            Swal.fire({
                title: 'Erro!',
                text: 'Um problema inesperado aconteceu. Avise os administradores o mais rápido possível!',
                icon: 'error'
            })

        }

    })
}