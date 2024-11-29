<div class="card">
    <div class="card-header">
        Criar novo projeto
    </div>
    <div class="card-body">
        <form id="form-upload"  action="../actions/criarProjeto.php" method="post" enctype="multipart/form-data">
            <div class="row g-3">
                <div class="col col-12 col-lg-7">
                    <div>
                        <label for="nomeProjeto">Nome do projeto</label>
                        <input class="form-control" type="text" name="nomeProjeto" id="nomeProjeto" placeholder="Digite o nome do projeto">
                    </div>

                    <div class="mt-2">
                        <label for="descricaoProjeto">Descrição do projeto</label>
                        <textarea class="form-control" name="descricaoProjeto" id="descricaoProjeto" placeholder="Digite a descrição do projeto"></textarea>
                    </div>
                </div>

                <div class="col col-12 col-lg-5">
                    <label for="musicos">Adicionar músicos</label>
                    <div>
                        <?php foreach($musicos as $musico): ?>
                            <?php if($musico['ID'] != $_SESSION['usuario']['id']): ?>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="musicos[]" value="<?= $musico['ID'] ?>" id="<?= $musico['ID'] ?>">
                                <label class="form-check-label" for="flexCheckDefault">
                                    <?= $musico['NomeUsuario'] ?>
                                </label>
                            </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="mt-2">
                <button type="submit" class="btn btn-primary">Enviar</button>
            </div>
        </form>
    </div>
</div>