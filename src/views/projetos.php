<?php 
session_start();

require_once('../actions/controleSessao.php');
require_once('../actions/funcoes.php');

$usuarioAtivo = $_SESSION['usuario'];
$usuarioAtivoId = $usuarioAtivo['id'];

$projetos = getProjetosParticipantes();
$musicos = getMusicos();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projetos | Vibrações Infinitas</title>

    <link rel="stylesheet" href="../../public/css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../../public/css/adminlte.min.css">
    <link rel="stylesheet" href="../../public/css/style.css">
</head>
<body>
    <?php require_once('layout/navbar.php'); ?>

    <main class="container">
        <h2>Projetos</h2>

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

        <?php require_once('layout/criarProjeto.php') ?>

        <h3 class="mt-4">Projetos cadastrados</h3>
        <?php if(count($projetos)): ?>
            <?php foreach($projetos as $projeto): ?>
                <div class="card col-8">
                    <div class="card-header">
                        <?= $projeto['Nome'] ?>
                    </div>
                    <div class="card-body">
                        <?= $projeto['Descricao'] ?>
                    </div>

                    <!-- exibe os participantes do projeto -->
                    <div class="card-footer">
                        <span>Membros do projeto</span>
                        <ul class="list-group">
                            <li class="list-group-item"><?= $projeto['criador_nome'] ?> - criador</li>
                            <?php foreach($projeto['participantes'] as $participante): ?>
                                <li class="list-group-item"><?= $participante['Nome'] ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="card col-8">
                <div class="card-body">
                    Ainda não existe nenhum projeto cadastrado
                </div>
            </div>
        <?php endif; ?>
    </main>

    <script src="https://kit.fontawesome.com/df3ed30ad5.js" crossorigin="anonymous"></script>
    <!-- jQuery -->
    <script src="../../public/js/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap -->
    <script src="../../public/js/bootstrap/bootstrap.min.js"></script>
    <script src="../../public/js/index.js"></script>
</body>
</html>