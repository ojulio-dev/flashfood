<section class="main-create-ingredient">
    <div class="products-title-wrapper">
        <a href="?page=ingredient">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h1 class="main-products-title">Cadastro</h1>
    </div>

    <form id="form-ingredient-create" class="main-products-form" method="POST">
        <div class="form-items-products">
            <div class="input-products-wrapper">
                <label for="name-create-ingredient">Ingrediente</label>
                <input type="text" name="name" id="name-create-ingredient" placeholder="Digite o Ingrediente" required>
            </div>

            <div class="input-products-wrapper">
                <label for="price-create-ingredient">Preço</label>
                <input type="text" class="input-mask-money" name="price" id="price-create-ingredient" placeholder="Digite o Preço" required>
            </div>

            <div class="input-products-wrapper">
                <label for="status-create-ingradient">Status</label>
                <select name="status" id="status-create-ingradient" required>
                    <option value="1" selected>Ativado</option>
                    <option value="0">Desativado</option>
                </select>
            </div>
        </div>

        <button type="button" id="button-create-ingredient" class="button-submit success">Cadastrar</button>
    </form>
</section>