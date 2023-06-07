@extends('blanck')
@section('title', 'Agendamento')
@section('tela')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

 
    
 
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
        <h4 class="card-title"> <i class="mdi mdi-calendar-clock"></i> Agendamento</h4>            
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">
          +  Add agendamento            
        </button>
        <br>
         
          <hr>
          <tr>
            <div class="btn-group">     
            <form action="{{ route('agendamentos-filtrar') }}" method="GET">                        
              <i class="mdi mdi-filter-outline" class="btn btn-danger dropdown-toggle" 
                data-bs-toggle="dropdown" 
                aria-expanded="false">
                Ultimos dias
              </i>
              <input type="text" placeholder="Buscar os ultimos dias" class="form-control dropdown-menu">

              <i class="mdi mdi-filter-outline" class="btn btn-primary btn-rounded btn-icon-text" 
                data-bs-toggle="dropdown" 
                aria-expanded="false">
                Ultimos semanas
              </i>
              <input type="text"  class="form-control dropdown-menu">

              <i class="mdi mdi-filter-outline" class="btn btn-danger dropdown-toggle" 
                data-bs-toggle="dropdown" 
                aria-expanded="false">
                Data 
              </i>                                           
              <input type="date" placeholder="Buscar os ultimos dias" class="form-control dropdown-menu">  
            </form>               
            </div>
          </tr>
          <div class="table-responsive">
            <table class="table table-hover" id="tabela_filter">
              <thead>
                  <tr>
                    <!-- Example single danger button -->                    
                      <th> Cliente </th>
                      <th>Horario</th>
                      <th>Data</th>
                      <th>status</th>
                      <th><i class="mdi ti-phone"></i>  WhastApp</th>
                      <th>Ação</th>                  
                  </tr>
              </thead>
              <tbody>
                @foreach ($agendamentos as $agendamento)                  
                  <tr>
                    <td data-bs-toggle="collapse" 
                        data-bs-target="#{{$agendamento->id}}" 
                        aria-expanded="false" 
                        aria-controls="flush-collapseOne"><a href="#">
                      {{$agendamento->cliente->nome}} 
                      </a>
                      <div id="{{$agendamento->id}}" class="accordion-collapse collapse">
                        <div class="accordion-body">
                        <hr>
                            <b>Procedimento: </b> {{$agendamento->procedimento->nome}}</br>
                            <b>Valor: R$ </b> {{$agendamento->procedimento->preco}}</br>
                            <b>Instagram: </b> {{$agendamento->cliente->instagram}}</br>
                        </div>
                      </div>
                    </td>
                    
                    <td>{{ $agendamento->opening_hours }}</td>                            
                    <td>{{ $agendamento->data }}</td>                            
                    <td>{{ !$agendamento->return_date ? 'Primeira viagem' : 'Retorno' }}</td>                 
                    <td>
                      <a href="#">{{$agendamento->cliente->whastapp}} 
                      </a>
                      <a href="#">  |
                      {{$agendamento->whastapp}}   
                      </a> 
                    </td>
                    <td>
                      @if(!$agendamento->status == 1)
                        {{-- iniciar --}}                     
                        <a href="#" type="button" class="btn btn-success btn-icon-text"
                          data-bs-toggle="modal"
                          data-bs-target="#iniciarModal{{ $agendamento->id }}">
                          <i class="mdi mdi-play-circle-outline"></i>                                                
                        </a>  @else

                        {{-- Encerrar Atendimento --}}                         
                        <button type="button" class="btn btn-primary btn-rounded btn-icon-text"
                          data-bs-toggle="modal"
                          data-bs-target="#fecharAtendimento{{ $agendamento->id }}"
                          onclick="exibirAlerta()">
                          <i class="mdi mdi-alarm-check"></i>                                                              
                        </button>    
                      @endif  
                      {{-- reajendar --}}
                      <a href="#" type="button" class="btn btn-warning btn-icon-text"
                        data-bs-toggle="modal"
                        data-bs-target="#editModal{{ $agendamento->id }}">
                        <i class="mdi mdi-cached"></i>                        
                      </a>      

                      {{-- cancelar --}}
                      <button type="button" class="btn btn-danger btn-icon-text" data-bs-toggle="modal"
                        data-bs-target="#confirmDelete" 
                        data-agendamento-id="{{ $agendamento->id }}">
                          <i class="mdi mdi-delete-forever"></i>                          
                      </button>                            
                    </td>               
                  </tr>                              
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
    </div>
</div>

    
  
</div>

