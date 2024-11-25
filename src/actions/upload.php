<?php

session_start();

require_once('controleSessao.php');
require_once('db-connect.php');

function formatoValido($extensao){
    $formatosValidos = [
        'mp3'
    ];

    //verifica se o formato do arquivo é permitido
    return in_array($extensao, $formatosValidos);
}

function upload($nome, $nomeTemporario, $pasta){
    $novoNome = $nome;

    //tenta mover o arquivo para a pasta
    return move_uploaded_file($nomeTemporario, $pasta.$novoNome);
}

$pasta_destino = __DIR__."/../../public/musicas/";
$extensaoArquivo = pathinfo($_FILES['musica']['name'],PATHINFO_EXTENSION);
$novoNome = trim($_POST['nomeMusica']);
$genero = trim($_POST['generoMusica']) ?? 'samba';
$arquivo_destino = $pasta_destino."$novoNome.$extensaoArquivo";

$uploadOk = 1;

$usuarioAtivo = $_SESSION['usuario'];
$usuarioAtivoId = $usuarioAtivo['id'];

// Verifica se o áudio já existe
if (file_exists($arquivo_destino)) {
    $mensagem['texto'] = "Já existe uma música cadastrada com o nome". basename($novoNome) .".";
    $mensagem['tipo'] = "danger";
    $uploadOk = 0;
}

// Verifica o tamanho do arquivo em bytes
if ($_FILES["musica"]["size"] > 10000000) {
    $mensagem['titulo'] = "Arquivo muito grande";
    $mensagem['texto'] = "Essa música é muito grande.";
    $mensagem['tipo'] = "danger";
    $uploadOk = 0;
}

// Permite apenas os formatos: .wav, .mp3, .wma, and .mp4
if( ! formatoValido($extensaoArquivo)) {
    $mensagem['texto'] = "Apenas o formato mp3 é permitido";
    $mensagem['tipo'] = "danger";
    $uploadOk = 0;
}

// Se estiver tudo ok, salva na pasta
if($uploadOk) {
    if(upload("$novoNome.$extensaoArquivo", $_FILES['musica']['tmp_name'], $pasta_destino)){
    // if (move_uploaded_file($_FILES["musica"]["tmp_name"], $target_file)) {
        $mensagem['texto'] = "A música ". $novoNome. " foi cadastrada com sucesso.";
        $mensagem['tipo'] = "success";
    } 
    else {
        $mensagem['texto'] = "Ocorreu um erro ao cadastrar música.";
        $mensagem['tipo'] = "danger";
    }
}


$sql = "INSERT INTO Musica(Titulo, Genero, Artista, NomeArquivo)
        VALUES(?, ?, ?, ?)";

if ($stmt = mysqli_prepare($connect, $sql)) {
    mysqli_stmt_bind_param($stmt, "ssis", $novoNome, $genero, $usuarioAtivoId, $novoNome);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $result);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
}


$_SESSION['mensagens'][] = $mensagem;
header('Location: ../views/home.php');