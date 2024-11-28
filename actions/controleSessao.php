<?php 

//se o usuário não está logado, direciona para a tela inicial
if(!isset($_SESSION['usuario']['logado'])){
    $mensagem['tipo'] = 'danger';
    $mensagem['texto'] = 'Você precisa estar logado para acessar essa página';
    $_SESSION['mensagens'][] = $mensagem;
    header('Location: ../login.php');
    die();
}

if(isset($_SESSION['usuario']['ultima-atividade'])){
    if(time() > $_SESSION['usuario']['ultima-atividade'] + 60*15){
        unset($_SESSION);
        session_unset();
        session_destroy();

        $mensagem['tipo'] = 'danger';
        $mensagem['texto'] = 'Você foi deslogado por ficar 15 minutos inativo';
        $_SESSION['mensagens'][] = $mensagem;
        header('Location: ../login.php');
        die();
    }
}
else{
    $_SESSION['usuario']['ultima-atividade'] = time();
}
