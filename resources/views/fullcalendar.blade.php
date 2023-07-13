@extends('blanck')
@section('title', 'Agendamento')
@section('tela')
    <script src="{{ asset('js/fullcalendar/index.global.js') }}"></script>
    <script src="{{ asset('js/fullcalendar/pt-br.global.js') }}"></script>
    <!-- Include a required theme -->
    <script src="sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
                    <div class="card" style="width: 18rem;">
                        <div class="card-body">

                            <h5 class="card-title">
                                <div id="title"></div>
                            </h5>

                            <p class="card-text">
                            <div id="contato"></div>
                            </p>
                        </div>

                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <div id="procedimentos"></div>
                            </li>
                        </ul>
                        <h4>
                            <div id="total"></div>
                        </h4>
                        <div class="card-body">

                            <button type="button" class="btn btn-primary btn-rounded btn-icon-text" id="buttonplay"
                                value="">
                                <i class="mdi mdi-play-circle-outline"></i>
                            </button>

                            <button type="button" class="btn btn-danger btn-icon-text" id="buttoncancelatendimento"
                                value="">
                                <i class="mdi mdi-delete-forever"></i>
                            </button>

                             <button type="button" class="btn btn-warning btn-icon-text"
                                 data-bs-toggle="modal"
                                 data-bs-target="#editar"
                                  id="buttonedite"
                                value="">
                                <i class="mdi mdi-cached"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <label>Descrição </label>
    <hr>
    <b style="color: #32CD32">Agendamento  </b><br> <b style="color: #9400D3">Retorno </b>
    <!--CRIAR AGENDAMENTO-->
    <div class="modal fade col-lg-12" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog  modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="card-title">Criar novo agendamento.</h4>
                </div>
                <form class="forms-sample" method="POST" action="{{ route('atendimentosave') }}" id="agendamento-form">
                    <div class="modal-body">
                        @csrf

                        <div class="row form-group">
                            <div class="col">
                                <input class="form-control" placeholder="dd/mm/yyyy" type="date" name="date"
                                    id="modal-date-input" min="2023-05-28">
                            </div>
                            <div class="col">
                                <input class="form-control" type="time" id="appt" name="opening_hours" required>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col">
                                <input class="form-control" placeholder="999.999.999-99" type="text" name="cpf"
                                    id="date-input">
                            </div>
                            <div class="col">
                                <input class="form-control" placeholder="Nome" type="text" id="appt" name="nome"
                                    required>
                            </div>
                            <div class="col">
                                <input class="form-control" placeholder="whatsapp" type="text" id="appt"
                                    name="whatsapp" required>
                            </div>
                        </div>

                        <div class="container text-center">
                            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4">
                                @foreach ($procedimentos as $procedimento)
                                    <div class="col">
                                        <input class="form-check-input" type="checkbox" name="procedimento_key[]"
                                            value="{{ $procedimento->id }}" role="switch" id="flexSwitchCheckChecked">
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
        <div class="modal fade col-lg-12" id="editar" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog  modal-lg">
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
                            @php
                                $diferentes = array_diff($pro, $procedimentosPorId[$agendamento->id]);
                            @endphp

                            @foreach ($diferentes as $diferente)
                                <div class="col">
                                    <div class="form-check form-switch">
                                        <p>{{ $diferente }}</p>
                                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" >
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



    <script>

        document.getElementById('buttonplay').addEventListener('click', function() {

			valorBotao = this.value;
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                icon: 'question',
                title: 'Iniciar Atendimento',
                text: 'Você deseja realmente iniciar o atendimento ?°',
                showCancelButton: true,
                confirmButtonText: 'Sim',
                cancelButtonText: 'Não',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    swalWithBootstrapButtons.fire(
                        'Iniciando atendimento',
                        'procedimento iniciado com sucesso.',
                        'success'
                    )
                    $.ajax({
                        url: '/start/' + valorBotao + '/start',
                        method: 'GET',
                    });
                }
            })
        });


        document.getElementById('buttoncancelatendimento').addEventListener('click', function() {
			valorBotao = this.value;
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                icon: 'question',
                title: 'Excluir Atendimento',
                text: 'Você deseja realmente excluir o atendimento ?',
                showCancelButton: true,
                confirmButtonText: 'Sim',
                cancelButtonText: 'Não',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    swalWithBootstrapButtons.fire(
                        'atendimento excluido',
                        'que pena, o atendimento foi encerrado.',
                        'success'
                    )

                    $.ajax({
                        url: '/cancel/' + valorBotao + '/cancel',
                        method: 'GET',
						success: function(arg) {
							//arg.event.remove()
                        },
                        error: function(error) {
                           console.log('alguma coisa deu errado')
                        }
                    });
                }
            })
        });

        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                locale: 'pt-br',
                height: 'auto',
                dateClick: function(info) {
                    // Acionar o data no input do modal
                    selectedDate = info.date;
                    formattedDate = selectedDate.toISOString().slice(0, 10);

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
                initialDate:  new Date(),

                eventClick: function(arg) {

                    event = arg.event;
                    title = event.title;
                    start = event.start;
                    color = event.color;
                    contato = event.extendedProps.contato;
                    procedimentos = event.extendedProps.procedimentos;
                    id = event.id;
                    total = event.extendedProps.total;
                    end = event.end;
                    description = event.description;

                    console.log(arg)

                    document.getElementById("title").innerHTML = title;
                    document.getElementById("contato").innerHTML = contato;
                    document.getElementById("total").innerHTML = 'Total R$ ' + total;
                    document.getElementById("buttonplay").value = id;
                    document.getElementById("buttoncancelatendimento").value = id;

                    button = document.getElementById("buttonedite");
                    button.setAttribute("data-bs-target", "#" + id);

                    modal = document.getElementById("editar");
                    modal.setAttribute("id", id)

                    procedimentosContainer = document.getElementById("procedimentos");

                    procedimentosContainer.innerHTML = '';

                    procedimentos.forEach(function(procedimento) {
                        var ul = document.createElement("ul");
                        ul.classList.add("list-group", "list-group-flush");
                        var li = document.createElement("li");
                        li.classList.add("list-group-item");
                        li.innerHTML = procedimento;
                        ul.appendChild(li);
                        procedimentosContainer.appendChild(ul);
                    });
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
                    var eventos = response.map(function(evento) {

                        return {
                            id: evento.id,
                            title: evento.title,
                            start: evento.start,
                            end: evento.end,
                            color: evento.color,
                            contato: evento.contato,
                            procedimentos: evento.procedimentos,
                            total: evento.total,
                        };

                    });

                    // Atualize a propriedade 'events' do calendário com os eventos retornados
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
