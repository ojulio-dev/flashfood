<?php

if (!isset($_GET['id'])) {
    header("Location: index.php?page=item");
    exit();
}

use Dashboard\Model\Item;

$item = new Item;
$delete = $item->deleteById($_GET['id']);

header("Location: index.php?page=read");
exit();