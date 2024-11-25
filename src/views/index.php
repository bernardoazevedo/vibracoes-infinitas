<?php

session_start();

require_once('../actions/controleSessao.php');

function listaMusicas($pasta){
	// retorna um array com as musicas
	$musicas = scandir($pasta);

	//tira os caminhos '.' e '..' da lista de musicas
	array_shift($musicas);
	array_shift($musicas);

	return $musicas;
}

function getPublic($caminho){
    $raiz = realpath('.');
    return "$raiz/public/$caminho";
}

function getSrc($caminho){
    $raiz = realpath('.');
    return "$raiz/src/$caminho";
}


$pasta = '/musicas';

$musicas = listaMusicas(getPublic($pasta));

echo '<pre>';
echo '<hr>$musicas: '; print_r($musicas);
echo '</pre>';
die();