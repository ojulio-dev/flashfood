<?php

$mock = array(
    [
        'name' => 'Sorvete Qualquer',
        'banner' => '14.jpg',
        'amount' => 2,
        'price' => 14.99,
        'table' => 2
    ],
    [
        'name' => 'Açaí ao Molho',
        'banner' => '14.jpg',
        'amount' => 2,
        'price' => 14.99,
        'table' => 2
    ],
    [
        'name' => 'Açaí',
        'banner' => '110.jpg',
        'amount' => 2,
        'price' => 14.99,
        'table' => 2
    ]
);

?>

<div class="main-modal" id="modal-cart">
    <div class="main-modal-wrapper -cart">
        <div class="main-modal-title">
            <h2>Carrinho</h2>
            
            <i class="fa-solid fa-xmark icon-exit" id="icon-cart-exit"></i>
        </div>

        <div class="cart-table-wrapper">
            <table class="table-modal">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Preço</th>
                        <th>Quantidade</th>
                        <th>Mesa</th>
                        <th>Ações</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($mock as $product): ?>
                        <tr>
                            <td>
                                <div class="modal-name-wrapper">
                                    <h4><?= strlen($product['name']) > 10 
                ? substr($product['name'], 0, 10) . '...' 
                : $product['name'] ?></h4>
                                    <img src="<?= DIR_IMG ?>/products/<?= $product['banner'] ?>" alt="">
                                </div>
                            </td>
                            <td><?= $product['price'] ?></td>
                            <td><?= $product['amount'] ?></td>
                            <td><?= $product['table'] ?></td>
                            <td>
                                <button class="cart-button -remove"><i class="fa-sharp fa-solid fa-circle-minus"></i></button>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>

        <a href="" class="cart-plus-link">Mais informações</a>
    </div>
</div>

<header class="main-dashboard-header">
    <img src="<?= DIR_IMG ?>/header/flashfood_icon.png" alt="">

    <div class="header-customer-wrapper">
        <i class="fa-solid fa-cart-shopping fa-lg" id="icon-cart-modal"></i>

        <i class="fa-solid fa-bell fa-lg"></i>

        <i class="fa-solid fa-user fa-lg"></i>
    </div>
</header>