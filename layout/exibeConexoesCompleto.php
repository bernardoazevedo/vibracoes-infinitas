<div class="card">
    <div class="card-header">
        Suas conexões
    </div>
    <div class="card-body p-0">
        <?php if($conexoes): ?>
            <table class="table table-sm table-hover">
                <thead>
                    <td></td>
                    <td>Nome de usuário</td>
                    <td>Nome completo</td>
                    <td>Descrição do perfil</td>
                    <td></td>
                </thead>
                <tbody>
                    <?php foreach($conexoes as $conexao): ?>
                    <tr>
                        <td class="pl-2 align-middle">
                            <img src="../public/fotos/<?= $conexao['FotoPerfil'] ?>" class="rounded" alt="" width="40px" height="40px">
                        </td>
                        <td class="align-middle">
                            <span class="text-start"><?= $conexao['NomeUsuario'] ?></span>
                        </td>
                        <td>
                            <span class="text-start"><?= $conexao['Nome'] ?></span>
                        </td>
                        <td>
                            <span class="text-start"><?= $conexao['Descricao'] ?></span>
                        </td>
                        <td class="align-middle text-center pr-2">
                            <button class="btn btn-outline-primary btn-sm btn-desconectar" value="<?= $conexao['UsuarioDestinoID'] ?>">Desconectar</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="p-3">Suas conexões aparecerão aqui</div>
        <?php endif; ?>
    </div>
</div>