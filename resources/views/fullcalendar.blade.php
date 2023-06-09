@extends('blanck')
@section('title', 'Agendamento')
@section('tela')
<script src="{{ asset('js/fullcalendar/index.global.js') }}"></script>
<script src="{{ asset('js/fullcalendar/pt-br.global.js') }}"></script>
<style>

  #calendar {
    max-width: 100%;  
    margin: 0 auto;
    font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
    font-size: 13px;
    padding: 0;
  }

</style>
    <div class="row">
        <div class="col-md-7 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                   
                       <div id='calendar'></div>
                   
                </div>
            </div>
        </div>

        <div class="col-md-5 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
            <p class="card-title">Notifications</p>
            <ul class="icon-data-list">
                <li>
                    <div class="d-flex">
                        <div>
                            <p class="text-info mb-1">Isabella Becker</p>
                            <p class="mb-0">Sales dashboard have been created</p>
                            <small>9:30 am</small>
                        </div>
                    </div>
                </li>
   
            </ul>
        </div>
            </div>
        </div>
    </div>
    {{-- <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo" onclick="select(this)">
        +  Add agendamento            
    </button> --}}
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
                      <input class="form-control" placeholder="dd/mm/yyyy" type="date" name="date" id="modal-date-input" min="2023-05-28">
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
                      {{-- @foreach ($procedimentos as $procedimento)
                        <div class="col">
                          
                          <input class="form-check-input" type="checkbox"  name="procedimento_key[]" value="{{$procedimento->id}}" role="switch" id="flexSwitchCheckChecked" > 
                          {{ $procedimento->nome }}
                         
                        </div>                     
                      @endforeach --}}
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
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
      locale: 'pt-br',
      height: 'auto',
      dateClick: function(info) {
        // Acionar o modal
        selectedDate = info.date;
        formattedDate = selectedDate.toISOString().slice(0, 10);
        console.log(formattedDate)
        document.getElementById('modal-date-input').value = formattedDate;

        var modal = new bootstrap.Modal(document.getElementById('exampleModal'));
        modal.show();
      },
      expandRows: true,
      slotMinTime: '08:00',
      slotMaxTime: '21:00',
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
      },
      initialView: 'dayGridMonth',
      initialDate: '2023-01-12',
      
      eventClick: function(arg) {
        if (confirm('Are you sure you want to delete this event?')) {
          arg.event.remove()
        }
      },

      navLinks: true, // can click day/week names to navigate views
      editable: true,
      selectable: true,
      nowIndicator: true,
      dayMaxEvents: true, // allow "more" link when too many events
      events: []
    });

    calendar.render();

    var addButton = document.querySelector('.btn.btn-success');
    addButton.addEventListener('click', function() {
      // Acionar o modal
      var modal = new bootstrap.Modal(document.getElementById('exampleModal'));
      modal.show();
    });

    $.ajax({
      url: '/eventos',
      method: 'GET',
      success: function(response) {
        var eventos = response;
        // Atualize a propriedade events do calendário com os eventos retornados
        calendar.setOption('events', eventos);
      },
      error: function() {
        console.log('Ocorreu um erro ao obter os eventos.');
      }
    });
  });
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@endsection

