<section class="main-create-category">
    <div class="dashboard-title-wrapper">
        <a href="?page=category">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h1 class="main-dashboard-title">Cadastro de Categorias</h1>
    </div>

    <form id="form-category-create" class="main-dashboard-form category" method="POST">
        <div class="main-form-items">
            <div class="main-input-wrapper">
                <label for="name-create-category">Categoria</label>
                <input type="text" name="name" id="name-create-category" placeholder="Digite a Categoria" required>
            </div>

            <div class="main-input-wrapper">
                <label for="banner-create-category">Banner</label>
                <input type="file"  accept=".jpg, .png, .jpeg, .gif" name="banner" id="banner-create-category" required>
            </div>

            <div class="main-input-wrapper">
                <label for="status-create-category">Status</label>
                <select name="status" id="status-create-category" required>
                    <option value="1" selected>Ativado</option>
                    <option value="0">Desativado</option>
                </select>
            </div>
        </div>

        <button type="button" id="button-create-category" class="button-submit success">Cadastrar</button>
    </form>
</section>