<!--CRIAR AGENDAMENTO-->
<div class="modal fade col-lg-12" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="card-title">Criar novo agendamento.</h4>
            </div>
            <form class="forms-sample" method="POST" action="{{ route('agendamento-store') }}" id="agendamento-form">
                <div class="modal-body">
                  @csrf      

                  <div class="row form-group">
                    <div class="col">
                      <input class="form-control" placeholder="dd/mm/yyyy" type="date" name="date" id="date-input" min="2023-05-28">
                    </div>                  
                    <div class="col">
                      <input class="form-control" type="time" id="appt" name="opening_hours"  required>
                    </div>
                  </div>

                  <div class="row form-group">
                    <div class="col">
                      <input class="form-control" placeholder="999.999.999-99" type="text" name="cpf" id="date-input">
                    </div>                  
                    <div class="col">
                      <input class="form-control" placeholder="Nome" type="text" id="appt" name="nome"  required>
                    </div>
                    <div class="col">
                      <input class="form-control"  placeholder="whatsapp" type="text" id="appt" name="whatsapp"  required>
                    </div>
                  </div>                

                  <div class="container text-center">
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4">
                      @foreach ($procedimentos as $procedimento)
                        <div class="col">
                          
                          <input class="form-check-input" type="checkbox"  name="procedimento_key[]" value="{{$procedimento->id}}" role="switch" id="flexSwitchCheckChecked" > 
                          {{ $procedimento->nome }}
                         
                        </div>                     
                      @endforeach
                    </div>
                  </div> 

                </div>                

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success btn-rounded btn-fw">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--REMANEJAR ATENDIMENTO-->
@foreach ($agendamentos as $agendamento)
    <!-- Modal -->
  <div class="modal fade" id="editModal{{ $agendamento->id }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h4 class="card-title">Iniciar Atendimento | {{$agendamento->cliente->nome}} </h4>
          </div>
          <div class="modal-body">
            <form method="POST" action="{{ route('agendamento-update', $agendamento->id) }}">
                @csrf
                @method('PUT')

                <!-- Adicione os campos do formulário que deseja editar -->

                <div class="form-group">
                    <input class="form-control" placeholder="dd/mm/yyyy" type="date" name="data" 
                        value="{{ $agendamento->data }}" id="date-input" min="2023-05-28">
                </div>

                <div class="form-group">
                  <input class="form-control" type="time" id="appt"  
                    value="{{$agendamento->opening_hours }}" name="opening_hours" min="09:00" max="18:00" required>
                </div>

                <div class="container text-center">
                  <div class="row row-cols-3">
                      <!-- Ativos -->
                      @foreach ($procedimentosPorId[$agendamento->id] as $nomeProcedimento)
                        <div class="col">
                          <div class="form-check form-switch">
                            <p>{{ $nomeProcedimento }}</p> 
                            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" checked>                           
                          </div>                    
                        </div>
                      @endforeach
                  </div>   
                </div>                           
                <button type="submit" class="btn btn-success btn-rounded btn-fw">Salvar</button>
            </form>
          </div>
      </div>
    </div>
  </div>
@endforeach



<!--INICIAR ATENDIMENTO-->
  @foreach ($agendamentos as $agendamento)
    <!-- Modal -->
    <div class="modal fade" id="iniciarModal{{ $agendamento->id }}" tabindex="-1" aria-labelledby="iniciarModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="card-title">Iniciar Agendamento | {{$agendamento->cliente->nome}} </h4>
              <h5>R$: {{$agendamento->procedimento->preco}}</h5>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('agendamento-start', $agendamento->id) }}">
                  @csrf
                  @method('PUT')
                  
                  <!-- Adicione os campos do formulário que deseja editar -->                       
                  <div class="container overflow-hidden text-center">
                    <div class="row gy-5">
                      <div class="col-6">
                        <div class="p-3">
                          <b> Data: </b> {{$agendamento->data}}
                        </div>
                      </div>

                      <div class="col-6">
                        <div class="p-3">
                          <b>H: </b> {{$agendamento->opening_hours}}                        
                        </div>
                      </div>
                      
                      <b>Procedimentos: </b>
                      <div class="container text-center">
                        <div class="row row-cols-3">                      
                                                
                            @foreach ($procedimentosPorId[$agendamento->id] as $nomeProcedimento)
                              <div class="col">
                                <div class="form-check form-switch">
                                  <p>{{ $nomeProcedimento }}</p>                                                               
                                </div>                    
                              </div>
                            @endforeach                                      
                         
                        </div>   
                      </div>
                    </div>

                  </div>                                
                  <br>               
                  <button type="submit" class="btn btn-success btn-rounded btn-fw">
                    INICIAR ATENDIMENTO
                  </button>
                </form>
            </div>
          </div>
      </div>
    </div>
  @endforeach


 @foreach ($agendamentos as $agendamento)
    <!-- Fechar Atendimento -->
    <div class="modal fade" id="fecharAtendimento{{ $agendamento->id }}" tabindex="-1" aria-labelledby="iniciarModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">

                <h4 class="card-title"><i class="mdi mdi-alert-outline"></i> VOCÊ DESEJA ENCERRAR O ATENDIMENTO ? <i class="mdi mdi-alert-outline"></i> </h4>                
            </div>
            <div class="modal-body">
                <label>antes de finalizar o atendimento com o cliente certifique-se que esta tudo certo com ele(a). Lembre-se de avisar que o retorno é daqui a 15 dias</label>
                <form method="POST" action="{{ route('agendamento-close', $agendamento->id) }}">
                  @csrf
                  @method('PUT')
                  
                  <!-- Adicione os campos do formulário que deseja editar -->                       
                 
                  <div class="form-group">
                    <b> Data do retorno: </b> {{$agendamento->return_date}}
                  </div>

                  <div class="form-group">
                    <input class="form-control" type="time" id="appt"  value="{{$agendamento->opening_hours }}" name="opening_hours" min="09:00" max="18:00" required>
                  </div>
                  <div class="form-group">
                    <select id="mySelect" name="cliente_id" class="form-control">
                      
                        <option value="pix">
                         Pix
                        </option>
                        <option value="cred_card">
                         Cartão de credito
                        </option>
                        <option value="maney">
                         Dinheiro
                        </option>
                    
                    </select>
                  </div>

                  <div class="container text-center">
                      <b>Procedimentos</b>
                    <div class="row row-cols-3">
                      <!--Ativos-->
                      <div class="col">
                        <div class="form-check form-switch">
                          <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" checked>
                            {{$agendamento->procedimento->nome}}                          
                        </div>                    
                      </div>
                    </div>   
                  </div>                              
                  <br>               
                  <button type="submit" class="btn btn-success btn-rounded btn-fw">
                    FECHAR O ATENDIMENTO
                  </button>
                </form>
            </div>
          </div>
      </div>
    </div>
  @endforeach


