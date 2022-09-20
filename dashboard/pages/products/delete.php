<?php

if (!isset($_GET['id'])) {
    header("Location: index.php?page=products");
    exit();
}

use Dashboard\Model\Product;

$product = new Product;
$delete = $product->deleteById($_GET['id']);

header("Location: index.php?page=read");
exit();