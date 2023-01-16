<section class="main-create-user">
    <div class="dashboard-title-wrapper">
        <a href="?page=tables">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h1 class="main-dashboard-title">Cadastro</h1>
    </div>

    <form id="form-tables-create" class="main-dashboard-form" method="POST">
        <div class="main-form-items">
            <div class="main-input-wrapper">
                <label for="number-create-tables">Número da Mesa</label>
                <input type="number" name="tableNumber" class="input-mask-number" id="number-create-tables" placeholder="Digite o Número" required>
            </div>

            <div class="main-input-wrapper">
                <label for="status-create-tables">Status</label>
                <select name="status" id="status-create-tables" required>
                    <option value="1">Ativado</option>
                    <option value="0">Desativado</option>
                </select>
            </div>
        </div>

        <button type="button" id="button-create-tables" class="button-submit success">Cadastrar</button>
    </form>
</section>