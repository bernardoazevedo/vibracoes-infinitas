<?php 
session_start();


$connect = mysqli_connect('localhost', 'admin', 'admin', 'vibracoes_infinitas');

$sql = "SELECT * 
        FROM Usuario"; 
$resultado = mysqli_query($connect, $sql);

if(mysqli_num_rows($resultado) > 0){
    //converte o resultado para um array associativo
	$musicos = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vibrações Infinitas</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="public/css/adminlte.min.css">
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
    <?php require_once('layout/navbar.php'); ?>

    <main class="container">

        <div class="card col-8">
            <div class="card-header">
                Enviar nova música
            </div>
            <div class="card-body">
                <form id="form-upload"  action="src/actions/upload.php" method="post" enctype="multipart/form-data">
                    <div class="row g-3">
                        <div class="col">
                            <label for="nomeMusica">Nome da música</label>
                            <input class="form-control" type="text" name="nomeMusica" id="nomeMusica" placeholder="Digite o nome da música">
                        </div>
                        <div class="col">
                            <label for="musica">Selecionar música</label>
                            <input class="form-control" type="file" name="musica" id="musica">
                        </div>
                    </div>
                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card col-8">
            <div class="card-header">
                Criar projeto
            </div>
            <div class="card-body">
                <form id="form-upload"  action="src/actions/criarProjeto.php" method="post" enctype="multipart/form-data">
                    <div class="row g-3">
                        <div class="col">
                            <div>
                                <label for="nomeProjeto">Nome do projeto</label>
                                <input class="form-control" type="text" name="nomeProjeto" id="nomeProjeto" placeholder="Digite o nome do projeto">
                            </div>

                            <div class="mt-2">
                                <label for="descricaoProjeto">Descrição do projeto</label>
                                <textarea class="form-control" name="descricaoProjeto" id="descricaoProjeto" placeholder="Digite a descrição do projeto"></textarea>
                            </div>
                        </div>

                        <div class="col">
                            <label for="musicos">Adicionar músicos</label>
                            <div>
                                <?php foreach($musicos as $musico): ?>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="musicos[]" value="<?= $musico['ID'] ?>" id="<?= $musico['ID'] ?>">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            <?= $musico['Nome'] ?>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script src="https://kit.fontawesome.com/df3ed30ad5.js" crossorigin="anonymous"></script>
    <!-- jQuery -->
    <script src="public/js/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>
</html>