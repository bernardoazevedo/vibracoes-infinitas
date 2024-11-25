<?php 

session_start();

require_once('../actions/controleSessao.php');
require_once('funcoes.php');
require_once('db-connect.php');

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

mysqli_select_db($connect, "vibracoes_infinitas");

$result = mysqli_query($connect, $sql);
if($result){
    registraAtividade($connect, $usuarioAtivoId, "Usuário $usuarioAtivoId se conectou com $conexaoId");
}

mysqli_close($connect);

echo json_encode($result);