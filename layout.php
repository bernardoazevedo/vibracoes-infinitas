<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layout | Vibrações Infinitas</title>

    <link rel="stylesheet" href="public/css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="public/css/adminlte.min.css">
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
    <?php require_once('layout/navbar.php'); ?>
    <div class="">
        <div class="row align-items-start">
            <?php require_once('layout/barraEsquerda.php'); ?>
            <div class="col-sm-6 mt-3">
                <main class="container">
                    <?php require_once('layout/mensagens.php'); ?>
                <!-- Conteúdo da página aqui -->
                


                <!-- Conteúdo da página aqui -->
                </main>
            </div>
            <?php require_once('layout/barraDireita.php'); ?>
        </div>
    </div>
    <script src="https://kit.fontawesome.com/df3ed30ad5.js" crossorigin="anonymous"></script>
    <script src="public/js/jquery-3.7.1.min.js"></script>
    <script src="public/js/bootstrap/bootstrap.min.js"></script>
    <script src="public/js/index.js"></script>
</body>
</html>