<header class="main-landingpage-header">
    <nav>
        <a href="?page=home">Página Inicial</a>
    </nav>

    <?php if (isset($_SESSION['flashfood']['user'])): ?>
        <div id="modal-menu-hamburguer">
            <i class="fa-solid fa-bars" id="icon-menu-burguer"></i>

            <div class="main-modal">
                <div class="main-modal-close"></div>

                <div class="main-modal-item -navigation">
                    <ul>
                        <?php if ($_SESSION['flashfood']['user']['role_id'] == 1): ?>
                            <li><a href="<?= SERVER_HOST ?>/dashboard">Dashboard</a></li>
                        <?php endif; ?>    
                        
                        <?php if ($_SESSION['flashfood']['user']['role_id'] <= 2): ?>
                            <li><a href="<?= SERVER_HOST ?>/kitchen/">Cozinha</a></li>
                        <?php endif; ?>
                           
                        <li><a href="<?= SERVER_HOST ?>/mobile/">Cardápio</a></li>
                        
                        <li class="profile-anchor">Meu Perfil</li>
                    </ul>
                </div>
                
                <div class="main-modal-item -profile">
                    <form id="form-profile-user">
                        <div class="return-image-wrapper">
                            <i class="fa-solid fa-arrow-left"></i>

                            <div class="input-image-wrapper">
                                <label for="user-image"><img src="<?= $_SESSION['flashfood']['user']['image'] ?>" alt="User Icon"></label>
                                <input type="file" accept="image/png, image/gif, image/jpeg, image/jpg, image/webp" name="image" id="user-image">
                            </div>
                        </div>

                        <div class="inputs-wrapper">
                            <div class="input-wrapper">
                                <label for="user-name"><i class="fa-solid fa-pen-to-square"></i></label>
                                <input class="disabled" type="text" name="name" id="user-name" value="<?= $_SESSION['flashfood']['user']['name'] ?>">
                            </div>

                            <div class="input-wrapper">
                                <label for="user-email"><i class="fa-solid fa-pen-to-square"></i></label>
                                <input class="disabled" type="email" name="email" id="user-email" value="<?= $_SESSION['flashfood']['user']['email'] ?>">
                            </div>
                        </div>

                        <div class="buttons-wrapper">
                            <button class="button-action -cancel" type="button">Cancelar</button>
                            <button class="button-action -save" type="button">Salvar</button>
                        </div>
                    </form>

                    <div class="button-wrapper">
                        <button class="main-button">Sair</button>
                    </div>
                </div> 
            </div>
        </div>
    <?php else: ?>

        <a href="?page=login"><button class="main-button">Entrar <i class="fa-solid fa-user"></i></button></a>
    <?php endif; ?>
</header>