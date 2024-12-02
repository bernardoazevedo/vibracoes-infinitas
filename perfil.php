<?php 
session_start();

require_once('actions/funcoes.php');
require_once('actions/controleSessao.php');

$usuarioAtivo = getUsuarioLogado();
$usuarioAtivoId = $usuarioAtivo['id'];
$usuario = getMusicoPeloId($usuarioAtivoId);

$conexoes = getConexoes($usuarioAtivoId);
$musicos = getMusicos();
$musicosConexoes = getMusicosConexoes($usuarioAtivoId);

$quantidadeMusicas = getQuantidadeMusicas($usuarioAtivoId);
$quantidadeProjetos = getQuantidadeProjetos($usuarioAtivoId);
$quantidadeConexoes = getQuantidadeConexoes($usuarioAtivoId);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $usuario['NomeUsuario'] ?> | Vibrações Infinitas</title>

    <link rel="stylesheet" href="public/css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="public/css/adminlte.min.css">
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
    <?php require_once('layout/navbar.php'); ?>
    <div class="">
        <div class="row align-items-start">
            <?php require_once('layout/barraEsquerda.php'); ?>
            <div class="col-lg-6 mt-3">
                <main class="container">
                    <?php require_once('layout/mensagens.php'); ?>
                <!-- Conteúdo da página aqui -->
                
                <div class="card">
                    <div class="card-header">
                        <div class="col">
                            <div class="media align-items-end ">
                                <div class="mr-3">
                                    <img src="public/fotos/<?= $usuario['FotoPerfil'] ?>"
                                        alt="..." width="120px" height="120px" class="rounded mb-2 img-thumbnail">
                                    <a href="editarPerfil.php" class="btn btn-outline-dark btn-sm btn-block">
                                        Editar perfil
                                    </a>
                                </div>
                                <div class="media-body mb-5 ">
                                    <h4 class="mt-0 mb-0 text-truncate"><?= $usuario['Nome'] ?></h4>
                                    <p class="small mb-4 text-truncate"><?= $usuario['NomeUsuario'] ?></p>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="card-body container">
                        <div class="col">
                            <div class="row">
                                <div class="col">
                                    <h5 class="font-weight-bold mb-0 d-block"><?= $quantidadeMusicas ?></h5>
                                    <small class="text-muted"> 
                                        <i class="fas fa-image mr-1"></i>Músicas
                                    </small>
                                </div>
                                <div class="col">
                                    <h5 class="font-weight-bold mb-0 d-block"><?= $quantidadeProjetos ?></h5>
                                    <small class="text-muted"> 
                                        <i class="fas fa-user mr-1"></i>Projetos
                                    </small>
                                </div>
                                <div class="col">
                                    <h5 class="font-weight-bold mb-0 d-block"><?= $quantidadeConexoes ?></h5>
                                    <small class="text-muted"> 
                                        <i class="fas fa-user mr-1"></i>Conexões
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-footer">
                        <div class="">
                            <div class="p-2">
                                <p class="font-italic mb-0"><?= $usuario['Descricao'] ?></p>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- Conteúdo da página aqui -->
                </main>
            </div>
            <?php require_once('layout/barraDireita.php'); ?>
        </div>
    </div>
    <script src="https://kit.fontawesome.com/df3ed30ad5.js" crossorigin="anonymous"></script>
    <script src="public/js/jquery-3.7.1.min.js"></script>
    <script src="public/js/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="public/js/index.js"></script>
</body>
</html>