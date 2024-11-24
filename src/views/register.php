<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Criar conta | Vibrações Infinitas</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="public/css/adminlte.min.css">
</head>

<body class="hold-transition register-page">
    <div class="register-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="index2.html" class="h1"><b>Vibrações Infinitas</b></a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Crie sua conta</p>

                <form action="src/actions/register.php" method="post">
                    <div class="input-group mb-3">
                        <input id="nome" name="nome" type="text" class="form-control" placeholder="Nome completo">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input id="nomeUsuario" name="nomeUsuario" type="text" class="form-control"
                            placeholder="Nome de usuário">
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
                    <div class="input-group mb-3">
                        <input id="confirma-senha" name="confirma-senha" type="password" class="form-control"
                            placeholder="Digite a senha novamente">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- /.col -->
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Criar conta</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <a href="login" class="text-center">Já tenho conta</a>
            </div>
            <!-- /.form-box -->
        </div><!-- /.card -->

        <?php if(isset($_SESSION['mensagem'])): ?>
        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
            <?php
                print_r($_SESSION['mensagem']);
                unset($_SESSION['mensagem']);
                ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php endif; ?>
    </div>
    <!-- /.register-box -->

    <script src="https://kit.fontawesome.com/df3ed30ad5.js" crossorigin="anonymous"></script>
    <!-- jQuery -->
    <script src="public/js/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script>
        $('.close').each(function() {
            $(this).click(function(){
                $(this).parent().addClass('d-none');
            });
        });
    </script>
</body>

</html>