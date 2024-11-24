<?php 

function limpaInput($mysqli_connect, $string){
    $sql_escaped = mysqli_escape_string($mysqli_connect, $string);
    $sql_html_escaped = htmlspecialchars($sql_escaped);

    return $sql_html_escaped;
}

require_once('db-connect.php');

session_start();

if(isset($_POST)){
    $nomeUsuario = $_POST['nomeUsuario'];
    $senha = $_POST['senha'];

    //se algum campo não foi preenchido, exibe o erro
    if(empty($nomeUsuario) || empty($senha)){
        $_SESSION['mensagem'] = 'ERRO: Todos os campos devem ser preenchidos';
        mysqli_close($connect);
        header('Location: ../../login');
    }
    else{
        //verifica se o nome de usuário está cadastrado
        $sql = "SELECT * 
                FROM Usuario 
                WHERE NomeUsuario = '$nomeUsuario'";
        $resultado = mysqli_query($connect, $sql);

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
                mysqli_close($connect);
                header('Location: ../../home');
            }
            else{
                $_SESSION['mensagem'] = 'ERRO: Nome de usuário ou senha inválido';
                mysqli_close($connect);
                header('Location: ../../login');
            }
        }
        else{
            $_SESSION['mensagem'] = 'ERRO: Nome de usuário ou senha inválido';
            mysqli_close($connect);
            header('Location: ../../login');
        }
    }
}