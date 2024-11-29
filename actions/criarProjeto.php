<?php 

session_start();

require_once('controleSessao.php');
require_once('funcoes.php');
require_once('db-connect.php');

$nomeProjeto = trim($_POST['nomeProjeto']);
$descricaoProjeto = trim($_POST['descricaoProjeto']);
$musicos = $_POST['musicos'];
$usuarioAtivo = $_SESSION['usuario'];
$usuarioAtivoId = $usuarioAtivo['id'];

//se algum campo não foi preenchido, exibe o erro
if(empty($nomeProjeto) || empty($descricaoProjeto)){
    geraMensagem('Todo projeto precisa ter um nome e uma descrição', 'danger');
    header('Location: ../projetos.php');
    die();
}

try{
    $connect = new PDO("mysql:host=$hostname;dbname=$database", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
}
catch(Exception $e){
    geraMensagem('Erro ao conectar: '.$e->getMessage(), 'danger');
}

try{
    $connect->beginTransaction();

    // registra o projeto no banco de dados
    $sql_projeto = "INSERT INTO ProjetoMusical(Nome, Descricao, UsuarioCriadorID)
            VALUES(:nomeProjeto, :descricaoProjeto,:usuarioAtivoId)";

    $stmt = $connect->prepare($sql_projeto);

    $stmt->bindParam(':nomeProjeto', $nomeProjeto);
    $stmt->bindParam(':descricaoProjeto', $descricaoProjeto);
    $stmt->bindParam(':usuarioAtivoId', $usuarioAtivoId);
    
    $stmt->execute();
    $projetoId = $connect->lastInsertId();

    if($musicos){
        $quantidade = count($musicos);

        // constrói a query para inserir os membros do projeto
        $sql_membros = "INSERT INTO MembroProjeto(ProjetoID, UsuarioID) VALUES";
        for($i=0; $i < $quantidade; $i++){
            $sql_membros .= " (:projeto, :musico$i),";
        }
        $sql_membros = substr($sql_membros, 0, (strlen($sql_membros)-1));

        $stmt = $connect->prepare($sql_membros);
        
        $stmt->bindParam(":projeto", $projetoId);
        for($i=0; $i < $quantidade; $i++){
            $stmt->bindParam(":musico$i", $musicos[$i]);
        }

        $stmt->execute();
    }

    // registra a atividade para exibir no feed
    $sql_atividade = "INSERT INTO FeedAtividades(UsuarioID, ProjetoID)
                      VALUES(:usuarioId, :projetoId)";
    $stmt = $connect->prepare($sql_atividade);
    $stmt->bindParam(':usuarioId', $usuarioAtivoId);
    $stmt->bindParam(':projetoId', $projetoId);

    $stmt->execute();

    geraMensagem('Projeto criado com sucesso', 'success');
}
catch(Exception $e){
    $connect->rollback();
    geraMensagem('Erro ao realizar operação: '.$e->getMessage(), 'danger');
}

$connect->commit();

header('Location: ../projetos.php');
