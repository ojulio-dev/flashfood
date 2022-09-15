<h1 class="products-create-title">Cadastro de Produto</h1>

<form action="" class="products-create" enctype="multipart/form-data">
    <div class="input-create-wrapper">
        <label for="name">Nome</label>
        <input type="text" name="name" id="name" placeholder="Digite o Nome">
    </div>
    
    <div class="input-create-wrapper">
        <label for="description">Descrição</label>
        <input type="text" name="description" id="description" placeholder="Digite a Descrição">
    </div>

    <div class="input-create-wrapper">
        <label for="price">Preço</label>
        <input type="text" name="price" id="price" placeholder="R$ 100">
    </div>

    <div class="input-create-wrapper">
        <label for="special_price">Desconto</label>
        <input type="text" name="special_price" id="special_price" placeholder="R$ 50">
    </div>

    <div class="input-create-wrapper">
        <label for="slug">Slug</label>
        <input type="text" name="slug" id="slug" placeholder="Digite o Slug">
    </div>

    <div class="input-create-wrapper">
        <label for="status">Status</label>
        <select name="status" id="status">
            <option value="1" selected>Ativado</option>
            <option value="0">Desativado</option>
        </select>
    </div>

    <div class="input-create-wrapper">
        <label for="banner">Banner</label>
        <input type="file" name="banner" id="banner">
    </div>
</form>