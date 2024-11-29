<div class="card">
    <div class="card-header">
        Enviar nova música
    </div>
    <div class="card-body">
        <form id="form-upload"  action="../actions/upload.php" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-12 col-lg-5 mb-3">
                    <label class="mb-1" for="nomeMusica">Nome da música</label>
                    <input class="form-control" type="text" name="nomeMusica" id="nomeMusica" placeholder="Digite o nome da música">
                </div>
                <div class="col-12 col-lg-4 mb-3">
                    <label class="mb-1" for="generoMusica">Gênero da música</label>
                    <input class="form-control" type="text" name="generoMusica" id="generoMusica" placeholder="Digite o gênero da música">
                </div>
                <div class="col-12 col-lg-3">
                    <label class="mb-1" for="musica">Selecionar música</label>
                    <input class="form-control" type="file" name="musica" id="musica">
                </div>
            </div>
            <div class="">
                <button type="submit" class="btn btn-primary">Enviar</button>
            </div>
        </form>
    </div>
</div>