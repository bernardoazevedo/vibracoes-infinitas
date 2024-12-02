<?php

session_start();

require_once('funcoes.php');
require_once('controleSessao.php');
require_once('db-connect.php');

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

$extensaoArquivo = pathinfo($_FILES['musica']['name'], PATHINFO_EXTENSION);
$nomeMusica = trim($_POST['nomeMusica']);
$genero = trim($_POST['generoMusica']);

$nomeArmazenado = uniqid().".$extensaoArquivo";
$arquivo_destino = $pasta_destino.$nomeArmazenado;

$usuarioAtivo = getUsuarioLogado();
$usuarioAtivoId = $usuarioAtivo['id'];

$uploadOk = 1;

if(empty($nomeMusica) || empty($genero) || empty($_FILES['musica']['name'])){
    geraMensagem("Você deve inserir nome, gênero e selecionar a música", 'danger');
    $uploadOk = 0;
}
else{
    // Verifica se o nome gerado já existe, para não sobrescrever outra música
    if (file_exists($arquivo_destino)) {
        geraMensagem("Erro ao cadastrar música, tente novamente", 'danger');
        $uploadOk = 0;
    }

    // Verifica o tamanho do arquivo em bytes
    if ($_FILES["musica"]["size"] > 10000000) {
        geraMensagem('Essa música é muito grande', 'danger');
        $uploadOk = 0;
    }

    // Permite apenas o formato mp3
    if( ! formatoValido($extensaoArquivo)) {
        geraMensagem('Apenas o formato mp3 é permitido', 'danger');
        $uploadOk = 0;
    }
}

// Se estiver tudo ok, salva na pasta e registra as informações no banco
if($uploadOk) {

    // salva a imagem na pasta
    try{
        $resultUpload = upload($nomeArmazenado, $_FILES['musica']['tmp_name'], $pasta_destino);
    }
    catch(Exception $e){
        geraMensagem('Erro ao salvar arquivo: '.$e->getMessage(), 'danger');
    }

    // se conecta com o banco de dados
    try{
        $connect = new PDO("mysql:host=$hostname;dbname=$database", $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }
    catch(Exception $e){
        geraMensagem('Erro ao conectar: '.$e->getMessage(), 'danger');
    }

    try{
        if($resultUpload){
            
            // inicia a transação
            $connect->beginTransaction();

            // registra a imagem no banco de dados
            $sql_musica = "INSERT INTO Musica(Titulo, Genero, Artista, NomeArquivo)
                           VALUES(?, ?, ?, ?)";
            $stmt = $connect->prepare($sql_musica);
            $stmt->bindParam(1, $nomeMusica);
            $stmt->bindParam(2, $genero);
            $stmt->bindParam(3, $usuarioAtivoId);
            $stmt->bindParam(4, $nomeArmazenado);
            $stmt->execute();
            $musicaId = $connect->lastInsertId();


            // registra a atividade
            $sql_atividade = "INSERT INTO FeedAtividades(UsuarioID, MusicaID)
                              VALUES(?, ?)";
            $stmt = $connect->prepare($sql_atividade);
            $stmt->bindParam(1, $usuarioAtivoId);
            $stmt->bindParam(2, $musicaId);
            $stmt->execute();

            $connect->commit();

            geraMensagem("A música '$nomeMusica' foi cadastrada com sucesso", 'success');
        } 
        else {
            geraMensagem("Ocorreu um erro ao cadastrar música, tente novamente", 'danger');
        }            
    }
    catch(Exception $e){
        // faz o rollback e exclui a música que havia sido salva
        $connect->rollback();
        unlink("../public/musicas/$nomeArmazenado");
        geraMensagem('Erro ao cadastrar música: '.$e->getMessage(), 'danger');
    }
}


header('Location: ../musicas.php');