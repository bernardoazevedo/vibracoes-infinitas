<div class="card">
    <div class="card-header d-flex">
        <img src="public/fotos/<?= $usuario['FotoPerfil'] ?>" class="rounded" alt="" width="48px" height="48px">
        <span class="align-self-center ml-2 mr-1 fw-bold"><?=$usuario['NomeUsuario']?></span>
        <span class="align-self-center flex-fill text-truncate"> compartilhou uma nova música</span>
        <span class="align-self-center fs-6 text-body-tertiary text-end"><?= $data ?></span>
    </div>
    <div class="card-body">
        <div class="mb-2">
            <span class="fw-bold"><?= $musica['Titulo'] ?></span>
            <span class="text-body-secondary">- <?= $musica['Genero'] ?></span>
        </div>
        <audio controls="controls" class="rounded w-100">
            <source src="public/musicas/<?=$musica['NomeArquivo']?>" type="audio/mpeg">
        </audio>
    </div>
</div>