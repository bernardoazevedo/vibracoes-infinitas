<div class="card">
    <div class="card-header">
        <img src="public/fotos/<?= $projeto['criador_fotoPerfil'] ?>" class="rounded-circle" alt="" width="40px" height="40px">
        <span class="ml-2 fw-bold"><?=$projeto['criador_nome']?></span><span> criou um novo projeto</span>
        <span class="fs-6 position-absolute end-0 text-body-tertiary mr-3"><?= $data ?></span>
    </div>
    <div class="card-body">
        <div class="fw-bold">
            <?= $projeto['projeto_nome'] ?>
        </div>
        <div class="mt-2">
            <?= $projeto['projeto_descricao'] ?>
        </div>
    </div>
    <!-- exibe os participantes do projeto -->
    <div class="card-footer">
        <span>Membros do projeto</span>
        <ul class="list-group">
            <li class="list-group-item"><?= $projeto['criador_nome'] ?> - criador</li>
            <?php foreach($projeto['participantes'] as $participante): ?>
                <li class="list-group-item"><?= $participante['Nome'] ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>