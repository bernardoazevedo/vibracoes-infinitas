<?php 

session_start();

require_once('controleSessao.php');

$projetoId = $_POST['projetoId'];
$usuarioAtivo = $_SESSION['usuario'];
$usuarioAtivoId = $usuarioAtivo['id'];

// se algum campo não foi preenchido, exibe o erro
if(empty($projetoId) || empty($usuarioAtivoId)){
    geraMensagem('Não foi possível excluir esse projeto', 'danger');
    echo json_encode(false);
    return;
}

$sql = "DELETE 
        FROM ProjetoMusical 
        WHERE ProjetoMusical.UsuarioCriadorID = ? AND ProjetoMusical.ID = ?";

$result = consulta($sql, [$usuarioAtivoId, $projetoId]);

echo json_encode($result);