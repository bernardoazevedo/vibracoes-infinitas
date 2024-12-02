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
        geraMensagem('A senha deve possuir mais de 8 caracteres', 'danger');
        header('Location: ../register.php');
        die();
    }

    return $senha;
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


session_start();

require_once('funcoes.php');
require_once('db-connect.php');

if(isset($_POST)){
    $nome = verificaNome($_POST['nome']);
    $nomeUsuario = verificaNome($_POST['nomeUsuario']);
    $descricao = $_POST['descricao'];
    $senha = $_POST['senha'];
    $confirmaSenha = $_POST['confirma-senha'];
    
    $foto = $_FILES['fotoPerfil'];
    $extensaoFoto = pathinfo($foto['name'], PATHINFO_EXTENSION);
    $nomeTempArquivo = $foto['tmp_name'];
    $novoNome = uniqid().".$extensaoFoto";

    $senha = verificaSenha($senha);

    //verifica se o formato da foto é aceito
    if(!formatoValido($extensaoFoto)){
        geraMensagem("Formato de arquivo ($extensaoFoto) inválido", 'danger');
        header('Location: ../register.php');
        die();
    }

    //se algum campo não foi preenchido, exibe o erro
    if(empty($nome) || empty($nomeUsuario) || empty($foto) || empty($descricao) || empty($senha) || empty($confirmaSenha)){
        geraMensagem('Você deve preencher todos os campos', 'danger');
        header('Location: ../register.php');
        die();
    }
    else{  
        // se conecta com o banco de dados
        try{
            $connect = new PDO("mysql:host=$hostname;dbname=$database", $username, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
        }
        catch(Exception $e){
            geraMensagem('Erro ao conectar: '.$e->getMessage(), 'danger');
        }
        
        try{
            // inicia a transação
            $connect->beginTransaction();

            //verifica se o nome de usuário já é usado por outra conta
            $sql = "SELECT nomeUsuario 
                    FROM Usuario 
                    WHERE nomeUsuario = ?";
            $stmt = $connect->prepare($sql);
            $stmt->bindParam(1, $nomeUsuario);
            $stmt->execute();
            
            if($stmt->rowCount() > 0){
                $connect->rollback();
                geraMensagem('Esse nome de usuário já é usado em outra conta', 'danger');
                header('Location: ../register.php');
                die();
            }
            else{
                if($senha == $confirmaSenha){       
                    $senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);

                    $nomeFoto = uploadFoto($novoNome, $nomeTempArquivo, '../public/fotos/');

                    if(! $nomeFoto){
                        $connect->rollback();
                        geraMensagem("Não foi possível fazer o upload da foto", 'danger');                    
                        header('Location: ../login.php');
                        die();
                    }

                    $sql = "INSERT INTO Usuario (Nome, NomeUsuario, Senha, FotoPerfil, Descricao)
                            VALUES (?, ?, ?, ?, ?)";
                    $stmt = $connect->prepare($sql);
                    $stmt->bindParam(1, $nome);
                    $stmt->bindParam(2, $nomeUsuario);
                    $stmt->bindParam(3, $senhaCriptografada);
                    $stmt->bindParam(4, $nomeFoto);
                    $stmt->bindParam(5, $descricao);
                    $stmt->execute();

                    $connect->commit();
                    geraMensagem("Conta criada com sucesso", 'success');

                    header('Location: ../login.php');
                    die();
                }
                else{
                    $connect->rollback();
                    geraMensagem('As senhas não conferem', 'danger');                    
                    header('Location: ../register.php');
                    die();
                }
            }
        }
        catch(Exception $e){
            // faz o rollback e exclui a foto que havia sido salva
            $connect->rollback();
            unlink("../public/fotos/$novoNome");
            geraMensagem('Erro ao cadastrar usuário: '.$e->getMessage(), 'danger');
        }
    }
}