<div class="card col-8">
    <div class="card-header">
        Músicos cadastrados
    </div>
    <div class="card-body">
        <?php if(count($musicosConexoes)): ?>
            <table class="table table-sm table-hover">
                <thead>
                    <tr>
                        <th scope="col">Foto de perfil</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Nome de usuário</th>
                        <th scope="col">Descrição</th>
                        <th scope="col">Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($musicosConexoes as $musico): ?>
                    <tr class="">
                        <td>
                            <img class="rounded" src="../../public/fotos/<?= $musico['FotoPerfil'] ?>" alt="" width="80px">
                        </td>
                        <td class="align-middle"><?= $musico['Nome'] ?></td>
                        <td class="align-middle"><?= $musico['NomeUsuario'] ?></td>
                        <td class="align-middle"><?= $musico['Descricao'] ?></td>
                        <td class="align-middle">
                            <?php if($musico['ID'] == $usuarioAtivoId): ?>
                                <span>Você</span>
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
            <p>Ainda não existe nenhum músico cadastrado</p>
        <?php endif; ?>
    </div>
</div>