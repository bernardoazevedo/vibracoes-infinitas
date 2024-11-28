<div class="card">
    <div class="card-header">
        <img src="public/fotos/<?= $usuario['FotoPerfil'] ?>" class="rounded-circle" alt="" width="40px" height="40px">
        <span class="ml-2 fw-bold"><?=$usuario['NomeUsuario']?></span><span> compartilhou uma nova música</span>
        <span class="fs-6 position-absolute end-0 text-body-tertiary mr-3"><?= $data ?></span>
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