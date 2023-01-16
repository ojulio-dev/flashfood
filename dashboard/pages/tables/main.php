<?php

use Model\Table;

$table = new Table();

$tables = $table->readDashboard();

?>

<section class="main-read-tables">
    <div class="dashboard-title-wrapper">
        <h1 class="main-dashboard-title">Mesas</h1>
    </div>

    <div class="read-table-scroll-wrapper -tables">
        <table class="main-read-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Número</th>
                    <th>Status</th>
                    <th class="read-table-action">Action</th>
                </tr>
            </thead>
            <tbody id="read-table-tables-items">
                <?php if ($tables): foreach($tables as $table): ?>
                    <tr>
                        <td><?= $table['table_id'] ?></td>
                        <td>Mesa  número <?= $table['table_number'] ?></td>
                        <td class="read-table-status">
                            <form>
                                <input name="status-read-tables" id="status-read-tables" onclick="changeStatus(<?= $table['table_id'] ?>, 'table')" type="checkbox" <?= $table['status'] == 1 ? 'checked' : '' ?>/>
                                <label for="status"></label>
                            </form>
                        </td>
                        <td class="read-table-action">
                            <div class="read-table-icons-wrapper">
                                <button class="remove-action -tables" data-table-id="<?= $table['table_id'] ?>"><i class="fa-solid fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                <?php  endforeach; else: ?>
                    <tr>
                        <td colspan="4">Nenhuma Mesa cadastrada, cadastre clicando <a class="link-no-results" href="?page=tables&action=create">aqui</a></td> 
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>