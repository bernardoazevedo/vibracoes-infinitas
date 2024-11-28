<?php 
session_start();

require_once('db-connect.php');

if(isset($_POST)){
    $nomeUsuario = $_POST['nomeUsuario'];
    $senha = $_POST['senha'];

    //se algum campo não foi preenchido, exibe o erro
    if(empty($nomeUsuario) || empty($senha)){
        $mensagem['tipo'] = 'danger';
        $mensagem['texto'] = 'Todos os campos devem ser preenchidos';
        $_SESSION['mensagens'][] = $mensagem;
        mysqli_close($connect);
        header('Location: ../login.php');
    }
    else{
        //verifica se o nome de usuário está cadastrado
        $sql = "SELECT * 
                FROM Usuario 
                WHERE NomeUsuario = ?";

        $stmt = mysqli_prepare($connect, $sql);
        mysqli_stmt_bind_param($stmt, 's', $nomeUsuario);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($connect);

        if(mysqli_num_rows($resultado) > 0){
            //converte o resultado para um array associativo
            $dados = mysqli_fetch_array($resultado);

            //verifica se a senha está correta
            if(password_verify($senha, $dados['Senha'])){
                //salva na sessão os dados do usuário,
                //que ele está logado e sua última atividade
                $_SESSION['usuario']['logado'] = true;
                $_SESSION['usuario']['id'] = $dados['ID'];
                $_SESSION['usuario']['nome'] = $dados['Nome'];
                $_SESSION['usuario']['nomeUsuario'] = $dados['NomeUsuario'];
                $_SESSION['usuario']['fotoPerfil'] = $dados['FotoPerfil'];
                $_SESSION['usuario']['ultima-atividade'] = time();
                header('Location: ../index.php');
            }
            else{
                $mensagem['tipo'] = 'danger';
                $mensagem['texto'] = 'Nome de usuário ou senha inválido';
                $_SESSION['mensagens'][] = $mensagem;
                header('Location: ../login.php');
            }
        }
        else{
            $mensagem['tipo'] = 'danger';
            $mensagem['texto'] = 'Nome de usuário ou senha inválido';
            $_SESSION['mensagens'][] = $mensagem;
            header('Location: ../login.php');
        }
    }
}