<?php 

session_start();

require_once('controleSessao.php');
require_once('funcoes.php');

$conexaoId = $_POST['conexaoId'];
$usuarioAtivo = $_SESSION['usuario'];
$usuarioAtivoId = $usuarioAtivo['id'];

// se algum campo não foi preenchido, exibe o erro
if(empty($conexaoId) || empty($usuarioAtivoId)){
    geraMensagem('Não foi possível se conectar com o músico');
    echo json_encode(false);
    return;
}

// não permite criar conexão com você mesmo
if($conexaoId == $usuarioAtivoId){
    echo json_encode(false);
    return;
}

$sql = "INSERT INTO Conexao(UsuarioOrigemID, UsuarioDestinoID)
        VALUES(?, ?)";

$result = consulta($sql, [$usuarioAtivoId, $conexaoId]);

echo json_encode($result);