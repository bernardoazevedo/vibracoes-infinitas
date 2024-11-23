<?php 

function limpaInput($mysqli_connect, $string){
    $sql_escaped = mysqli_escape_string($mysqli_connect, $string);
    $sql_html_escaped = htmlspecialchars($sql_escaped);

    return $sql_html_escaped;
}

require_once('db-connect.php');

session_start();

if(isset($_POST)){
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    //se algum campo não foi preenchido, exibe o erro
    if(empty($email) || empty($senha)){
        $_SESSION['mensagem-login'] = 'ERRO: Todos os campos devem ser preenchidos';
        mysqli_close($connect);
        header('Location: ../entrar.php');
    }
    else{
        //verifica se o e-mail está cadastrado
        $email = limpaInput($connect, $email);
        $sql = "SELECT * 
                FROM Usuarios 
                WHERE email = '$email'";
        $resultado = mysqli_query($connect, $sql);

        if(mysqli_num_rows($resultado) > 0){
            //converte o resultado para um array associativo
            $dados = mysqli_fetch_array($resultado);

            //verifica se a senha está correta
            if(password_verify($senha, $dados['senha'])){
                //salva na sessão os dados do usuário,
                //que ele está logado e sua última atividade
                $_SESSION['logado'] = true;
                $_SESSION['id_usuario'] = $dados['id'];
                $_SESSION['nome_usuario'] = $dados['nome'];
                $_SESSION['sobrenome_usuario'] = $dados['sobrenome'];
                $_SESSION['email_usuario'] = $dados['email'];
                $_SESSION['ultima-atividade'] = time();
                mysqli_close($connect);
                header('Location: ../usuarios.php');
            }
            else{
                $_SESSION['mensagem-login'] = 'ERRO: E-mail ou senha inválido';
                mysqli_close($connect);
                header('Location: ../entrar.php');
            }
        }
        else{
            $_SESSION['mensagem-login'] = 'ERRO: E-mail ou senha inválido';
            mysqli_close($connect);
            header('Location: ../entrar.php');
        }
    }
}