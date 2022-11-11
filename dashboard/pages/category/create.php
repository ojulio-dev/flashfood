<section class="main-create-category">
    <div class="products-title-wrapper">
        <a href="?page=category">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h1 class="main-products-title">Cadastro de Categorias</h1>
    </div>

    <form id="form-category-create" class="main-products-form category" method="POST">
        <div class="form-items-products">
            <div class="input-products-wrapper">
                <label for="name">Categoria</label>
                <input type="text" name="name" placeholder="Digite a Categoria" required>
            </div>

            <div class="input-products-wrapper">
                <label for="banner">Banner</label>
                <input type="file"  accept=".jpg, .png, .jpeg, .gif" name="banner" required>
            </div>

            <div class="input-products-wrapper">
                <label for="status">Status</label>
                <select name="status" required>
                    <option value="1" selected>Ativado</option>
                    <option value="0">Desativado</option>
                </select>
            </div>
        </div>

        <button type="button" id="button-create-category" class="button-submit success">Cadastrar</button>
    </form>
</section>