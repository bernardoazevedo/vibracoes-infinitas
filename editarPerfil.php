<?php 
session_start();

require_once('actions/funcoes.php');

$usuarioAtivo = getUsuarioLogado();
$usuario = getMusicoPeloId($usuarioAtivo['id']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar perfil | Vibrações Infinitas</title>

    <link rel="stylesheet" href="public/css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="public/css/adminlte.min.css">
    <link rel="stylesheet" href="public/css/style.css">
</head>

<body class="hold-transition register-page">
    <div class="register-box">
        <div class="card card-outline card-primary mb-3">
            <div class="card-header text-center">
                <a href="register.php" class="h1"><b>Vibrações Infinitas</b></a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Edite as informações do seu perfil</p>

                <form action="../actions/atualizarPerfil.php" method="post" enctype="multipart/form-data">
                    <label for="nome" class="mb-0">Nome</label>
                    <div class="input-group mb-3">
                        <input id="nome" name="nome" type="text" class="form-control" placeholder="Nome completo" value="<?= $usuario['Nome'] ?>" autofocus>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>

                    <label for="fotoPerfil" class="mb-0">Foto de perfil</label>
                    <div class="input-group mb-3">
                        <input class="form-control" type="file" name="fotoPerfil" id="fotoPerfil" placeholder="Foto de perfil">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-image"></span>
                            </div>
                        </div>
                    </div>

                    <label for="descricao" class="mb-0">Descrição do perfil</label>
                    <div class="input-group mb-3">
                        <textarea class="form-control" name="descricao" id="descricao" placeholder="Descrição do perfil"><?= $usuario['Descricao'] ?></textarea>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>

                    <label for="senha" class="mb-0">Senha atual</label>
                    <div class="input-group mb-3">
                        <input id="senha" name="senha" type="password" class="form-control" placeholder="Senha" value="">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>

                    <label for="nova-senha" class="mb-0">Nova senha</label>
                    <div class="input-group mb-3">
                        <input id="nova-senha" name="nova-senha" type="password" class="form-control" placeholder="Digite a senha novamente">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>

                    <label for="confirma-nova-senha" class="mb-0">Confirme sua nova senha</label>
                    <div class="input-group mb-3">
                        <input id="confirma-nova-senha" name="confirma-nova-senha" type="password" class="form-control" placeholder="Digite a senha novamente">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- /.col -->
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Salvar alterações</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
            </div>
            <!-- /.form-box -->
        </div><!-- /.card -->

        <?php require_once('layout/mensagens.php') ?>
    </div>
    <!-- /.register-box -->

    <script src="https://kit.fontawesome.com/df3ed30ad5.js" crossorigin="anonymous"></script>
    <!-- jQuery -->
    <script src="public/js/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap -->
    <script src="public/js/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="public/js/index.js"></script>
</body>

</html>