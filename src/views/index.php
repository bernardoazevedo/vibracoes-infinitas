<?php

session_start();

function listaMusicas($pasta)
{
	// retorna um array com as musicas
	$musicas = scandir($pasta);

	//tira os caminhos '.' e '..' da lista de musicas
	array_shift($musicas);
	array_shift($musicas);

	return $musicas;
}


$pasta = '/musicas';

$musicas = listaMusicas(getPublic($pasta));

echo '<pre>';
echo '<hr>$musicas: '; print_r($musicas);
echo '</pre>';
die();