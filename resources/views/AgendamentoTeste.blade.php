  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
        <h4 class="card-title"> <i class="ti-user"></i> Agendamento</h4>            
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">
            Add agendamento           
        </button>
          <hr>
          <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Cliente </th>
                        <th>Procedimento </th>
                        <th>R$ valor </th>
                        <th><i class="mdi ti-phone"></i>  WhastApp</th>
                        {{-- <th><i class="ti-instagram"></i> Instagram</th>   --}}
                        <th>Ação</th>                  
                    </tr>
                </thead>
                <tbody>
                    @foreach ($agendamentos as $agendamento)
                        <tr>
                            <td>{{$agendamento->cliente->nome}} </td>
                            <td>{{$agendamento->procedimento->nome}} </td>
                            <td>R$ {{$agendamento->procedimento->preco}} </td>                            
                            <td><a href="#">{{$agendamento->cliente->whastapp}} </a></td>
                            {{-- <td><a href="#">{{$agendamento->cliente->instagram}} </a></td>    --}}
                            <td>
                              <button type="button" class="btn btn-success btn-icon-text">
                                <i class="ti-alert btn-icon-prepend"></i>                                                    
                                Iniciar
                              </button>
                              
                              <a href="{{ route('procedimentoEdite', ['id' => $agendamento->cliente->id]) }}" type="button" class="btn btn-warning btn-icon-text" 
                               data-bs-toggle="modal"
                               data-bs-target="#remanejar"
                               data-bs-whatever="@mdo" >
                                <i class="ti-reload btn-icon-prepend"></i>                                                    
                                Remanejar
                              </a>

                              <button type="button" class="btn btn-danger btn-icon-text">
                                <i class="ti-upload btn-icon-prepend"></i>                                                    
                                Cancelar
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
<!--CRIAR AGENDAMENTO-->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      <h4 class="card-title">Criar novo agendamento.</h4>
      </div>
        {{-- <form class="forms-sample" method="POST"  act="{{ route('agendamento-store') }}" id="agendamento-form"> --}}
        <div class="modal-body">
        
          @csrf
            <div class="form-group">
              <input class="form-control" placeholder="dd/mm/yyyy" type="date" name="date" id="date-input" min="2023-05-28">
            </div>
             <div class="form-group">
              <input class="form-control" type="time" id="appt" name="appt" min="09:00" max="18:00" required>
            </div>
            <div class="form-group">
              <input class="form-control" type="text" name="whastapp"  placeholder="(99) 9 9999-9999">
            </div>           
            <div class="form-group">
                <select id="mySelect" name="procedimento_id" class="form-control">
                    @foreach ($procedimentos as $procedimento)
                        <option value="{{$procedimento->id}}">
                            {{$procedimento->nome}}
                        </option>                        
                    @endforeach
                   
                </select>            
            </div>
            <div class="form-group">
                <select id="mySelect" name="cliente_id" class="form-control">
                     @foreach ($clientes as $cliente)
                        <option value="{{$cliente->id}}"> 
                            {{$cliente->nome}} 
                        </option>                        
                    @endforeach
                </select>              
            </div> 
               
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>       
        <button type="button" onclick='salvarAgenda()' class="btn btn-success btn-rounded btn-fw">Salvar </button>   
      </div>
      {{-- </form> --}}
    </div>
  </div>
</div>



<!--REMANEJAR CLIENTE-->
{{-- <div class="modal fade" id="remanejar" tabindex="-1" aria-labelledby="remanejarLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      <h4 class="card-title">Remanejar Atendimento.</h4>
      </div>
      <div class="modal-body">
        <form class="forms-sample" method="POST"  data-url="{{ route('agendamento-') }}" id="agendamento-form2">
        
          @csrf
            <div class="form-group">
              <input class="form-control" placeholder="dd/mm/yyyy" type="date" name="date" id="date-input" min="2023-05-28">
            </div>
             <div class="form-group">
              <input class="form-control" type="time" id="appt" name="appt" min="09:00" max="18:00" required>
            </div>
            <div class="form-group">
              <input class="form-control" type="text" name="whastapp"  placeholder="">
            </div>           
            <div class="form-group">
                <select id="mySelect" name="procedimento_id" class="form-control">
                    @foreach ($procedimentos as $procedimento)
                        <option value="{{$procedimento->id}}">
                            {{$procedimento->nome}}
                        </option>                        
                    @endforeach
                   
                </select>            
            </div>

            <div class="form-group">
                <select id="mySelect" name="cliente_id" class="form-control">
                     @foreach ($clientes as $cliente)
                        <option value="{{$cliente->id}}"> 
                            {{$cliente->nome}} 
                        </option>                        
                    @endforeach
                </select>              
            </div> 
               
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>       
        <button type="submit"  class="btn btn-success btn-rounded btn-fw">Salvar </button>   
      </div>
      </form>
    </div>
  </div>
</div> --}}


<script>
  function salvarAgenda(){
    alert('01');
  }
</script>

















<form id="userForm">
  <input type="text" name="username" placeholder="Enter gitHub User name">
  <input type="submit" value="Search">
</form>
<!-- O resultado da busca será renderizado dentro desta div -->
<div id="result"></div>
 
<script>
// Anexa um manipulador de envio ao formulário
$( "#userForm" ).submit(function( event ) {
 
  // Evita que o formulário faça seu envio normal
  event.preventDefault();
 
  // Obtém alguns valores dos elementos da página:
  var $form = $( this ),
    username = $form.find( "input[name='username']" ).val(),
    url = ;
 
  // Envia os dados usando post
  var posting = $.post( url, { s: term } );
 
  //Função do Ajax para enviar uma solicitação get
  $.ajax({
    type: "GET",
    url: url,
    dataType:"jsonp"
    success: function(response){
        //Se a solicitação for feita com sucesso, a resposta representará os dados

        $( "#result" ).empty().append( response );
    }
  });
  
});



</script>