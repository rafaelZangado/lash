<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Calendário</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">
</head>
<body>
  <div class="container mt-5">
    <h1>Calendário</h1>
    <div class="input-group mb-3">
      <input type="text" class="form-control" id="datepicker" placeholder="Selecione uma data">
      <button class="btn btn-primary" type="button" id="datepicker-trigger">Abrir</button>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script>
  <script>
    // Inicializar o plugin de calendário
    $(document).ready(function() {
      $('#datepicker').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true,
        todayBtn: 'linked',
        language: 'pt-BR'
      });
      
      // Abrir o calendário ao clicar no botão
      $('#datepicker-trigger').click(function() {
        $('#datepicker').datepicker('show');
      });
    });
  </script>
</body>
</html>
