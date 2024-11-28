<?php

session_start();

require_once('controleSessao.php');
require_once('db-connect.php');
require_once('funcoes.php');

function formatoValido($extensao){
    $formatosValidos = [
        'mp3'
    ];

    //verifica se o formato do arquivo é permitido
    return in_array($extensao, $formatosValidos);
}

function upload($novoNome, $nomeTemporario, $pasta){
    //tenta mover o arquivo para a pasta
    return move_uploaded_file($nomeTemporario, $pasta.$novoNome);
}

$pasta_destino = "../public/musicas/";

$extensaoArquivo = pathinfo($_FILES['musica']['name'],PATHINFO_EXTENSION);
$nomeMusica = trim($_POST['nomeMusica']);
$genero = trim($_POST['generoMusica']);

$arquivo_destino = $pasta_destino."$novoNome.$extensaoArquivo";
$nomeArmazenado = uniqid().".$extensaoArquivo";

$uploadOk = 1;

$usuarioAtivo = $_SESSION['usuario'];
$usuarioAtivoId = $usuarioAtivo['id'];

if(empty($nomeMusica)){
    $mensagem['texto'] = "Você deve preencher o nome da música";
    $mensagem['tipo'] = "danger";
    $uploadOk = 0;
}

if(empty($genero)){
    $mensagem['texto'] = "Você deve preencher o gênero da música";
    $mensagem['tipo'] = "danger";
    $uploadOk = 0;
}

if(empty($_FILES['musica']['name'])){
    $mensagem['texto'] = "Você deve enviar uma música";
    $mensagem['tipo'] = "danger";
    $uploadOk = 0;
}
else{
    // Verifica se o áudio já existe
    if (file_exists($arquivo_destino)) {
        $mensagem['texto'] = "Já existe uma música cadastrada com o nome '". basename($nomeMusica) ."'";
        $mensagem['tipo'] = "danger";
        $uploadOk = 0;
    }

    // Verifica o tamanho do arquivo em bytes
    if ($_FILES["musica"]["size"] > 10000000) {
        $mensagem['texto'] = "Essa música é muito grande";
        $mensagem['tipo'] = "danger";
        $uploadOk = 0;
    }

    // Permite apenas o formato mp3
    if( ! formatoValido($extensaoArquivo)) {
        $mensagem['texto'] = "Apenas o formato mp3 é permitido";
        $mensagem['tipo'] = "danger";
        $uploadOk = 0;
    }
}

// Se estiver tudo ok, salva na pasta
if($uploadOk) {
    if(upload($nomeArmazenado, $_FILES['musica']['tmp_name'], $pasta_destino)){
        
        $sql = "INSERT INTO Musica(Titulo, Genero, Artista, NomeArquivo)
                VALUES(?, ?, ?, ?)";
        
        if($stmt = mysqli_prepare($connect, $sql)) {
            mysqli_stmt_bind_param($stmt, "ssis", $nomeMusica, $genero, $usuarioAtivoId, $nomeArmazenado);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }

        $musicaId = mysqli_insert_id($connect);
        registraAtividadeMusica($usuarioAtivoId, $musicaId);

        $mensagem['texto'] = "A música '$nomeMusica' foi cadastrada com sucesso";
        $mensagem['tipo'] = "success";
    } 
    else {
        $mensagem['texto'] = "Ocorreu um erro ao cadastrar música";
        $mensagem['tipo'] = "danger";
    }    
}

mysqli_close($connect);

$_SESSION['mensagens'][] = $mensagem;
header('Location: ../index.php');