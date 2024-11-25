$('.close').each(function() {
    $(this).click(function(){
        $(this).parent().addClass('d-none');
    });
});


$('.btn-conectar').each(function() {
    $(this).click(function(){
        let conexaoId = $(this).val();
        $(this).addClass('disabled');
        $.ajax({
            url: '/src/actions/criarConexao.php',
            type: 'POST',
            data:{
                conexaoId: conexaoId
            },
            success: function(response){
                if(response == 'true'){
                    console.log('Conexão criada: '+response);
                }
                else{
                    console.log('Erro ao criar conexão');
                }
            },
            error: function(response){
                console.log('Erro ao criar conexão');
            }
        });
    });
});

$('.btn-desconectar').each(function() {
    $(this).click(function(){
        let conexaoId = $(this).val();
        $(this).addClass('disabled');
        $.ajax({
            url: '/src/actions/excluirConexao.php',
            type: 'POST',
            data:{
                conexaoId: conexaoId
            },
            success: function(response){
                if(response == 'true'){
                    console.log('Conexão excluída: '+response);
                }
                else{
                    console.log('Erro ao excluir conexão');
                }
            },
            error: function(response){
                console.log('Erro ao excluir conexão');
            }
        });
    });
});