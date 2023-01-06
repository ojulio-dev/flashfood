<?php

use Model\ProductCategory;
use Model\Product;

$productCategory = new ProductCategory;

$product = new Product;

?>

<section id="main-read-menu" class="main-read-menu">
    <div class="dashboard-title-wrapper">
        <a href="?page=orders">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h1 class="main-dashboard-title">Cardápio</h1>
    </div>

    <div class="search-form">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input id="menu-search" type="search" placeholder="Search...">
    </div>

    <ul id="read-menu-wrapper">
        <?php foreach($productCategory->read() as $category): ?>
            <?php $products = $productCategory->readByCategory($category['category_id']); ?>

            <?php if(count($products)): ?>
                <li class="main-orders">
                    <div class="menu-category-wrapper">
                        <h3><?= $category['name'] ?></h3>
                        <?= count($products) >= 4 ? '<a href="#">Ver todos</a>' : '' ?>
                    </div>

                    <div class="owl-carousel owl-theme">
                        <?php foreach($products as $product): ?>
                            <div class="main-orders-item">
                                <a href="#">
                                    <div class="products-image-wrapper">
                                        <img src="<?= SERVER_HOST ?>/assets/images/products/<?= $product['banner'] ?>">
                                        <button type="button" class="show-modal-product" data-product-id="<?= $product['product_id'] ?>"><i class="fa-solid fa-plus"></i></button>
                                    </div>

                                    <strong><?= $product['name'] ?></strong>
                                    <p>R$ <?= number_format($product['special_price'], 2, ',', '.') ?></p>
                                </a>   
                            </div>
                        <?php endforeach ?>
                    </div>
                </li>
        <?php endif; endforeach ?>
    </ul>

    <div class="main-modal" id="modal-orders">
        <div class="modal-exit"></div>

        <div class="main-modal-wrapper -orders"></div>
    </div>
</section>
