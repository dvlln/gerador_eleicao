// MASCARA DOS CAMPOS
$('.cpf').mask('000.000.000-00');
$('.cep').mask('00000-000');
$('.uf').mask('SS');
$('.phone').mask('(00) 0000-0000');
$('.cellphone').mask('(00) 00000-0000');

// PREENCHER CAMPOS COM BASE NO CEP
$(document).on('blur', '#cep', function(){
    const cep = $(this).val();

    $.ajax({
        url: 'https://viacep.com.br/ws/'+cep+'/json/',
        method: 'GET',
        dataType: 'json',
        success: function(data){
            if(data.erro){
                alert ('Endereço não encontrado');
            }

            $('#uf').val(data.uf);
            $('#city').val(data.localidade);
            $('#street').val(data.logradouro);
            $('#district').val(data.bairro);
        }
    });
});