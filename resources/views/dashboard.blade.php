@extends('blanck')
@section('title', 'Dashboard')

@section('tela')

    <div class="row">
        <div class="col-12 col-sm-6 col-md-6 col-xl-3 stretch-card transparent">
            <div class="card card-tale">
            <div class="card-body">
                <p class="mb-4">Atendimento (Hoje)</p>
                <p class="fs-30 mb-2" id='hoje'></p>
            </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-6 col-xl-3 stretch-card transparent">
            <div class="card card-dark-blue">
                <div class="card-body">
                    <p class="mb-4">Atendimento (Amanhã)</p>
                    <p class="fs-30 mb-2" id='amanha'></p>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-6 col-xl-3 mb-lg-0 stretch-card transparent">
            <div class="card card-light-blue">
                <div class="card-body">
                    <p class="mb-4">Atendimento (Semana)</p>
                    <p class="fs-30 mb-2" id='semana'></p>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-6 col-xl-3 stretch-card transparent">
            <div class="card card-light-danger">
                <div class="card-body">
                    <p class="mb-4">CAIXA </p>
                    <p class="fs-30 mb-2"> 0</p>
                </div>
            </div>
        </div>
    </div>

    @yield('agenda')

@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        $.ajax({
            url: '/dashboard',
            method: 'GET',
            success: function(response) {
                var hoje = response.agendamentosHoje;
                var amanha = response.agendamentosAmanha;
                var semana = response.agendamentosUmaSemana;
                document.getElementById('hoje').innerHTML = hoje;
                document.getElementById('amanha').innerHTML = amanha;
                document.getElementById('semana').innerHTML = semana;
            },
        });
    });

</script>

