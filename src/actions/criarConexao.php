<?php 

session_start();

require_once(__DIR__.'/controleSessao.php');
require_once(__DIR__.'/funcoes.php');
require_once(__DIR__.'/db-connect.php');

$conexaoId = $_POST['conexaoId'];
$usuarioAtivo = $_SESSION['usuario'];
$usuarioAtivoId = $usuarioAtivo['id'];

$mensagem = '';

// se algum campo não foi preenchido, exibe o erro
if(empty($conexaoId) || empty($usuarioAtivoId)){
    $mensagem['tipo'] = 'danger';
    $mensagem['texto'] = 'Não foi possível se conectar com o músico';
    $_SESSION['mensagens'][] = $mensagem;
    mysqli_close($connect);
    echo json_encode(false);
    return;
}

// não permite criar conexão com você mesmo
if($conexaoId == $usuarioAtivoId){
    mysqli_close($connect);
    echo json_encode(false);
    return;
}

$sql = "INSERT INTO Conexao(UsuarioOrigemID, UsuarioDestinoID)
        VALUES('$usuarioAtivoId', '$conexaoId')";

$result = mysqli_query($connect, $sql);
if($result){
    registraAtividade($connect, $usuarioAtivoId, "Usuário $usuarioAtivoId se conectou com $conexaoId");
}

mysqli_close($connect);

echo json_encode($result);