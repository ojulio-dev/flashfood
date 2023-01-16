<?php

use Model\Table;

$table = new Table();

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: ?page=tables");
}

$readTable = $table->readByTableId($_GET['id']);

if (!$readTable) {
    
    header("Location: ?page=tables");
    exit();
}

?>

<section class="main-update-table">
    <div class="dashboard-title-wrapper">
        <a href="?page=tables">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h1 class="main-dashboard-title">Update</h1>
    </div>

    <form id="form-tables-update" class="main-dashboard-form">
        <div class="main-form-items">
            <div class="main-input-wrapper">
                <label for="name-update-tables">Número da Mesa</label>
                <input type="number" name="table_number" id="name-update-tables" placeholder="Digite o Número" value="<?= $readTable['table_number'] ?>" required>
            </div>

            <div class="main-input-wrapper">
                <label for="update-status-tables">Status</label>
                <select name="status" id="update-status-tables">
                    <option value="1" <?= 1 == $readTable['status'] ? 'selected' : '' ?>>Ativado</option>
                    <option value="0" <?= 0 == $readTable['status'] ? 'selected' : '' ?>>Desativado</option>
                </select>
            </div>
        </div>

        <button type="button" id="button-update-tables" class="button-submit success" data-table-id="<?= $_GET['id'] ?>">Atualizar</button>

        <button type="button" id="button-delete-tables" class="button-submit delete"  data-table-id="<?= $_GET['id'] ?>">Deletar</button>
    </form>
</section>