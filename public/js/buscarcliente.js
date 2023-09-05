$(document).ready(function() {
    $('#cpf').on('blur', function() {
      var cpf = $(this).val();
      cpf = cpf.replace(/\D/g, '');

      // Obtenha o token CSRF
      var csrfToken = $('meta[name="csrf-token"]').attr('content');

      $.ajax({
        url: '/buscarcliente/' + cpf,
        method: 'PUT',
        headers: {
          'X-CSRF-TOKEN': csrfToken
        },
        dataType: 'json',
        success: function(response) {
            console.log(response.nome)
            $('#nome').val(response.nome);
            $('#whastapp').val(response.whastapp);

          // Marque as caixas de seleção apropriadas com base nos procedimentos associados ao CPF
          $('input[name="procedimento_key[]"]').prop('checked', false); // Desmarque todos primeiro
          response.procedimentos.forEach(function(id) {
            $('input[name="procedimento_key[]"][value="' + id + '"]').prop('checked', true);
          });
        },
        error: function() {
          console.log('Ocorreu um erro ao verificar o CPF. Por favor, tente novamente.');
        }
      });
    });
  });
