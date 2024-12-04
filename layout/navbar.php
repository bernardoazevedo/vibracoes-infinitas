<nav class="navbar navbar-expand-lg bg-body-tertiary sticky-top navbar-light bg-light shadow-sm">
    <div class="container-sm">
        <div class="w-auto">
            <img src="public/logo.png" alt="" width="40px" height="40px">
        </div>

        <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php">Início</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="musicas.php">Músicas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="musicos.php">Músicos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="projetos.php">Projetos</a>
                </li>
            </ul>
            <ul class="navbar-nav navbar-right">
                <?php if($_SESSION['usuario']['logado']): ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Minha conta
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item disabled" href="#">
                                <?= $_SESSION['usuario']['nomeUsuario'] ?>
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="perfil.php">
                                Editar meu perfil
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger" href="../actions/logout.php">
                                Sair
                            </a>
                        </li>
                    </ul>
                </li>

                <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Entrar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="register.php">Criar conta</a>
                </li>
                <?php endif; ?>
            </ul>
        </div>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01"
            aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>