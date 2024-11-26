<?php 

/**
 * Faz uma consulta de select no banco de dados
 */
// function selectDb(string $sql, string $tipos = null, $parametros = null){
//     $connect = mysqli_connect('localhost', 'admin', 'admin', 'vibracoes_infinitas'); 

//     $stmt = mysqli_prepare($connect, $sql);

//     if(isset($tipos) && isset($parametros)){
//         mysqli_stmt_bind_param($stmt, $tipos, $parametros);
//     }

//     mysqli_stmt_execute($stmt);

//     $resultado = mysqli_stmt_get_result($stmt);

//     if(mysqli_num_rows($resultado) > 0){
//         //converte o resultado para um array associativo
//         $resultado = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        
//         // if(count($resultado) == 1){
//         //     $resultado = $resultado[0];
//         // }
//     }
//     else{
//         // $resultado = mysqli_fetch_assoc($resultado);
//         // $resultado = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
//     }

//     mysqli_stmt_close($stmt);
//     mysqli_close($connect);

//     return $resultado ?? false;
// }
function selectDb($query, $formats = null, $params = null){
    $connect = mysqli_connect('localhost', 'admin', 'admin', 'vibracoes_infinitas'); 

    $a_params = array();

    $param_type = '';
    $n = count($formats);
    for($i = 0; $i < $n; $i++) {
        $param_type .= $formats[$i];
    }

    $a_params[] = & $param_type;

    for($i = 0; $i < $n; $i++) {
        $a_params[] = & $params[$i];
    }

    $stmt = $connect->prepare($query);
    call_user_func_array(array($stmt, 'bind_param'), $a_params);
    $stmt->execute();

    $meta = $stmt->result_metadata();
    while ($field = $meta->fetch_field()) {
        $columns[] = &$row[$field->name];
    }

    call_user_func_array(array($stmt, 'bind_result'), $columns);

    while ($stmt->fetch()) {
        foreach($row as $key => $val) {
            $x[$key] = $val;
        }
        $results[] = $x;
    }
    $stmt->close();
    return $results;
}

/**
 * Faz um insert no banco de dados
 */
function insertDb($sql){
    $connect = mysqli_connect('localhost', 'admin', 'admin', 'vibracoes_infinitas'); 

    $stmt = mysqli_prepare($connect, $sql);

    mysqli_stmt_execute($stmt);

    $resultado = mysqli_stmt_get_result($stmt);

    mysqli_stmt_close($stmt);
    mysqli_close($connect);

    return $resultado ?? false;
}

function getConexoes($idMusico){
    $sql = "SELECT c.UsuarioOrigemID, c.UsuarioDestinoID, c.DataCriacao, u.ID, u.Nome, u.NomeUsuario, u.FotoPerfil, u.Descricao
            FROM Conexao c
            INNER JOIN Usuario u ON c.UsuarioDestinoID = u.ID
            WHERE c.UsuarioOrigemID = ?"; 
    
    return selectDb($sql, 'i', array($idMusico));
}

function getMusicos(){
    $sql = "SELECT ID, Nome, NomeUsuario, FotoPerfil, Descricao 
            FROM Usuario";

    return selectDb($sql);
}

function getProjetos(){
    $sql = "SELECT pm.ID, pm.Nome, pm.Descricao, u.Nome AS 'criador_nome', u.NomeUsuario AS 'criador_nomeUsuario'
            FROM ProjetoMusical pm
            INNER JOIN Usuario u ON pm.UsuarioCriadorID = u.ID"; 

    return selectDb($sql);
}

function getProjetoPeloId($projetoId){
    $sql = "SELECT  pm.ID AS 'projeto_id', 
                    pm.Nome AS 'projeto_nome', 
                    pm.Descricao AS 'projeto_descricao', 
                    u.Nome AS 'criador_nome', 
                    u.NomeUsuario AS 'criador_nomeUsuario', 
                    u.FotoPerfil AS 'criador_fotoPerfil', 
                    u.Descricao AS 'criador_descricao' 
            FROM ProjetoMusical pm
            INNER JOIN Usuario u ON pm.UsuarioCriadorID = u.ID
            WHERE pm.ID = $projetoId
            LIMIT 1"; 

    return selectDb($sql)[0];
}

function getMembrosProjeto($projetoId){
    $sql = "SELECT * 
            FROM MembroProjeto mp
            WHERE mp.ProjetoID = ?"; 

    $resultado = selectDb($sql, 'i', array($projetoId));

    return $resultado;
}

function getMusicoPeloId($idMusico){
    $sql = "SELECT ID, Nome, NomeUsuario, FotoPerfil, Descricao
            FROM Usuario u
            WHERE u.ID = ?
            LIMIT 1";

    return selectDb($sql, 'i', array($idMusico))[0];
}

function getProjetosParticipantes(){
    $projetos = getProjetos();

    foreach($projetos as $key_projeto => $projeto){

        $participantes = getMembrosProjeto($projeto['ID']);

        foreach($participantes as $key_participante => $participante){
            $participante = getMusicoPeloId($participante['UsuarioID']);
            $participantes[$key_participante] = $participante;
        }
        
        $projetos[$key_projeto]['participantes'] = $participantes;
    }

    return $projetos;
}

function registraAtividadeMusica($usuario_id, $musica_id){
    $sql = "INSERT INTO FeedAtividades(UsuarioID, MusicaID)
            VALUES($usuario_id, $musica_id)";

    return insertDb($sql);
}

function registraAtividadeProjeto($usuario_id, $projeto_id){
    $sql = "INSERT INTO FeedAtividades(UsuarioID, ProjetoID)
            VALUES($usuario_id, $projeto_id)";

    return insertDb($sql);
}

function getAtividades(){
    $sql = "SELECT *
            FROM FeedAtividades fa";
    
    return selectDb($sql);
}

function getMusicaPeloId($musica_id){
    $sql = "SELECT *
            FROM Musica
            WHERE ID = $musica_id
            LIMIT 1";

    return selectDb($sql)[0];
}

function getAtividadesDasConexoes($usuario_id){
    $conexoes = getConexoes($usuario_id);

    foreach($conexoes as $conexao){
        $idConexoes[] = $conexao['ID'];
    }
    
    $sql = "SELECT *
            FROM FeedAtividades fa
            WHERE fa.UsuarioID IN ($usuario_id,";
    foreach($idConexoes as $idConexao){
        $sql .= "$idConexao,";
    }
    $sql = substr($sql, 0, (strlen($sql)-1));
    $sql .= ")";
    
    return selectDb($sql);
}

function getMusicosConexoes($usuario_id){
    $conexoes = getConexoes($usuario_id);
    $musicos = getMusicos();

    foreach($musicos as $key => $musico){
        foreach($conexoes as $conexao){
            if($musico['ID'] == $conexao['UsuarioDestinoID']){
                $musicos[$key]['conectado'] = true;
            }
        }
    }

    return $musicos;
}