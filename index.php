<?php 
session_start();

require_once('actions/funcoes.php');
require_once('actions/controleSessao.php');

$usuarioAtivo = getUsuarioLogado();
$usuarioAtivoId = $usuarioAtivo['id'];

$conexoes = getConexoes($usuarioAtivoId);
$musicos = getMusicos();
$musicosConexoes = getMusicosConexoes($usuarioAtivoId);

$atividades = getAtividadesDasConexoes($usuarioAtivoId);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feed | Vibrações Infinitas</title>

    <link rel="stylesheet" href="public/css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="public/css/adminlte.min.css">
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
    <?php require_once('layout/navbar.php'); ?>
    <div>
        <div class="row align-items-start">
            <?php require_once('layout/barraEsquerda.php'); ?>
            <div class="col-lg-6 mt-3">
                <main class="container">
                    <?php require_once('layout/mensagens.php'); ?>
                <!-- Conteúdo da página aqui -->

                    <h3 class="">Atividades</h3>
                    <?php 
                        if($atividades):
                            foreach($atividades as $atividade): 
                                $dataAtividade = new DateTime($atividade['DataAtividade']);
                                $data = $dataAtividade->format('H:i - d/m/Y');

                                if($atividade['MusicaID']): 
                                    $musica = getMusicaPeloId($atividade['MusicaID']); 
                                    $usuario = getMusicoPeloId($atividade['UsuarioID']); 
                                    require('layout/exibeMusica.php');

                                elseif($atividade['ProjetoID']): 
                                    $projeto = getProjetoParticipantesPeloId($atividade['ProjetoID']);
                                    require('layout/exibeProjeto.php');
                                
                                endif; 
                            endforeach;

                        else: ?>
                        <div class="card">
                            <div class="card-body">
                                Quando você se conectar com algum músico, suas atividades aparecerão aqui
                            </div>
                        </div>
                    <?php endif; ?>

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