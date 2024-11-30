<?php 

function pr($variavel, $die = true){
    echo '<pre>---';
    echo '<hr>--->: '; print_r($variavel);
    echo '</pre>---';

    if($die)
        die();
}

/**
 * Recebe uma mensagem e seu tipo e salva na session, para depois ser exibida na view
 */
function geraMensagem($mensagem, $tipo = 'alert'){
    $novaMensagem['texto'] = $mensagem;
    $novaMensagem['tipo'] = $tipo;
    $_SESSION['mensagens'][] = $novaMensagem;
}

/**
 * Faz uma consulta no banco de dados utilizando o conceito de transações
 */
function consulta($sql, $parametros = null){
    require('db-connect.php');

    try{
        $connect = new PDO("mysql:host=$hostname;dbname=$database", $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }
    catch(Exception $e){
        geraMensagem('Erro ao conectar: '.$e->getMessage(), 'danger');
    }

    try{
        $connect->beginTransaction();

        $stmt = $connect->prepare($sql);

        if($parametros){
            $quantidade = count($parametros);
            for($i=1; $i <= $quantidade; $i++){
                $stmt->bindParam($i, $parametros[$i-1]);
            }
        }

        $stmt->execute();
        $connect->commit();
    }
    catch(Exception $e){
        $connect->rollback();
        geraMensagem('Erro ao realizar operação: '.$e->getMessage(), 'danger');
    }

    if($stmt->rowCount() > 0){
        $resultado = [];
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $resultado[] = $row;
        }        
    }

    return $resultado;
}

/**
 * Retorna as conexões do músico
 */
function getConexoes($idMusico){
    $sql = "SELECT c.UsuarioOrigemID, c.UsuarioDestinoID, c.DataCriacao, u.ID, u.Nome, u.NomeUsuario, u.FotoPerfil, u.Descricao
            FROM Conexao c
            INNER JOIN Usuario u ON c.UsuarioDestinoID = u.ID
            WHERE c.UsuarioOrigemID = ?"; 
    
    return consulta($sql, [$idMusico]);
}

/**
 * Retorna todos os músicos
 */
function getMusicos(){
    $sql = "SELECT ID, Nome, NomeUsuario, FotoPerfil, Descricao 
            FROM Usuario";

    return consulta($sql);
}

/**
 * Retorna todos os projetos
 */
function getProjetos(){
    $sql = "SELECT  pm.ID AS 'projeto_id', 
                    pm.Nome AS 'projeto_nome', 
                    pm.Descricao AS 'projeto_descricao', 
                    u.Nome AS 'criador_nome', 
                    u.NomeUsuario AS 'criador_nomeUsuario', 
                    u.FotoPerfil AS 'criador_fotoPerfil', 
                    u.Descricao AS 'criador_descricao'
            FROM ProjetoMusical pm
            INNER JOIN Usuario u ON pm.UsuarioCriadorID = u.ID"; 

    return consulta($sql);
}

/**
 * Retorna um projeto pelo seu id
 */
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
            WHERE pm.ID = ? 
            LIMIT 1"; 

    return consulta($sql, [$projetoId])[0];
}

/**
 * Retorna os membros de um projeto pelo seu id
 */
function getMembrosProjeto($projetoId){
    $sql = "SELECT * 
            FROM MembroProjeto mp
            WHERE mp.ProjetoID = ?"; 

    return consulta($sql, [$projetoId]);
}

/**
 * Retorna um músico pelo seu id
 */
function getMusicoPeloId($idMusico){
    $sql = "SELECT ID, Nome, NomeUsuario, FotoPerfil, Descricao
            FROM Usuario u
            WHERE u.ID = ?
            LIMIT 1";

    return consulta($sql, [$idMusico])[0];
}

/**
 * Retorna todos os projetos, cada um com todos os seus participantes
 */
function getProjetosParticipantes(){
    $projetos = getProjetos();

    foreach($projetos as $key_projeto => $projeto){

        $participantes = getMembrosProjeto($projeto['projeto_id']);

        foreach($participantes as $key_participante => $participante){
            $participante = getMusicoPeloId($participante['UsuarioID']);
            $participantes[$key_participante] = $participante;
        }
        
        $projetos[$key_projeto]['participantes'] = $participantes;
    }

    return $projetos;
}

/**
 * Retorna um projeto com todos os seus participantes
 */
function getProjetoParticipantesPeloId($projeto_id){
    $projeto = getProjetoPeloId($projeto_id);

    $participantes = getMembrosProjeto($projeto['projeto_id']);

    foreach($participantes as $key_participante => $participante){
        $participante = getMusicoPeloId($participante['UsuarioID']);
        $participantes[$key_participante] = $participante;
    }
    
    $projeto['participantes'] = $participantes;

    return $projeto;
}

/**
 * Retorna todas as atividades
 */
function getAtividades(){
    $sql = "SELECT *
            FROM FeedAtividades fa";
    
    return consulta($sql);
}

/**
 * Retorna todas as músicas
 */
function getMusicas(){
    $sql = "SELECT *
            FROM Musica 
            ORDER BY DataUpload DESC";

    return consulta($sql);
}

/**
 * Retorna uma música pelo seu id
 */
function getMusicaPeloId($musica_id){
    $sql = "SELECT *
            FROM Musica
            WHERE ID = ? 
            LIMIT 1";

    return consulta($sql, [$musica_id])[0];
}

/**
 * Busca as atividades das conexões do usuário para exibir no feed
 * Ordena pelas atividades mais recentes
 */
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
    $sql .= ")
            ORDER BY DataAtividade DESC";
    
    return consulta($sql);
}

/**
 * Retorna todas as conexões de um músico
 */
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

/**
 * Retorna a quantidade de músicas do músico
 */
function getQuantidadeMusicas($musico_id){
    $sql = "SELECT COUNT(m.ID) AS quantidade
            FROM Musica m
            WHERE m.Artista = ?";

    return consulta($sql, [$musico_id])[0]['quantidade'];
}

/**
 * Retorna a quantidade de conexões do músico
 */
function getQuantidadeConexoes($musico_id){
    $sql = "SELECT COUNT(c.UsuarioDestinoID) AS quantidade
            FROM Conexao c
            WHERE c.UsuarioOrigemID = ?";

    return consulta($sql, [$musico_id])[0]['quantidade'];
}

/**
 * Retorna a quantidade de projetos do músico
 */
function getQuantidadeProjetos($musico_id){
    $sql = "SELECT COUNT(pm.ID) AS quantidade
            FROM ProjetoMusical pm
            WHERE pm.UsuarioCriadorID = ?";

    return consulta($sql, [$musico_id])[0]['quantidade']; 
}

function getUsuarioLogado(){
    return $_SESSION['usuario'] ?? false;
}

function getIdUsuarioLogado(){
    $usuario = getUsuarioLogado();
    return $usuario['id'] ?? false;
}