<!-- Modal de confirmação de exclusão -->
<div class="modal fade" id="confirmDelete" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteLabel">Confirmar Exclusão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Deseja realmente excluir este agendamento?</p>
            </div>
            <div class="modal-footer">
              @foreach ($agendamentos as $agendamento)    
                <form id="deleteForm" method="POST" action="{{ route('delete', ['id' => $agendamento->id]) }}">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger">Excluir</button>
                </form>
              @endforeach

                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
 // Obtenha o token CSRF do cookie
    {{-- const csrfToken = document.cookie.match(new RegExp('(^| )XSRF-TOKEN=([^;]+)'));

    function enviarParaController(agendamentoId) {
        $.ajax({
            url: '/agendamento/' + agendamentoId + '/close',
            type: 'PUT',
            data: { _token: csrfToken[2] },  // Inclua o token CSRF nos dados da solicitação
            success: function (response) {
                // Manipule a resposta do controller aqui, se necessário
            },
            error: function (xhr, status, error) {
                // Manipule os erros, se houver, aqui
            }
        });
    }
   function exibirAlerta(agendamentoId) {
        Swal.fire({
            title: 'Voce Deseja Finalizar esse atendimento ?',
            text: 'antes de finalizar o atendimento com o cliente certifique-se que esta tudo certo com ele(a). Lembre-se de avisar que o retorno é daqui a 15 dias',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'OK',
        }).then((result) => {
            if (result.isConfirmed) {
                enviarParaController(agendamentoId);
            }
        });
    }

    function enviarParaController(agendamentoId) {
        
        $.ajax({
            url: '/agendamento/' + agendamentoId + '/close',
            type: 'PUT',
             headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: { /* dados a serem enviados para o controller, se necessário */ },
            success: function (response) {
                // Manipule a resposta do controller aqui, se necessário
            },
            error: function (xhr, status, error) {
                // Manipule os erros, se houver, aqui
            }
        });
    } --}}

    $(document).ready(function() {
        $('#tabela_filter').DataTable({
          language: {
            lengthMenu: 'Mostrar _MENU_ registros por página',
            zeroRecords: 'Desculpa! nada foi encontrado',
            info: 'Mostrando page _PAGE_ de _PAGES_',
            infoEmpty: 'nada encontrado',
            infoFiltered: '(filtrando from _MAX_ total de registro)',
          },
        });
    });
</script>
 
<script>
  new SlimSelect({
    select: '#multiple'
  })

  $(document).ready(function () {
    $('#tabela_filter').DataTable();
  });

  $(document).ready(function(){
    $("#myInput").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#myTable tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
  });

 

  function salvarAgenda() {
    var formData = $('#agendamento-form').serialize();

    $.ajax({
      url: "{{ route('agendamento-store') }}",
      type: "POST",
      data: formData,
      success: function(response) {
        // Processar a resposta JSON
        var agendamento = response.agendamento;
        // Atualizar a tela com os dados do agendamento recém-criado
        // Exemplo: Atualizar uma tabela ou exibir uma mensagem de sucesso
        $('#tabela-agendamentos').append('<tr><td>' + agendamento + '</td></tr>');

        // Limpar o formulário ou executar outras ações necessárias após a criação do agendamento

        // Exemplo: Limpar os campos do formulário
        $('#agendamento-form')[0].reset();
      },
      error: function(xhr, status, error) {
        console.log(error);
      }
    });
  }

</script>    
@endsection