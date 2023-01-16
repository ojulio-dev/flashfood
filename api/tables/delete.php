<?php

use Model\Table;

$table = new Table();

if (isset($_POST['tableId'])) {

    $delete = $table->delete($_POST['tableId']);

    if ($delete) {

        echo json_encode($delete, JSON_UNESCAPED_UNICODE);
        exit();
    }
}