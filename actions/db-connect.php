<?php

$connect = mysqli_connect('localhost', 'admin', 'admin', 'vibracoes_infinitas'); 

// Executa uma consulta na base de dados
function query($query) {
    $connect = mysqli_connect('localhost', 'admin', 'admin');
    if (!$connect) {
        // die('Could not connect: ' . mysqli_error());
    }
    mysqli_select_db($connect, "vibracoes_infinitas");
    $result = mysqli_query($connect, $query);
    mysqli_close($connect);
    return $result;
}
// Executa uma consulta de tipo select e devolve o resultado
function select($query) {
    $result = query($query);
    $linhas = [];
    while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $linhas[] = $linha;
    }
    return $linhas;
}
function imprimir($dados) {
    echo "<pre>";
     var_dump($dados);
     echo "</pre>";
}