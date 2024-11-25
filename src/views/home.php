<?php 
session_start();

require_once(__DIR__.'/../actions/controleSessao.php');
require_once(__DIR__.'/../actions/funcoes.php');
require_once(__DIR__.'/../actions/db-connect.php');

$usuarioAtivo = $_SESSION['usuario'];
$usuarioAtivoId = $usuarioAtivo['id'];

$musicos = getMusicos($connect);
$atividades = getAtividadesDasConexoes($connect, $usuarioAtivoId);

mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vibrações Infinitas</title>

    <link rel="stylesheet" href="../../public/css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../../public/css/adminlte.min.css">
    <link rel="stylesheet" href="../../public/css/style.css">
</head>
<body>
    <?php require_once(__DIR__.'/layout/navbar.php'); ?>

    <main class="container">
        <!-- Exibe as mensagens passadas pela Session -->
        <?php if(isset($_SESSION['mensagens'])): ?>
            <?php foreach($_SESSION['mensagens'] as $key => $mensagem): ?>
                <div class="alert alert-<?= $mensagem['tipo'] ?> alert-dismissible fade show mt-3" role="alert">
                    <span>
                        <?= $mensagem['texto']; ?>
                    </span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php unset($_SESSION['mensagens'][$key]) ?>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php require_once(__DIR__.'/layout/enviarMusica.php') ?>

        <h3 class="mt-4">Atividades</h3>
        <?php if(count($atividades)): ?>
            <?php foreach($atividades as $atividade): ?>
                <div class="card col-8">
                    <div class="card-body">
                        <?= $atividade['AtividadeDescricao'] ?>
                    </div>
                    <div class="card-footer">
                        <?php 
                          $dataAtividade = new DateTime($atividade['DataAtividade']);
                          echo $dataAtividade->format('H:i - d/m/Y');
                        ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="card col-8">
                <div class="card-body">
                    Ainda não existe nenhuma atividade
                </div>
            </div>
        <?php endif; ?>

        <audio controls>
            <source src="../../public/musicas/asd.mp3" type="audio/mp3">
        </audio>
    </main>

    <script src="https://kit.fontawesome.com/df3ed30ad5.js" crossorigin="anonymous"></script>
    <!-- jQuery -->
    <script src="../../public/js/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap -->
    <script src="../../public/js/bootstrap/bootstrap.min.js"></script>
    <script src="../../public/js/index.js"></script>
</body>
</html>