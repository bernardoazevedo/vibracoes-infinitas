<?php 

function getConexoes($connect, $idMusico){
    $sql = "SELECT c.UsuarioOrigemID, c.UsuarioDestinoID, c.DataCriacao, u.ID, u.Nome, u.NomeUsuario, u.FotoPerfil, u.Descricao
            FROM Conexao c
            INNER JOIN Usuario u ON c.UsuarioDestinoID = u.ID
            WHERE c.UsuarioOrigemID = $idMusico"; 
    
    $resultado = mysqli_query($connect, $sql);

    if(mysqli_num_rows($resultado) > 0){
        //converte o resultado para um array associativo
        $conexoes = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    }

    return $conexoes ?? false;
}

function getMusicos($connect){
    $sql = "SELECT ID, Nome, NomeUsuario, FotoPerfil, Descricao 
            FROM Usuario"; 
    
    $resultado = mysqli_query($connect, $sql);

    if(mysqli_num_rows($resultado) > 0){
        //converte o resultado para um array associativo
        $musicos = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    }

    return $musicos;
}

function getProjetos($connect){
    $sql = "SELECT pm.ID, pm.Nome, pm.Descricao, u.Nome AS 'criador_nome', u.NomeUsuario AS 'criador_nomeUsuario'
            FROM ProjetoMusical pm
            INNER JOIN Usuario u ON pm.UsuarioCriadorID = u.ID"; 
    
    $resultado = mysqli_query($connect, $sql);

    if(mysqli_num_rows($resultado) > 0){
        //converte o resultado para um array associativo
        $projetos = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    }

    return $projetos;
}

function getProjetosParticipantes($connect){
    $projetos = getProjetos($connect);

    foreach($projetos as $key_projeto => $projeto){
        $projetoId = $projeto['ID'];

        $sql = "SELECT * 
                FROM MembroProjeto mp
                WHERE mp.ProjetoID = $projetoId"; 

        $resultado = mysqli_query($connect, $sql);

        if(mysqli_num_rows($resultado) > 0){
            $participantes = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        }
        else{
            unset($participantes);
        }

        foreach($participantes as $key_participante => $participante){
            $participanteId = $participante['UsuarioID'];

            $sql = "SELECT ID, Nome, NomeUsuario, FotoPerfil, Descricao
                    FROM Usuario u
                    WHERE u.ID = $participanteId"; 

            $resultado = mysqli_query($connect, $sql);

            if(mysqli_num_rows($resultado) > 0){
                $participante = mysqli_fetch_assoc($resultado);
            }

            $participantes[$key_participante] = $participante;
        }
        
        $projetos[$key_projeto]['participantes'] = $participantes;
    }

    return $projetos;
}

function registraAtividade($connect, $usuario_id, $descricao){
    $result = false;
    $sql = "INSERT INTO FeedAtividades(UsuarioID, AtividadeDescricao)
            VALUES(?, ?)";

    if ($stmt = mysqli_prepare($connect, $sql)) {
        mysqli_stmt_bind_param($stmt, "is", $usuario_id, $descricao);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    return $result;
}

function getAtividades($connect){
    $sql = "SELECT *
            FROM FeedAtividades fa";
    
    $resultado = mysqli_query($connect, $sql);

    if(mysqli_num_rows($resultado) > 0){
        //converte o resultado para um array associativo
        $atividades = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    }

    return $atividades;
}

function getAtividadesDasConexoes($connect, $usuario_id){
    $conexoes = getConexoes($connect, $usuario_id);

    if($conexoes){
        foreach($conexoes as $key => $conexao){
            $idConexoes[] = $conexao['ID'];
        }
        
        $sql = "SELECT *
        FROM FeedAtividades fa
        WHERE fa.UsuarioID IN (";
        foreach($idConexoes as $idConexao){
            $sql .= "$idConexao,";
        }
        $sql = substr($sql, 0, (strlen($sql)-1));
        $sql .= ")";
        
        $resultado = mysqli_query($connect, $sql);
        
        if(mysqli_num_rows($resultado) > 0){
            //converte o resultado para um array associativo
            $atividades = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        }
       
        return $atividades;
    }
    else{
        return false;
    }
}