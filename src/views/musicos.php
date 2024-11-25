<?php 
session_start();

require_once(__DIR__.'/../actions/controleSessao.php');
require_once(__DIR__.'/../actions/funcoes.php');
require_once(__DIR__.'/../actions/db-connect.php');

$usuarioAtivo = $_SESSION['usuario'];
$usuarioAtivoId = $usuarioAtivo['id'];

$conexoes = getConexoes($connect, $usuarioAtivoId);
$musicos = getMusicos($connect);

mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Músicos | Vibrações Infinitas</title>

    <link rel="stylesheet" href="../../public/css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../../public/css/adminlte.min.css">
    <link rel="stylesheet" href="../../public/css/style.css">
</head>
<body>
    <?php require_once('layout/navbar.php'); ?>

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

        <div class="card col-8">
            <div class="card-header">
                Músicos cadastrados
            </div>
            <div class="card-body">
                <?php if(count($musicos)): ?>
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Foto de perfil</th>
                                <th scope="col">Nome</th>
                                <th scope="col">Nome de usuário</th>
                                <th scope="col">Descrição</th>
                                <th scope="col">Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($musicos as $musico): ?>
                            <tr>
                                <td><?= $musico['FotoPerfil'] ?></td>
                                <td><?= $musico['Nome'] ?></td>
                                <td><?= $musico['NomeUsuario'] ?></td>
                                <td><?= $musico['Descricao'] ?></td>
                                <td>
                                    <button class="btn btn-outline-primary btn-sm btn-conectar" value="<?= $musico['ID'] ?>">Conectar</button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>Ainda não existe nenhum músico cadastrado</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="card col-8">
            <div class="card-header">
                Suas conexões
            </div>
            <div class="card-body">
                <?php if($conexoes): ?>
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Foto de perfil</th>
                                <th scope="col">Nome</th>
                                <th scope="col">Nome de usuário</th>
                                <th scope="col">Descrição</th>
                                <th scope="col">Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($conexoes as $conexao): ?>
                            <tr>
                                <td><?= $conexao['FotoPerfil'] ?></td>
                                <td><?= $conexao['Nome'] ?></td>
                                <td><?= $conexao['NomeUsuario'] ?></td>
                                <td><?= $conexao['Descricao'] ?></td>
                                <td>
                                    <button class="btn btn-outline-primary btn-sm btn-desconectar" value="<?= $conexao['UsuarioDestinoID'] ?>">Desconectar</button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>Você ainda não fez nenhuma conexão</p>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <script src="https://kit.fontawesome.com/df3ed30ad5.js" crossorigin="anonymous"></script>
    <!-- jQuery -->
    <script src="../../public/js/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap -->
    <script src="../../public/js/bootstrap/bootstrap.min.js"></script>
    <script src="../../public/js/index.js"></script>
</body>
</html>