<div class="card">
    <div class="card-header d-flex">
        <img src="public/fotos/<?= $projeto['criador_fotoPerfil'] ?>" class="rounded" alt="" width="48px" height="48px">
        <span class="align-self-center ml-2 mr-1 fw-bold"><?=$projeto['criador_nomeUsuario']?></span>
        <span class="align-self-center flex-fill text-truncate"> criou um novo projeto</span>
        <span class="align-self-center fs-6 text-body-tertiary text-end"><?= $data ?></span>
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
    <div class="card-footer p-0 border-top pt-2">
        <span class="px-3 fw-bold">Membros</span>

        <div class="d-flex flex-wrap g-4">
            <div class="w-auto p-2 border flex-fill">
                <img src="../public/fotos/<?= $projeto['criador_fotoPerfil'] ?>" class="rounded" alt="" width="32px" height="32px">
                <span class="text-start ml-2"><?= $projeto['criador_nomeUsuario'] ?></span>
            </div>
            <?php foreach($projeto['participantes'] as $participante): ?>
                <div class="w-auto p-2 border flex-fill">
                    <img src="../public/fotos/<?= $participante['FotoPerfil'] ?>" class="rounded" alt="" width="32px" height="32px">
                    <span class="text-start ml-2"><?= $participante['NomeUsuario'] ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>