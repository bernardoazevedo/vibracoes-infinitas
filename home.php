<?php 

session_start();

function listaArquivos($pasta){
    // retorna um array com os arquivos da pasta
    $arquivos = scandir($pasta);

    //tira os caminhos '.' e '..' do array de arquivos
    array_shift($arquivos);
    array_shift($arquivos);

    return $arquivos;
}

$pasta = '/musicas';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main>
        <?php if(isset($_SESSION['mensagem'])): ?>
            <section id="mensagem">
                <span><?= $_SESSION['mensagem'] ?></span>
                <?php unset($_SESSION['mensagem']) ?>
            </section>
        <?php endif; ?>
        <section id="forms-upload">
            <article id="multiplo">
                <header>
                    <h2>Upload</h2>
                </header>
                <form action="actions/upload.php" method="post" enctype="multipart/form-data">
                    <label for="nomeMusica">Nome da música</label>
                    <input type="text" name="nomeMusica" id="nomeMusica">
                    <br><br>

                    <label for="musica">Selecionar música</label>
                    <input type="file" name="musica" id="musica">
                    
                    <input type="submit" name="enviar-multiplos" value="Enviar">
                </form>
            </article>
        </section>
        <section id="arquivos">
            <header>
                <h2>Salvos</h2>
            </header>
            
            <?php 
$arquivos = listaArquivos(__DIR__.$pasta);
$quantidade = count($arquivos);

if($quantidade > 0){
            ?>

    <table id='lista-arquivos'>
        <tr>
            <th></th>
            <!-- <th>Tamanho</th> -->
            <th></th>
            <!-- <th></th> -->
        </tr>

<?php 
    foreach($arquivos as $arquivo):
        $caminhoArquivo = "$pasta/".$arquivo;
?>
        <tr class='li-arquivo'>
            <td>
                <?= $arquivo ?>
            </td>
            <td>
                <audio controls>
                    <source src="<?= "musicas/".$arquivo ?>" type="audio/mp3" />
                </audio>
            </td>
        </tr>
<?php endforeach; ?>
    </table> 
<?php 
}
else{
?>

    <div>Não há arquivos salvos</div>

<?php 
}
?>

        </section>
        <div id="mensagem">
            <?php
                echo $_SESSION['mensagem-home']; 
                unset($_SESSION['mensagem-home']);
            ?>
        </div>
    </main>
</body>
</html>