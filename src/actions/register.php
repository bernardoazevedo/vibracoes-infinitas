<?php 

function contemNumero($string){
    return is_numeric(filter_var($string, FILTER_SANITIZE_NUMBER_INT));
}

function verificaNome($string){
    $string = trim($string);

    if(empty($string)){
        $_SESSION['mensagem'] = 'ERRO: Nome não preenchido';
        return false;
    }
    if(contemNumero($string)){
        $_SESSION['mensagem'] = 'ERRO: O nome não pode conter números';
        return false;
    }
    return $string;
}

function verificaEmail($email){
    $email = trim($email);

    if(empty($email)){
        $_SESSION['mensagem'] = 'ERRO: E-mail não preenchido';
        return false;
    }

    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
        return $email;
    }

    $_SESSION['mensagem'] = 'ERRO: E-mail inválido';
    return false;
}

function verificaSenha($senha){
    if(strlen($senha) < 8){
        $_SESSION['mensagem'] = 'ERRO: A senha deve possuir ao menos 8 caracteres';
        return false;
    }

    return $senha;
}

function limpaInput($mysqli_connect, $string){
    $sql_escaped = mysqli_escape_string($mysqli_connect, $string);
    $sql_html_escaped = htmlspecialchars($sql_escaped);

    return $sql_html_escaped;
}


require_once('db-connect.php');

session_start();

if(isset($_POST)){
    $nome = verificaNome($_POST['nome']);
    $nomeUsuario = verificaNome($_POST['nomeUsuario']);
    $senha = verificaSenha($_POST['senha']);
    $confirmaSenha = verificaSenha($_POST['confirma-senha']);

    //se algum campo não foi preenchido, exibe o erro
    if(empty($nome) || empty($nomeUsuario) || empty($senha) || empty($confirmaSenha)){
        mysqli_close($connect);
        header('Location: ../../register');
        die();
    }
    else{  
        //verifica se o nome de usuário já é usado por outra conta
        $nomeUsuario = limpaInput($connect, $nomeUsuario);
        $sql = "SELECT nomeUsuario 
                FROM Usuario 
                WHERE nomeUsuario = '$nomeUsuario'";
        $resultado = mysqli_query($connect, $sql);

        if(mysqli_num_rows($resultado) > 0){
            $_SESSION['mensagem'] = 'ERRO: Esse nome de usuário já é usado em outra conta';
            mysqli_close($connect);
            header('Location: ../../register');
            die();
        }
        else{
            if($senha == $confirmaSenha){       
                $nome = limpaInput($connect, $nome);
                $nomeUsuario = limpaInput($connect, $nomeUsuario);
                $senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);

                $sql = "INSERT INTO Usuario (nome, nomeUsuario, senha)
                        VALUES ('$nome', '$nomeUsuario', '$senhaCriptografada')";
                $resultado = mysqli_query($connect, $sql);

                mysqli_close($connect);
                header('Location: ../../login');
                die();
            }
            else{
                $_SESSION['mensagem'] = 'ERRO: As senhas não conferem';
                mysqli_close($connect);
                header('Location: ../../register');
                die();
            }
        }
    }
}