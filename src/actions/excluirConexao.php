<?php 

session_start();

require_once('../actions/controleSessao.php');
require_once('db-connect.php');

$conexaoId = $_POST['conexaoId'];
$usuarioAtivo = $_SESSION['usuario'];
$usuarioAtivoId = $usuarioAtivo['id'];


// se algum campo não foi preenchido, exibe o erro
if(empty($conexaoId) || empty($usuarioAtivoId)){
    $mensagem['tipo'] = 'danger';
    $mensagem['texto'] = 'Não foi possível desfazer conexão';
    $_SESSION['mensagens'][] = $mensagem;
    mysqli_close($connect);
    echo json_encode(false);
    return;
}

$sql = "DELETE FROM Conexao
        WHERE Conexao.UsuarioOrigemID = $usuarioAtivoId AND Conexao.UsuarioDestinoID = $conexaoId";

mysqli_select_db($connect, "vibracoes_infinitas");
$result = mysqli_query($connect, $sql);
mysqli_close($connect);

echo json_encode($result);