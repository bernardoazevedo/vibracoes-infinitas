<div class="card">
    <div class="card-header">
        Descubra outros músicos
    </div>
    <div class="card-body p-0">
        <?php if($musicosConexoes): ?>
            <div class="">
                <?php foreach($musicosConexoes as $musico): ?>
                    <div class="w-auto p-2 d-flex border-top">
                        <img src="../public/fotos/<?= $musico['FotoPerfil'] ?>" class="rounded" alt="" width="40px" height="40px">
                        <span class="text-start ml-2 flex-fill text-truncate align-self-center"><?= $musico['NomeUsuario'] ?></span>
                        
                        <?php if($musico['conectado']): ?>
                            <button class="btn btn-outline-primary btn-sm btn-conectado disabled">Conectado</button>
                        <?php elseif($musico['ID'] == $usuarioAtivoId): ?>
                            
                        <?php else: ?>
                            <button class="btn btn-outline-primary btn-sm btn-conectar" value="<?= $musico['ID'] ?>">Conectar</button>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="p-3">Outros músicos aparecerão aqui</div>
        <?php endif; ?>
    </div>
</div>