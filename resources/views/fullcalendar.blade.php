@extends('dashboard') <!-- Agora agenda.blade.php estende dashboard.blade.php -->

@section('agenda')
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
            font-size: 103%;
            padding: 0;
        }

        .custom-border-cancelado {
            border-left: 4px solid rgb(255, 30, 0)!important; /* Cor da borda para o primeiro elemento */
        }

        .custom-border-agendado {
            border-left: 4px solid rgb(69, 183, 3)!important; /* Cor da borda para o segundo elemento */
        }

        .custom-border-retorno {
            border-left: 4px solid rgb(255, 215, 0)!important; /* Cor da borda para o terceiro elemento */
        }

        .custom-border-feriado {
            border-left: 4px solid rgb(239, 16, 255)!important; /* Cor da borda para o terceiro elemento */
        }
        .custom-border-confreturn {
            border-left: 4px solid rgb(255, 116, 16)!important; /* Cor da borda para o terceiro elemento */
        }
    </style>
    <div class="row">
        <div class="col-md-4">
           <div class="fc-external-events">
                <div class="fc-event custom-border-cancelado">
                    <p>Atendimento cancelado</p>
                    <p class="small-text"></p>
                    <p class="text-muted mb-0">cancelado</p>
                </div>
                <div class="fc-event custom-border-agendado">
                    <p>Atendimento agendado</p>
                    <p class="small-text"></p>
                    <p class="text-muted mb-0">agendamento</p>
                </div>
                <div class="fc-event custom-border-retorno">
                    <p>Retorno do atendimento</p>
                    <p class="small-text"></p>
                    <p class="text-muted mb-0">Retorno</p>
                </div>
                <div class="fc-event custom-border-feriado">
                    <p>Feriado</p>
                    <p class="small-text"></p>
                    <p class="text-muted mb-0">Feriado / Data </p>
                </div>
                <div class="fc-event custom-border-confreturn">
                    <p>Confirmar retorno</p>
                    <p class="small-text"></p>
                    <p class="text-muted mb-0">Voce deve confirmar o retorno do atendimento</p>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <center>
                  <p class="card-title">
                        🥳🎊🎉 Aniversariante do Mes 🥳🎊🎉
                    </p>
                </center>
                  <div class="list-wrapper pt-4">
                      <ul class="icon-data-list">
                          <li>
                              <div class="d-flex">
                              <div>
                                    <p class="text-info mb-1">Isabella Becker</p>
                                    <p class="mb-0">Data 15/ Julho / 2023 (<b>HOJE</b>)</p>
                                    <p class="text-muted mb-0">
                                        <a href="#"> Desconto de 10% </a>
                                    </p>
                                    <label>Uma mensagem será enviada para esse cliente HOJE !!! </label>
                              </div>
                              </div>
                          </li>

                          <li>
                              <div class="d-flex">
                              <div>
                                    <p class="text-info mb-1">Maria silvar</p>
                                    <p class="mb-0">Data 16/ Julho / 2023 (<b>AMANHÃ</b>)</p>
                                    <p class="text-muted mb-0">
                                        <a href="#"> Desconto de 10% </a>
                                    </p>
                                    <label>Uma mensagem será enviada para esse cliente AMANHÃ !!! </label>
                              </div>
                              </div>
                          </li>

                          <li>
                              <div class="d-flex">
                              <div>
                                    <p class="text-info mb-1">Julia Campos</p>
                                    <p class="mb-0">Data 24/ Julho / 2023 </p>
                                    <p class="text-muted mb-0">
                                        <a href="#"> Desconto de 10% </a>
                                    </p>
                                    <label>Uma mensagem será enviada para esse cliente</label>
                              </div>
                              </div>
                          </li>
                      </ul>
                  </div>
                </div>
            </div>
        </div>

        <div class="col-md-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div id='calendar'></div>
                </div>
            </div>
        </div>
    </div>

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
                                <input class="form-control" placeholder="999.999.999-99" type="text" id="cpf"  maxlength="14" name="cpf"
                                    id="date-input">
                            </div>
                            <div class="col">
                                <input class="form-control" placeholder="Nome" type="text" id="appt" name="nome"
                                    required>
                            </div>
                            <div class="col">

                                <input class="form-control" placeholder="(99) 9 9999-9999" type="text" id="phone" onkeypress="mask(this, mphone);" onblur="mask(this, mphone);"
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

    <!--CRIAR AGENDAMENTO-->
    <div class="modal fade col-lg-12" id="modalCalendario" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog  modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="card-title">Atendimento para - <div id="title"></div></h4>
                </div>
                <div class="card">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Contato</th>
                                <th scope="col">Procedimento</th>
                                <th scope="col">R$ TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">
                                    <div id="contato"></div>
                                </th>
                                <td>
                                    <div id="procedimentos"></div>
                                </td>
                                <td>
                                    <div id="total"></div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="modal-footer">
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

    <!--REMANEJAR ATENDIMENTO-->
    @foreach ($agendamentos as $agendamento)
        <!-- Modal -->
        <div class="modal fade col-lg-12" id="editar-{{$agendamento->id}}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="card-title">Iniciar Atendimento | {{$agendamento->cliente->nome}} </h4>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('agendamento-update', $agendamento->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <input class="form-control" placeholder="dd/mm/yyyy" type="date" name="data"
                                    value="{{ $agendamento->data }}" id="date-input" min="2023-05-28">
                            </div>

                            <div class="form-group">
                                <input class="form-control" type="time" id="appt" value="{{$agendamento->opening_hours }}" name="opening_hours" min="09:00" max="18:00" required>
                            </div>

                            <div class="form-group container text-center">
                                <div class="row row-cols-3">
                                    <!-- Ativos -->
                                    @php
                                        $diferentes = array_diff($pro, $procedimentosPorId[$agendamento->id]);
                                    @endphp
                                    @foreach ($pro as $key => $idDiferente)
                                        <div class="col">
                                            <div class="form-check form-switch">
                                                <p>{{ $idDiferente }}</p>
                                                <input class="form-check-input" type="checkbox"
                                                    role="switch" name="procedimento_key[]"
                                                    value="{{ $key }}"
                                                    id="flexSwitchCheckChecked" {{ in_array($idDiferente, $diferentes) ? '' : 'checked' }} >
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success btn-rounded btn-fw">Salvar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <script>
        document.getElementById('cpf').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            const length = value.length;

            if (length > 3 && length <= 6) {
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            } else if (length > 6 && length <= 9) {
            value = value.replace(/(\d{3})(\d{3})(\d)/, '$1.$2.$3');
            } else if (length > 9) {
            value = value.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
            }

            e.target.value = value;
        });
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

                    // Exibir o modal
                    var modal = new bootstrap.Modal(document.getElementById('modalCalendario'));
                    modal.show();

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

                    document.getElementById("title").innerHTML = title;
                    document.getElementById("contato").innerHTML = contato;
                    document.getElementById("total").innerHTML = 'Total R$ ' + total;
                    document.getElementById("buttonplay").value = id;
                    document.getElementById("buttoncancelatendimento").value = id;

                    button = document.getElementById("buttonedite");
                    button.setAttribute("data-bs-target", "#editar-" + id);

                    modal = document.getElementById("editar");

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

                    modal.setAttribute("id", "editar-" + id);
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
