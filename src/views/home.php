<?php 
session_start();

require_once(__DIR__.'/../actions/controleSessao.php');
require_once(__DIR__.'/../actions/funcoes.php');
require_once(__DIR__.'/../actions/db-connect.php');

$usuarioAtivo = $_SESSION['usuario'];
$usuarioAtivoId = $usuarioAtivo['id'];

$musicos = getMusicos();
$atividades = getAtividadesDasConexoes($usuarioAtivoId);

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
                <?php 
                    $dataAtividade = new DateTime($atividade['DataAtividade']);
                    $data = $dataAtividade->format('H:i - d/m/Y');

                    if($atividade['MusicaID']): 
                        $musica = getMusicaPeloId($atividade['MusicaID']); 
                        $usuario = getMusicoPeloId($atividade['UsuarioID']); ?>

                        <div class="card col-8">
                            <div class="card-header">
                                <img src="../../public/fotos/<?= $usuario['FotoPerfil'] ?>" class="rounded-circle" alt="" width="40px" height="40px">
                                <span class="ml-2"><?= $usuario['Nome'] ?> compartilhou uma nova música</span>
                            </div>
                            <div class="card-body">
                                <audio controls>
                                    <source src="../../public/musicas/<?=$musica['NomeArquivo']?>" type="audio/mpeg">
                                </audio>
                            </div>
                            <div class="card-footer">
                                <span class="fs-6"><?= $data ?></span>
                            </div>
                        </div>

                <?php elseif($atividade['ProjetoID']): 
                    $projeto = getProjetoPeloId($atividade['ProjetoID']);
                    echo '<pre>';
                    echo '<hr>$projeto: '; print_r($projeto);
                    echo '</pre>';
                    die();
                    ?>
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

                <?php endif; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="card col-8">
                <div class="card-body">
                    Ainda não existe nenhuma atividade
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