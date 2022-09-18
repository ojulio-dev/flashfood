<?php

use Dashboard\Model\Item;

$item = new Item;

$read = $item->read();

?>

<section class="main-read-item">
    <div class="products-title-wrapper">
        <h1 class="main-item-title">Listagem de Produtos</h1>
    </div>

    <table>
        <tbody>
            <?php foreach($read as $item): ?>
                <tr>
                    <td><img src="assets/images/item/<?= $item['banner'] ?>" alt=""></td>
                    <td><?= $item['name'] ?></td>
                    <td>R$ <?= $item['special_price'] ?></td>
                    <td>
                        <div class="read-icons-wrapper">
                            <a href="?page=item&action=update&id=<?= $item['item_id'] ?>">
                                <i class="fa-solid fa-pen-to-square fa-solid-edit"></i>
                            </a>
                            <a href="?page=item&action=delete&id=<?= $item['item_id'] ?>">
                                <i class="fa-solid fa-trash fa-solid-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</section>