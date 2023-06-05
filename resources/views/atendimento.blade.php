@extends('blanck')
@section('title', 'Atendimentos')
@section('tela')

<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.2.min.js"></script> 
    
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
        <h4 class="card-title"> <i class="mdi mdi-calendar-clock"></i> Atendimentos </h4> 
        <input type="date">           
          <hr>
          <div class="table-responsive">
            <table class="table table-hover" id="tabela">
                <thead>
                    <tr>                       
                        <th> Cliente</th>
                        <th>Horario</th>
                        <th>Data</th>                       
                        <th>Procedimento </th>
                        <th>Status</th>
                        {{-- <th><i class="ti-instagram"></i> Instagram</th>   --}}
                        <th>Ação</th>
                                        
                    </tr>
                </thead>
                <tbody>
                    @foreach ($agendamentos as $agendamento)
                        @if($agendamento->status == 1)
                            <tr>
                                <td  data-bs-toggle="collapse" data-bs-target="#{{ $agendamento->id }}" aria-expanded="false" aria-controls="flush-collapseOne">{{$agendamento->cliente->nome}} </td>                                
                                <td>{{ $agendamento->opening_hours }}</td>                            
                                <td>{{ $agendamento->data }}</td>                            
                                
                                <td>{{ $agendamento->procedimento->nome }}</td>  
                                <td><label class="badge badge-success">Em atendimento</label></td>
                                <td>                        
                                    <button type="button" class="btn btn-primary btn-rounded btn-icon"
                                        data-bs-toggle="modal"
                                        data-bs-target="#fecharAtendimento{{ $agendamento->id }}">
                                        <i class="mdi mdi-alarm-check"></i>                                                              
                                    </button>
                                                            
                                </td>               
                            </tr>                   
                        @endif               
                    @endforeach                    
                </tbody>
            </table>
   
          </div>
        </div>
    </div>
</div>

 @foreach ($agendamentos as $agendamento)
    <!-- Modal -->
    <div class="modal fade" id="fecharAtendimento{{ $agendamento->id }}" tabindex="-1" aria-labelledby="iniciarModalLabel" aria-hidden="true">
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
                          <div class="col">
                            <div class="form-check form-switch">
                                {{$agendamento->procedimento->nome}}                          
                            </div>                    
                          </div>
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
   
 <div id="2" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
    <div class="accordion-body">
         <label>{{$agendamento->cliente->nome}} </label>
    </div>
</div>

<script>
$(function(){
    $("#tabela input").keyup(function(){        
        var index = $(this).parent().index();
        var nth = "#tabela td:nth-child("+(index+1).toString()+")";
        var valor = $(this).val().toUpperCase();
        $("#tabela tbody tr").show();
        $(nth).each(function(){
            if($(this).text().toUpperCase().indexOf(valor) < 0){
                $(this).parent().hide();
            }
        });
    });
 
    $("#tabela input").blur(function(){
        $(this).val("");
    }); 
});
</script>

@endsection