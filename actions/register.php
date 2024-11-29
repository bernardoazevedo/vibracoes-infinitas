<?php 

function contemNumero($string){
    return is_numeric(filter_var($string, FILTER_SANITIZE_NUMBER_INT));
}

function verificaNome($string){
    $string = trim($string);

    if(empty($string)){
        return false;
    }
    if(contemNumero($string)){
        return false;
    }
    return $string;
}

function verificaEmail($email){
    $email = trim($email);

    if(empty($email)){
        return false;
    }

    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
        return $email;
    }

    return false;
}

function verificaSenha($senha){
    if(strlen($senha) < 8){
        return false;
    }

    return $senha;
}

function limpaInput($mysqli_connect, $string){
    $sql_escaped = mysqli_escape_string($mysqli_connect, $string);
    $sql_html_escaped = htmlspecialchars($sql_escaped);

    return $sql_html_escaped;
}


function formatoValido($extensao){
    $formatosValidos = [
        'jpg',
        'jpeg',
        'png'
    ];

    //verifica se o formato do arquivo é permitido
    return in_array($extensao, $formatosValidos);
}

function uploadFoto($nome, $nomeTemporario, $pasta){
    $extensao = pathinfo($nome, PATHINFO_EXTENSION);

    $arquivos = scandir($pasta);
    //se já existe um arquivo com esse nome, adiciona (1) ao fim do nome
    if(in_array($nome, $arquivos)){
        $nome = str_replace('.'.$extensao, '', $nome);
        $novoNome = $nome.'(1).'.$extensao;
    }
    //se não existe, o nome continua o mesmo
    else{
        $novoNome = $nome;
    }

    //tenta mover o arquivo para a pasta
    if(move_uploaded_file($nomeTemporario, $pasta.$novoNome)){
        return $novoNome;
    }
    else{
        return false;
    }
}



require_once('db-connect.php');
require_once('funcoes.php');

session_start();

if(isset($_POST)){
    $nome = verificaNome($_POST['nome']);
    $nomeUsuario = verificaNome($_POST['nomeUsuario']);
    $descricao = $_POST['descricao'];
    $senha = verificaSenha($_POST['senha']);
    $confirmaSenha = verificaSenha($_POST['confirma-senha']);
    
    $foto = $_FILES['fotoPerfil'];
    $extensaoFoto = pathinfo($foto['name'], PATHINFO_EXTENSION);
    $nomeTempArquivo = $foto['tmp_name'];
    $novoNome = uniqid().".$extensaoFoto";

    $connect = mysqli_connect($hostname, $username, $password, $database); 

    //verifica se o formato da foto é aceito
    if(!formatoValido($extensaoFoto)){
        $mensagem['tipo'] = 'danger';
        $mensagem['texto'] = "Formato de arquivo ($extensaoFoto) inválido";
        $_SESSION['mensagens'][] = $mensagem;
        mysqli_close($connect);
        header('Location: ../register.php');
        die();
    }

    //se algum campo não foi preenchido, exibe o erro
    if(empty($nome) || empty($nomeUsuario) || empty($foto) || empty($descricao) || empty($senha) || empty($confirmaSenha)){
        $mensagem['tipo'] = 'danger';
        $mensagem['texto'] = 'Você deve preencher todos os campos';
        $_SESSION['mensagens'][] = $mensagem;
        mysqli_close($connect);
        header('Location: ../register.php');
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
            $mensagem['tipo'] = 'danger';
            $mensagem['texto'] = 'Esse nome de usuário já é usado em outra conta';
            $_SESSION['mensagens'][] = $mensagem;
            mysqli_close($connect);
            header('Location: ../register.php');
            die();
        }
        else{
            if($senha == $confirmaSenha){       
                $nome = limpaInput($connect, $nome);
                $nomeUsuario = limpaInput($connect, $nomeUsuario);
                $senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);

                $nomeFoto = uploadFoto($novoNome, $nomeTempArquivo, '../public/fotos/');

                if(! $nomeFoto){
                    $mensagem['tipo'] = 'danger';
                    $mensagem['texto'] = "Não foi possível fazer o upload da foto";
                    $_SESSION['mensagens'][] = $mensagem;
                    
                    mysqli_close($connect);
                    header('Location: ../login.php');
                    die();
                }

                $sql = "INSERT INTO Usuario (Nome, NomeUsuario, Senha, FotoPerfil, Descricao)
                        VALUES (?, ?, ?, ?, ?)";

                $stmt = mysqli_prepare($connect, $sql);
                mysqli_stmt_bind_param($stmt, 'sssss', $nome, $nomeUsuario, $senhaCriptografada, $nomeFoto, $descricao);
                mysqli_stmt_execute($stmt);
                $resultado = mysqli_stmt_get_result($stmt);
            
                mysqli_stmt_close($stmt);
                mysqli_close($connect);
                header('Location: ../login.php');
                die();
            }
            else{
                $mensagem['tipo'] = 'danger';
                $mensagem['texto'] = 'As senhas não conferem';
                $_SESSION['mensagens'][] = $mensagem;
                mysqli_close($connect);
                header('Location: ../register.php');
                die();
            }
        }
    }
}