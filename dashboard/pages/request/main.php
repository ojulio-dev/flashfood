<?php

$mock = array(
    [
        'name' => 'Sorvete Qualquer',
        'banner' => '6.jpg',
        'amount' => 2,
        'price' => 14.99,
        'table' => 2
    ],
    [
        'name' => 'Açaí ao Molho',
        'banner' => '12.jpg',
        'amount' => 2,
        'price' => 14.99,
        'table' => 2
    ],
    [
        'name' => 'Sorvete Qualquer',
        'banner' => '14.jpg',
        'amount' => 2,
        'price' => 14.99,
        'table' => 2
    ],
    [
        'name' => 'Açaí ao Molho',
        'banner' => '44.jpg',
        'amount' => 2,
        'price' => 14.99,
        'table' => 2
    ]
);

?>

<section id="main-create-request" class="main-create-request">
    <div class="products-title-wrapper">
        <h1 class="main-products-title">Cardápio</h1>
    </div>

    <div class="main-request-products">
        <?php foreach($mock as $product): ?>
            <div class="main-request-item">
                <img src="<?= DIR_IMG ?>/products/<?= $product['banner'] ?>">

                <h3><?= $product['name'] ?></h3>
                <h4>R$<?= $product['price'] ?></h4>   
            </div>
        <?php endforeach ?>
    </div>
</section>