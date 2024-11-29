<div class="card">
    <div class="card-header">
        Todos os músicos
    </div>
    <div class="card-body p-0">
        <?php if(count($musicosConexoes)): ?>
            <table class="table table-sm table-hover">
                <thead>
                    <td></td>
                    <td>Nome de usuário</td>
                    <td>Nome completo</td>
                    <td>Descrição do perfil</td>
                    <td></td>
                </thead>
                <tbody>
                    <?php foreach($musicosConexoes as $musico): ?>
                    <tr>
                        <td class="pl-2 align-middle">
                            <img class="rounded" src="../public/fotos/<?= $musico['FotoPerfil'] ?>" alt="" width="40px" height="40px">
                        </td>
                        <td class="align-middle"><?= $musico['NomeUsuario'] ?></td>
                        <td class="align-middle">
                            <span class="text-start"><?= $musico['Nome'] ?></span>
                        </td>
                        <td class="align-middle">
                            <span class="text-start"><?= $musico['Descricao'] ?></span>
                        </td>
                        <td class="align-middle text-center pr-2">
                            <?php if($musico['ID'] == $usuarioAtivoId): ?>
                                <span class="">Você</span>
                            <?php elseif($musico['conectado']): ?>
                                <button class="btn btn-outline-primary btn-sm btn-conectado disabled">Conectado</button>
                            <?php else: ?>
                                <button class="btn btn-outline-primary btn-sm btn-conectar" value="<?= $musico['ID'] ?>">Conectar</button>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="p-3">Outros músicos aparecerão aqui</div>
        <?php endif; ?>
    </div>
</div>