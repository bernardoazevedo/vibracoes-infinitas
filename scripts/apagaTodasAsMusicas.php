<?php 

/**
 * Apaga os arquivos da pasta '/musicas'
 */

function listaArquivos($pasta){
    // retorna um array com os arquivos da pasta
    $arquivos = scandir($pasta);

    //tira os caminhos '.' e '..' do array de arquivos
    array_shift($arquivos);
    array_shift($arquivos);

    return $arquivos;
}

function apagaArquivo($caminhoArquivo){
    $arquivo = basename($caminhoArquivo);

    if(file_exists($caminhoArquivo)){
        if(unlink($caminhoArquivo)){
            echo "Arquivo ($arquivo) excluído com sucesso\n";
        }
        else{
            echo "ERRO: Não foi possível excluir o arquivo ($arquivo)\n";
        }
    }
    else{
        echo "ERRO: O arquivo ($arquivo) não existe\n";
    }

    return false;
}


$pasta = __DIR__.'/../musicas/';

$arquivos = listaArquivos($pasta);

if(count($arquivos) == 0){
    echo "ERRO: Não existem arquivos na pasta: ($pasta)\n";
    return;
}

foreach($arquivos as $arquivo){
    apagaArquivo($pasta.$arquivo);
}
