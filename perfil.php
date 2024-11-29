<?php 
session_start();

require_once('actions/controleSessao.php');
require_once('actions/funcoes.php');

$usuarioAtivo = $_SESSION['usuario'];
$usuarioAtivoId = $usuarioAtivo['id'];
$usuario = getMusicoPeloId($usuarioAtivoId);

$quantidadeMusicas = getQuantidadeMusicas($usuario['ID']);
$quantidadeProjetos = getQuantidadeProjetos($usuario['ID']);
$quantidadeConexoes = getQuantidadeConexoes($usuario['ID']);
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

                    </div>

                    <div class="card-body container">

                        <div class="col">
                            <div class="media align-items-end ">
                                <div class="mr-3">
                                    <img src="public/fotos/<?= $usuario['FotoPerfil'] ?>"
                                        alt="..." width="120px" height="120px" class="rounded mb-2 img-thumbnail">
                                    <a href="#" class="btn btn-outline-dark btn-sm btn-block">
                                        Edit profile
                                    </a>
                                </div>
                                <div class="media-body mb-5 ">
                                    <h4 class="mt-0 mb-0 text-truncate"><?= $usuario['Nome'] ?></h4>
                                    <p class="small mb-4 text-truncate"><?= $usuario['NomeUsuario'] ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col pt-4">
                            <div class="row">
                                <div class="col">
                                    <h5 class="font-weight-bold mb-0 d-block"><?= $quantidadeMusicas ?></h5>
                                    <small class="text-muted"> 
                                        <i class="fas fa-image mr-1"></i>Músicas
                                    </small>
                                </div>
                                <div class="col justify-content-center">
                                    <h5 class="font-weight-bold mb-0 d-block text-center">215</h5>
                                    <small class="text-muted self-align-center"> 
                                        <i class="fas fa-user mr-1"></i>Projetos
                                    </small>
                                </div>
                                <div class="col">
                                    <h5 class="font-weight-bold mb-0 d-block">215</h5>
                                    <small class="text-muted"> 
                                        <i class="fas fa-user mr-1"></i>Conexões
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="px-4 py-3">
                            <h5 class="mb-0">Descrição</h5>
                            <div class="p-4 rounded shadow-sm bg-light">
                                <p class="font-italic mb-0"><?= $usuario['Descricao'] ?></p>
                            </div>
                        </div>

                    </div>

                    <div class="card-footer">
                        
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