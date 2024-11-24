<?php
$connect = mysqli_connect('localhost', 'admin', 'admin', 'vibracoes_infinitas');


// Executa uma consulta na base de dados
function query($query) {
    $link = mysqli_connect('localhost:3306', 'admin', 'admin');
    if (!$link) {
        // die('Could not connect: ' . mysqli_error());
    }
    mysqli_select_db($link, "vibracoes_infinitas");
    $result = mysqli_query($link, $query);
    mysqli_close($link);
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