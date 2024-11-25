<nav class="navbar navbar-expand-lg shadow-sm mb-5">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">Vibrações Infinitas</a>
        <div class="container-fluid">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="home.php">Início</a>
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
                <li class="nav-item">
                    <a class="nav-link" href="../actions/logout.php"><?= $_SESSION['usuario']['nomeUsuario'] ?> - Sair</a>
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
    </div>
</nav>