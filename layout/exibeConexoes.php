<div class="card">
    <div class="card-header">
        Conexões
    </div>
    <div class="card-body p-0">
        <?php if($conexoes): ?>
            <?php foreach($conexoes as $conexao): ?>
                <div class="w-auto p-2 d-flex border-top">
                    <img src="../public/fotos/<?= $conexao['FotoPerfil'] ?>" class="rounded" alt="" width="40px" height="40px">
                    <span class="text-start ml-2 flex-fill text-truncate align-self-center"><?= $conexao['NomeUsuario'] ?></span>
                    <button class="btn btn-outline-primary btn-sm btn-desconectar" value="<?= $conexao['UsuarioDestinoID'] ?>">Desconectar</button>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="p-3">Suas conexões aparecerão aqui</div>
        <?php endif; ?>
    </div>
</div>