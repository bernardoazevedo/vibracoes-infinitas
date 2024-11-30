<?php 
session_start();

require_once('funcoes.php');

if(isset($_POST)){
    $nomeUsuario = $_POST['nomeUsuario'];
    $senha = $_POST['senha'];
    
    //se algum campo não foi preenchido, exibe o erro
    if(empty($nomeUsuario) || empty($senha)){
        geraMensagem('Todos os campos devem ser preenchidos', 'danger');
        header('Location: ../login.php');
    }
    else{
        //verifica se o nome de usuário está cadastrado
        $sql = "SELECT * 
                FROM Usuario 
                WHERE NomeUsuario = ?";
        $usuario = consulta($sql, [$nomeUsuario])[0];

        if($usuario){
            //verifica se a senha está correta
            if(password_verify($senha, $usuario['Senha'])){
                //salva na sessão os dados do usuário,
                //que ele está logado e sua última atividade
                $_SESSION['usuario']['logado'] = true;
                $_SESSION['usuario']['id'] = $usuario['ID'];
                $_SESSION['usuario']['nome'] = $usuario['Nome'];
                $_SESSION['usuario']['nomeUsuario'] = $usuario['NomeUsuario'];
                $_SESSION['usuario']['fotoPerfil'] = $usuario['FotoPerfil'];
                $_SESSION['usuario']['ultima-atividade'] = time();
                header('Location: ../index.php');
            }
            else{
                geraMensagem('Nome de usuário ou senha inválido', 'danger');
                header('Location: ../login.php');
            }
        }
        else{
            geraMensagem('Nome de usuário ou senha inválido', 'danger');
            header('Location: ../login.php');
        }
    }
}