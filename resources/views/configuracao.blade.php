@extends('blanck')
@section('title', 'Configuração')
@section('tela')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="row">


    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Descontos ou Promoções</h4>
                <p class="card-description">
                    Configure os seus produtos ou procedimentos para realizar descontos ou criar uma promoção.
                </p>
                <table class="table" id="tabela_filter">
                    <thead>
                        <tr>
                            <th scope="col">Produto</th>
                            <th scope="col">R$ </th>
                            <th scope="col">Desconto</th>
                            <th scope="col">Data início</th>
                            <th scope="col">Data Fim</th>
                            <th scope="col">Opção</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($procedimentos as $proce)
                            <tr>
                                <th scope="row">{{$proce->nome}}</th>
                                <td>{{$proce->preco}}</td>
                                <td>
                                    <input type="number" id="desconto{{$proce->id}}" name="desconto" class="form-control" placeholder="0%" max="100" min="1" aria-label="Desconto">
                                </td>
                                <td>
                                    <input type="date" class="form-control date-range-picker" id="dateinicio{{$proce->id}}" name="dateinicio" placeholder="Selecione o intervalo de datas">
                                </td>
                                <td>
                                    <input type="date" class="form-control date-range-picker" id="datefim{{$proce->id}}" name="datefim" placeholder="Selecione o intervalo de datas">
                                </td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-rounded btn-icon-text" id="buttonplay{{$proce->id}}" disabled>Salvar</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>



    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    Taxa pré-agendamento
                </h4>
                <div class="form-group">
                    <input type="text"
                        onkeyup="moedaModal(this)"
                        class="form-control form-control-lg"
                        id='preco'
                        value="{{$myconfig->pre_schedule}}"
                        placeholder="R$ 0.00" >
                </div>
                    <button type="button"
                    class="btn btn-primary btn-rounded btn-icon-text"
                    onclick="preagendamento()"
                    id="buttonplay"
                    value=""
                    >Salvar</button>
                </div>
            </div>
        </div>

        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Tempo Livre</h4>
                    <div class="form-group">
                        <input type="time" class="form-control form-control-lg" placeholder="15 Dias">
                    </div>
                    <button type="button" class="btn btn-primary btn-rounded btn-icon-text" id="buttonplay" disabled>Salvar</button>
                </div>
            </div>
        </div>

    </div>

    <div class="col-lg-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <h3 class="form-label">Minha Logo</h3>
                    <label style="color: rgb(255, 2, 2)">⚠️ Ops, no momento esse campo ainda não está disponível</label>
                    <input class="form-control" type="file" id="formFileMultiple" multiple disabled>
                </div>
                <hr>
                <div class="mb-3">
                    <h3 class="form-label">Estilo do painel</h3>
                    <h4 class="card-title">Cor Botões</h4>
                </div>
                <div class="container text-center">
                    <div class="row">
                        <div class="col">
                            <label class="form-label">Botão salvar</label>
                            <input type="color" class="form-control form-control-color" id="colorInputSalvar" value="#32CD32">
                        </div>
                        <div class="col">
                            <label class="form-label">Botão Deletar</label>
                            <input type="color" class="form-control form-control-color" id="colorInputEditar" value="#FF0000">
                        </div>
                        <div class="col">
                            <label class="form-label">Botão Editar</label>
                            <input type="color" class="form-control form-control-color" id="colorInputEditar" value="#FFFF00">
                        </div>
                        <div class="col">
                            <label class="form-label">Botão Menu</label>
                            <input type="color" class="form-control form-control-color" id="colorInputEditar" value="#4B49AC">
                        </div>
                    </div>
                </div>
                <br>
                <div class="mb-3">
                    <h4 class="card-title">Cor Plano de fundo</h4>
                </div>
                <div class="container text-center">
                    <div class="row">
                        <div class="col">
                            <label class="form-label">Plano de fundo</label>
                            <input type="color"
                            class="form-control form-control-color"
                            id="buttonBackground"
                            value="{{$myconfig->background}}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-rounded btn-icon-text"
                    id="buttonBackgroundSave" value="">Salvar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Dias de retorno</h4>
                <p class="card-description">
                    Configurações do retorno para o cliente.
                </p>
                <div class="row">
                    <button type="button" onclick="adicionarCampos()" class="btn btn-success btn-rounded btn-icon">+</button>
                    <div class="col">
                        <input type="text" class="form-control form-control-lg" id='day' value='15' placeholder="15 Dias">
                    </div>

                    <div class="col">
                        <input type="number" class="form-control form-control-lg" id='discount' value='0' placeholder="0%" max="100" min="0">
                    </div>

                    <button type="button" onclick="removerCampos(this)" class="btn btn-danger btn-rounded btn-icon">-</button>
                </div>
                <br>
                <button type="button" class="btn btn-primary btn-rounded btn-icon-text" id="buttonreturn" >Salvar</button>
            </div>
        </div>
    </div>




    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <script>

        document.getElementById('buttonreturn').addEventListener('click', function(){
            var day = document.getElementById('day').value;
            var discount = document.getElementById('discount').value;
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            data = {
                day: day,
                discount: discount,
            },

            $.ajax({
                url: 'local',
                method: 'post',
                data: data,
                success: function(response){

                }


            });

        });

        document.getElementById('buttonBackgroundSave').addEventListener('click', function(){
            var buttonBackground = document.getElementById('buttonBackground').value;

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                icon: 'question',
                title: 'Alterar plano de fundo',
                text: 'Você esta mudando o plano de fundo para cor '+ buttonBackground,
                showCancelButton: true,
                confirmButtonText: 'Sim',
                cancelButtonText: 'Não',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    swalWithBootstrapButtons.fire(
                        'Configuração realizada com sucesso.',
                        'success'
                    )
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');

                    console.log(preco)
                    data = {
                        _token: csrfToken,
                        background: buttonBackground
                    }

                    $.ajax({
                        url: '/preagenda',
                        method: 'POST',
                        data: data,
                        success: function(response) {
                            Swal.fire({
                                icon: 'sucess',
                                title: 'Plano de fundo alterado com sucesso',
                            })
                            window.location.href = '/myconfig';
                        },
                        error: function(error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Alguma coisa deu errada, verifique com o administrativo',
                            })
                        },
                    });

                }
            })


        })

        document.getElementById('buttonplay').addEventListener('click', function() {
            var preco = document.getElementById('preco').value;

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                icon: 'question',
                title: 'Adicionar Taxa',
                text: 'Você esta adicionando uma taxa de R$ ' + preco + ' para cada atendimento que for feito tera esse desconto',
                showCancelButton: true,
                confirmButtonText: 'Sim',
                cancelButtonText: 'Não',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    swalWithBootstrapButtons.fire(
                        'Configuração realizada com sucesso.',
                        'success'
                    )
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');

                    console.log(preco)
                    data = {
                        _token: csrfToken,
                        preco: preco,
                    }

                    $.ajax({
                        url: '/preagenda',
                        method: 'POST',
                        data: data,
                        success: function(response) {
                            Swal.fire({
                                icon: 'sucess',
                                title: 'Valor da Taxa configurado',
                                text: 'Tudo certo, voce configurou para que tenha um valor do pre agendamento.',
                            })
                            window.location.href = '/myconfig';
                        },
                        error: function(error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Alguma coisa deu errada, verifique com o administrativo',
                            })
                        },
                    });

                }
            })
        });


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
                });x
            });
        });

        function adicionarCampos() {
            const container = document.getElementById('container');

            // Cria os novos campos
            const newRow = document.createElement('div');
            newRow.className = 'row';

            const col1 = document.createElement('div');
            col1.className = 'col';
            const input1 = document.createElement('input');
            input1.type = 'text';
            input1.className = 'form-control form-control-lg';
            input1.placeholder = '15 Dias';
            input1.disabled = true;

            const col2 = document.createElement('div');
            col2.className = 'col';
            const input2 = document.createElement('input');
            input2.type = 'number';
            input2.className = 'form-control form-control-lg';
            input2.placeholder = '0%';
            input2.max = 100;
            input2.min = 0;
            input2.disabled = true;

            const button = document.createElement('button');
            button.textContent = '-';
            button.onclick = function() {
                removerCampos(button);
            };

            col1.appendChild(input1);
            col2.appendChild(input2);

            newRow.appendChild(col1);
            newRow.appendChild(col2);
            newRow.appendChild(button);

            container.appendChild(newRow);
        }

        function removerCampos(button) {
            const row = button.parentElement;
            const container = row.parentElement;
            container.removeChild(row);
        }
    </script>

@endsection

