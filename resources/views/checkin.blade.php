@extends('blanck')
@section('title', 'Meus Clientes')
@section('tela')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <p> Nome: &#128526; {{$checkin->cliente->nome }}</p>
            <p> Contato: {{ $checkin->cliente->whastapp}}</p>
            <h2>Total R$: <span id="tela">{{ $total }}</span>
                @if($myConfig->pre_schedule)
                    <span style="color: rgb(255, 2, 2)">
                        - {{ number_format($myConfig->pre_schedule, 2, ',', '.') }}
                    </span> =
                    <span style="color: rgb(3, 151, 25)">
                        {{ number_format ($total - $myConfig->pre_schedule , 2, ',', '.')}}
                    </span>
                @endif
            </h2>

            <hr>

            <div class="form-group container text-center">
                <div class="row row-cols-3">
                    <!-- Ativos -->
                    @php
                        $diferentes = array_diff($pro, $procedimentosPorId[$checkin->id]);
                    @endphp
                    @foreach ($pro as $key => $idDiferente)
                        <div class="col">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox"
                                    role="switch" name="procedimento_key[]"
                                    value="{{ $key }}"
                                    id="procedimento_key" {{ in_array($idDiferente, $diferentes) ? '' : 'checked' }} onclick="calculo(this)">
                                    {{ $idDiferente }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h3>Tipo de pagamento </h3>
                    <select id="payment" name="payment" class="form-control">
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
            <br>
            <div class="row">
                <div class="col">
                    <div class="mb-4">
                        <h3  class="form-label">Comentario</h3>                      
                        <textarea class="form-control" id='comment'
                        placeholder="Você pode registrar algum comentário aqui após a conclusão do atendimento."
                        rows="3" ></textarea>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <h3 for="formFileMultiple" class="form-label">Enviar fotos do atendimenro</h3>
                <label style="color: rgb(255, 2, 2)">⚠️ Ops, no momento esse campo ainda não esta disponivel</label>
                <input class="form-control" type="file" id="formFileMultiple" multiple disabled>
            </div>

            <h3 class="form-label">Marcar Retorno</h3>
            <label style="color: rgb(255, 2, 2)">⚠️ Ops, no momento esse campo ainda não esta disponivel</label>
            <div class="row">
                <div class="col">
                    <label>[Sugestão 21/09 ] </label>
                    <input class="form-control" type="date" multiple disabled>
                </div>

                <div class="col">
                    <label>[Sugestão 8h ] </label>
                    <input class="form-control" type="time" multiple disabled>
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
    var itens = [];
    var procedimentosall = [];
    function calculo(e) {
        $.ajax({
            url: '/teste',
            method: 'GET',
            success: function(response) {
                var checkboxes = document.querySelectorAll('#procedimento_key:checked');
                checkboxes.forEach(function(checkbox) {
                    itens.push(checkbox.value);
                });

                var filteredResponse = response.filter(function(item) {
                    return itens.includes(item.id.toString());
                });

                var totalSum = 0;
                filteredResponse.forEach(function(item) {
                    var preco = parseFloat(item.preco);
                    totalSum += preco;
                });

                document.getElementById('tela').innerHTML = totalSum.toFixed(2);
            },
            error: function(error) {
                reject(error);
            },
        });

        if(itens){
            itens = [];
        }
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
            title: 'Finalizar atendimento ?',
            text: 'Antes de encerrar o atendimenro verifique se está TUDO CERTO !',
            showCancelButton: true,
            confirmButtonText: 'Sim',
            cancelButtonText: 'Não',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                swalWithBootstrapButtons.fire(
                    'O atendimento foi concluído com sucesso!',
                    'success'
                )
                var procedimento_key =[]
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                var clienteId = {{ $checkin->cliente->id }};
                var checkboxes = document.querySelectorAll('#procedimento_key:checked');
                var payment = document.getElementById('payment').value;
                var comment = document.getElementById('comment').value;

                a = checkboxes.forEach(function(checkbox) {
                    procedimento_key.push(checkbox.value);
                });

                data = {
                    _token: csrfToken,
                    id: clienteId,
                    procedimento_key: procedimento_key,
                    payment: payment,
                    comment: comment
                };

                $.ajax({
                    url: '/up',
                    method: 'put',
                    data:data,
                    success: function(response) {
                        window.location.href = '/';
                    },
                    error: function(error) {
                        //console.error(error);
                    },
                });

            }
        })
    });


</script>
@endsection
