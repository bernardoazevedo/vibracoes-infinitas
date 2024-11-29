
$('.close').each(function() {
    $(this).click(function(){
        $(this).parent().addClass('d-none');
    });
});

$('.btn-conectar').each(function() {
    $(this).click(function(){
        let button = $(this);
        let conexaoId = button.val();
        button.addClass('disabled');

        $.ajax({
            url: '/actions/criarConexao.php',
            type: 'POST',
            data:{
                conexaoId: conexaoId
            },
            success: function(response){
                console.log('Conexão criada: '+response);
                button.text('Conectado');
            },
            error: function(response){
                console.log('Erro ao criar conexão');
            }
        });
    });
});

$('.btn-desconectar').each(function() {
    $(this).click(function(){
        let button = $(this);
        let conexaoId = button.val();
        button.addClass('disabled');

        $.ajax({
            url: '/actions/excluirConexao.php',
            type: 'POST',
            data:{
                conexaoId: conexaoId
            },
            success: function(response){
                console.log('Conexão excluída: '+response);
                button.text('Desconectado');
            },
            error: function(response){
                console.log('Erro ao excluir conexão');
            }
        });
    });
});

$('.btn-excluir-projeto').each(function() {
    $(this).click(function(){
        let button = $(this);
        let projetoId = button.val();
        button.addClass('disabled');

        $.ajax({
            url: '/actions/excluirProjeto.php',
            type: 'POST',
            data:{
                projetoId: projetoId
            },
            success: function(response){
                if(response == 'true'){
                    console.log('Projeto excluído: '+response);
                    button.parentsUntil('.container').addClass('d-none');
                }
                else{
                    console.log('Erro ao excluir projeto: '+response);
                }
            },
            error: function(response){
                console.log('Erro ao excluir projeto: '+response);
            }
        });
    });
});