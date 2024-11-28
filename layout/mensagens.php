<!-- Exibe as mensagens passadas pela Session -->
<?php if(isset($_SESSION['mensagens'])): ?>
    <?php foreach($_SESSION['mensagens'] as $key => $mensagem): ?>
        <div class="alert alert-<?= $mensagem['tipo'] ?> alert-dismissible fade show" role="alert">
            <span>
                <?= $mensagem['texto']; ?>
            </span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php unset($_SESSION['mensagens'][$key]) ?>
    <?php endforeach; ?>
<?php endif; ?>