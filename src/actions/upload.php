<?php

session_start();

function formatoValido($extensao){
    $formatosValidos = [
        'wav',
        'mp3',
        'wma',
        'mp4',
    ];

    //verifica se o formato do arquivo é permitido
    return in_array($extensao, $formatosValidos);
}

function upload($nome, $nomeTemporario, $pasta){
    $novoNome = $nome;

    //tenta mover o arquivo para a pasta
    return move_uploaded_file($nomeTemporario, $pasta.$novoNome);
}

$pasta_destino = __DIR__."/../musicas/";
$extensaoArquivo = pathinfo($_FILES['musica']['name'],PATHINFO_EXTENSION);
$novoNome = trim($_POST['nomeMusica']);
$arquivo_destino = $pasta_destino."$novoNome.$extensaoArquivo";
$uploadOk = 1;

// Verifica se o áudio já existe
if (file_exists($arquivo_destino)) {
    $mensagem['titulo'] = "Música já cadastrada";
    $mensagem['texto'] = "ERRO: já existe uma música cadastrada com o nome". basename($novoNome) .".";
    $mensagem['tipo'] = "danger";
    $uploadOk = 0;
}

// Verifica o tamanho do arquivo em bytes
if ($_FILES["musica"]["size"] > 10000000) {
    $mensagem['titulo'] = "Arquivo muito grande";
    $mensagem['texto'] = "ERRO: essa música é muito grande.";
    $mensagem['tipo'] = "danger";
    $uploadOk = 0;
}

// Permite apenas os formatos: .wav, .mp3, .wma, and .mp4
if( ! formatoValido($extensaoArquivo)) {
    $mensagem['titulo'] = "Formato não permitido";
    $mensagem['texto'] = "ERRO: apenas os seguintes formatos são permitidos: wav, mp3, wma & mp4.";
    $mensagem['tipo'] = "danger";
    $uploadOk = 0;
}

// Se estiver tudo ok, salva na pasta
if($uploadOk) {
    if(upload("$novoNome.$extensaoArquivo", $_FILES['musica']['tmp_name'], $pasta_destino)){
    // if (move_uploaded_file($_FILES["musica"]["tmp_name"], $target_file)) {
        $mensagem['titulo'] = "Música cadastrada";
        $mensagem['texto'] = "A música ". $novoNome. " foi cadastrada com sucesso.";
        $mensagem['tipo'] = "success";
    } 
    else {
        $mensagem['titulo'] = "Erro ao cadastrar";
        $mensagem['texto'] = "ERRO: ocorreu um erro ao cadastrar música.";
        $mensagem['tipo'] = "danger";
    }
}

$_SESSION['mensagens'][] = $mensagem;
header('Location: ../index.php');