<?php 

session_start();

require_once('controleSessao.php');
require_once('db-connect.php');

$projetoId = $_POST['projetoId'];
$usuarioAtivo = $_SESSION['usuario'];
$usuarioAtivoId = $usuarioAtivo['id'];

$connect = mysqli_connect($hostname, $username, $password, $database); 

// se algum campo não foi preenchido, exibe o erro
if(empty($projetoId) || empty($usuarioAtivoId)){
    $mensagem['tipo'] = 'danger';
    $mensagem['texto'] = 'Não foi possível excluir esse projeto';
    $_SESSION['mensagens'][] = $mensagem;
    mysqli_close($connect);
    echo json_encode(false);
    return;
}

$sql = "DELETE 
        FROM ProjetoMusical 
        WHERE ProjetoMusical.UsuarioCriadorID = $usuarioAtivoId AND ProjetoMusical.ID = $projetoId";

mysqli_select_db($connect, "vibracoes_infinitas");
$result = mysqli_query($connect, $sql);
mysqli_close($connect);

echo json_encode($result);