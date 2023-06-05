alert('aaa');
console.log('aaaaaaaaaaaaaaaaa');
function loadContent(url) {
    $.ajax({
      url: url,
      success: function(data) {
        $('#content').html(data);
      },
      error: function() {
        $('#content').html('<p>Ocorreu um erro ao carregar o conteúdo.</p>');
      }
    });
  }
  