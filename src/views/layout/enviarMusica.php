<div class="card col-8">
    <div class="card-header">
        Enviar nova música
    </div>
    <div class="card-body">
        <form id="form-upload"  action="../actions/upload.php" method="post" enctype="multipart/form-data">
            <div class="row g-3">
                <div class="col">
                    <label for="nomeMusica">Nome da música</label>
                    <input class="form-control" type="text" name="nomeMusica" id="nomeMusica" placeholder="Digite o nome da música">
                </div>
                <div class="col">
                    <label for="generoMusica">Gênero da música</label>
                    <input class="form-control" type="text" name="generoMusica" id="generoMusica" placeholder="Digite o gênero da música">
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