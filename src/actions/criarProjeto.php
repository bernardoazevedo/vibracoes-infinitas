<?php 

session_start();

require_once('db-connect.php');


$nomeProjeto = $_POST['nomeProjeto'];
$descricaoProjeto = $_POST['descricaoProjeto'];
$musicos = $_POST['musicos'];
$usuarioAtivo = $_SESSION['usuario'];
$usuarioAtivoId = $usuarioAtivo['id'];

$sql = "INSERT INTO ProjetoMusical(Nome, Descricao, UsuarioCriadorID)
        VALUES('$nomeProjeto', '$descricaoProjeto', $usuarioAtivoId)";

mysqli_select_db($connect, "vibracoes_infinitas");
$result = mysqli_query($connect, $sql);
$projetoId = mysqli_insert_id($connect);

// se o projeto tiver sido criado com sucesso, cadastra os membros
if($result){
    
    if(count($musicos)){
        
        foreach($musicos as $musico){
            $sql = "INSERT INTO MembroProjeto(ProjetoID, UsuarioID)
                    VALUES($projetoId, $musico)";
            $result = mysqli_query($connect, $sql);
        }
        
        
        if($result){
            mysqli_close($connect);
            $_SESSION['mensagem'] = 'Projeto criado com sucesso';
            header('Location: ../../home');    
        }
        else{
            mysqli_close($connect);
            $_SESSION['mensagem'] = 'Erro ao cadastrar membros do projeto, tente novamente';
            header('Location: ../../home');    
        }
    }
}
else{
    mysqli_close($connect);
    $_SESSION['mensagem'] = 'Erro ao criar projeto, tente novamente';
    header('Location: ../../home');
}
