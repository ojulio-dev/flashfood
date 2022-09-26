<?php

if (!isset($_GET['id'])) {
    header("Location: index.php?page=category");
    exit();
}

use Dashboard\Model\ProductCategory;

$product = new ProductCategory;
$delete = $product->deleteById($_GET['id']);

header("Location: index.php?page=category");
exit();