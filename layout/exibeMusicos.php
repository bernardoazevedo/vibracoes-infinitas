<div class="card">
    <div class="card-header">
        Descubra outros músicos
    </div>
    <div class="card-body p-0">
        <?php if(count($musicosConexoes)): ?>
            <table class="table table-sm table-hover table-borderless">
                <thead>

                </thead>
                <tbody>
                    <?php foreach($musicosConexoes as $musico): ?>
                        <?php if($musico['ID'] != $usuarioAtivoId): ?>
                            <tr>
                                <td class="pl-2">
                                    <img class="rounded" src="../public/fotos/<?= $musico['FotoPerfil'] ?>" alt="" width="40px" height="40px">
                                </td>
                                <td class="align-middle"><?= $musico['NomeUsuario'] ?></td>
                                <td class="align-middle text-center pr-2">
                                    <?php if($musico['conectado']): ?>
                                        <button class="btn btn-outline-primary btn-sm btn-conectado disabled">Conectado</button>
                                    <?php else: ?>
                                        <button class="btn btn-outline-primary btn-sm btn-conectar" value="<?= $musico['ID'] ?>">Conectar</button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="p-3">Outros músicos aparecerão aqui</div>
        <?php endif; ?>
    </div>
</div>