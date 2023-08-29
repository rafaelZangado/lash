@extends('blanck')
@section('title', 'Procedimento')

@section('tela')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Procedimento</h4>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">
                    Add novo procedimento
                </button>

                <hr>
                <div class="table-responsive">
                    <table class="table table-hover" id="tabela_filter">
                        <thead>
                            <tr>
                                <th>Titulo</th>
                                <th>Descrição</th>
                                <th>R$ valor</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($procedimentos as $procedimento)
                                <tr>
                                    <td>{{ $procedimento->nome }}</td>
                                    <td>{{ $procedimento->descricao }}</td>
                                    <td>{{ $procedimento->preco }}</td>
                                    <td>
                                        <a href="#" type="button" class="btn btn-warning btn-icon-text"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editModal{{ $procedimento->id }}">
                                            <i class=" mdi mdi-border-color"></i>
                                        </a>

                                        <button type="button" class="btn btn-danger btn-icon-text"
                                            id="deletarProduto" onclick="delet(this)"
                                            value="{{ $procedimento->id }}">
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

    <!--MODAL-->

    <!-- Modal- Creat -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
            <h4 class="card-title">Novo procedimento.</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{route('procedimentoSave')}}">
                @csrf
                    <div class="form-group">
                        <input type="text" name='nome' class="form-control" id="exampleInputUsername1" placeholder="procedimento" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name='descricao' value='' class="form-control" id="exampleInputUsername1"  placeholder="Descrição" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name='preco' class="form-control" id="valor" id="exampleInputUsername1" onkeyup="moeda()" placeholder="R$ 0.00" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Salvar </button>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>

    <!--Modal - Editar-->
    @foreach ($procedimentos as $agendamento)
        <div class="modal fade " id="editModal{{ $agendamento->id }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="card-title">Editar Produto| {{$agendamento->nome}} </h4>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('procedimentoEdite', $agendamento->id) }}">
                            @csrf
                            @method('PUT')

                            <!-- Adicione os campos do formulário que deseja editar -->

                            <div class="form-group">
                                <input type="text" name='nome'
                                class="form-control"
                                value="{{$agendamento->nome}}"
                                placeholder="{{$agendamento->nome}}">
                            </div>
                            <div class="form-group">
                                <input type="text" name='descricao'
                                class="form-control"
                                value="{{$agendamento->descricao}}"
                                placeholder="{{$agendamento->descricao}}">
                            </div>
                            <div class="form-group">
                                <input type="text" name='preco'
                                class="form-control"
                                id="valor"
                                value="{{$agendamento->preco}}"
                                onkeyup="moeda()" placeholder="{{$agendamento->preco}}">
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Salvar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

    <script>
        function delet(e)
        {

            valorBotao = e.value;
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                icon: 'question',
                title: 'Excluir Produto',
                text: 'Você deseja realmente excluir esse iten ?',
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
                        url: '/procedimentoDelet/' + valorBotao,
                        method: 'GET',
                        success: function(arg) {
                           
                            window.location.href = 'procedimento'
                        },
                        error: function(error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Talvez você nao tenha permissão para excluir esse item, qualquer duvia entre em contato com o administrador GERAL !!.',
                            })
                        }
                    });
                }
            })
        }

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
  </script>
@endsection

