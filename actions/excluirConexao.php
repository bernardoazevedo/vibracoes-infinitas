<?php 

session_start();

require_once('funcoes.php');
require_once('controleSessao.php');

$conexaoId = $_POST['conexaoId'];
$usuarioAtivo = getUsuarioLogado();
$usuarioAtivoId = $usuarioAtivo['id'];


// se algum campo não foi preenchido, exibe o erro
if(empty($conexaoId) || empty($usuarioAtivoId)){
    geraMensagem('Não foi possível desfazer conexão');
    echo json_encode(false);
    return;
}

$sql = "DELETE FROM Conexao
        WHERE Conexao.UsuarioOrigemID = ? AND Conexao.UsuarioDestinoID = ?";

$result = consulta($sql, [$usuarioAtivoId, $conexaoId]);

echo json_encode($result);