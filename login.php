<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Entrar | Vibrações Infinitas</title>

    <link rel="stylesheet" href="public/css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="public/css/adminlte.min.css">
    <link rel="stylesheet" href="public/css/style.css">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary mb-3">
            <div class="card-header text-center">
                <a href="login.php" class="h1"><b>Vibrações Infinitas</b></a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Entre na sua conta</p>

                <form action="actions/login.php" method="post" class="mb-2">
                    <div class="input-group mb-3">
                        <input id="nomeUsuario" name="nomeUsuario" type="text" class="form-control"
                            placeholder="Nome de usuário" autofocus>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input id="senha" name="senha" type="password" class="form-control" placeholder="Senha">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- /.col -->
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Entrar</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
                <a href="register.php" class="text-center">Ainda não tenho conta</a>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <?php require_once('layout/mensagens.php') ?>
    </div>
    <!-- /.login-box -->

    <script src="https://kit.fontawesome.com/df3ed30ad5.js" crossorigin="anonymous"></script>
    <!-- jQuery -->
    <script src="public/js/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap -->
    <script src="public/js/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="public/js/index.js"></script>
</body>

</html>