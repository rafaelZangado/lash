@extends('blanck')
@section('title', 'Meus Clientes')
@section('tela')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <p> Nome: &#128526; {{$checkin->cliente->nome }}</p>
            <p> Contato: {{ $checkin->cliente->whastapp}}</p>
            <h2>Total R$: <b id='tela'>{{$total}}</b></h2>
            <hr>

            <div class="form-group container text-center">
                <div class="row row-cols-3">
                    <!-- Ativos -->
                    @php
                    $diferentes = array_diff($pro, $procedimentosPorId[$checkin->id]);
                    // dd($diferentes, $pro,  $procedimentosPorId[$checkin->id])
                @endphp

                    @foreach ($pro as $key => $idDiferente)
                        <div class="col">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox"
                                    role="switch" name="procedimento_key[]"
                                    value="{{ $key }}"
                                    id="procedimento_key" {{ in_array($idDiferente, $diferentes) ? '' : 'checked' }} onclick="calculo(this)">
                                {{ $idDiferente }} { {{$key}}}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h3>Tipo de pagamento </h3>
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
                        <option value="parceiro">
                            Parceria / Modelo / Treinamento
                        </option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">

            <button type="button" class="btn btn-primary btn-rounded btn-icon-text" id="buttonplay"
                value="" >
                Finalizar Checkin
            </button>
            </div>

        </div>
    </div>
</div>

<script>
    var itens = []; // Declaração global
    var total = [];
    totalSum = 0;
    function calculo(e, itens) {
        itens = this.itens
        key = e.value;

        var checkboxes = document.querySelectorAll('#procedimento_key:checked');

        checkboxes.forEach(function(checkbox) {
            itens.push(checkbox.value);
        });

        $.ajax({
            url: '/teste',
            method: 'GET',
            success: function(response) {
                var procedimentosall = response.filter(function(pro) {
                    return itens.includes(pro.id.toString());
                });
                procedimentosall.forEach(function(procedimento) {
                    v = parseFloat(procedimento.preco)
                    totalSum += v;
                });
                document.getElementById('tela').innerHTML = totalSum;
                console.log(totalSum)

            },
            error: function(error) {
                reject(error);
            },
        });
    }

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
                // $.ajax({
                //     url: '/start/' + valorBotao + '/start',
                //     method: 'GET',
                // });
            }
        })
    });


</script>
@endsection
