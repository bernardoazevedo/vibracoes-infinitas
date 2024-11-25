<?php 

session_start();

require_once(__DIR__.'/controleSessao.php');
require_once(__DIR__.'/funcoes.php');
require_once(__DIR__.'/db-connect.php');

$nomeProjeto = $_POST['nomeProjeto'];
$descricaoProjeto = $_POST['descricaoProjeto'];
$musicos = $_POST['musicos'];
$usuarioAtivo = $_SESSION['usuario'];
$usuarioAtivoId = $usuarioAtivo['id'];

//se algum campo não foi preenchido, exibe o erro
if(empty($nomeProjeto) || empty($descricaoProjeto)){
    $mensagem['tipo'] = 'danger';
    $mensagem['texto'] = 'Todo projeto precisa ter um nome e uma descrição';
    $_SESSION['mensagens'][] = $mensagem;
    mysqli_close($connect);
    header('Location: ../views/home.php');
    die();
}

$sql = "INSERT INTO ProjetoMusical(Nome, Descricao, UsuarioCriadorID)
        VALUES('$nomeProjeto', '$descricaoProjeto', $usuarioAtivoId)";

$result = mysqli_query($connect, $sql);
$projetoId = mysqli_insert_id($connect);

// se o projeto tiver sido criado com sucesso, cadastra os membros
if($result){
    registraAtividade($connect, $usuarioAtivoId, "Usuário $usuarioAtivoId criou um novo projeto chamado $nomeProjeto");

    if($musicos){
        // constrói a query para inserir os membros do projeto
        $sql = "INSERT INTO MembroProjeto(ProjetoID, UsuarioID)
                VALUES";
        foreach($musicos as $musico){
            $sql .= " ($projetoId, $musico),";
        }
        $sql = substr($sql, 0, (strlen($sql)-1));
        $result = mysqli_query($connect, $sql);

        if($result){
            mysqli_close($connect);
            $mensagem['tipo'] = 'success';
            $mensagem['texto'] = 'Projeto criado com sucesso';
            $_SESSION['mensagens'][] = $mensagem;
            header('Location: ../views/home.php');
            die();    
        }
        else{
            mysqli_close($connect);
            $mensagem['tipo'] = 'danger';
            $mensagem['texto'] = 'Erro ao cadastrar membros do projeto, tente novamente';
            $_SESSION['mensagens'][] = $mensagem;
            header('Location: ../views/home.php');
            die();    
        }
    }
}
else{
    mysqli_close($connect);
    $mensagem['tipo'] = 'danger';
    $mensagem['texto'] = 'Erro ao criar projeto, tente novamente';
    $_SESSION['mensagens'][] = $mensagem;
    header('Location: ../views/home.php');
    die();
}

header('Location: ../views/home.php');
