@extends('blanck')
@section('title', 'Dashboard')

@section('tela')

    <div class="row">
        <div class="col-12 col-sm-6 col-md-6 col-xl-3 stretch-card transparent">
            <div class="card card-tale">
            <div class="card-body">
                <p class="mb-4">Atendimento (Hoje)</p>
                <p class="fs-30 mb-2">0</p>
            </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-6 col-xl-3 stretch-card transparent">
            <div class="card card-dark-blue">
                <div class="card-body">
                    <p class="mb-4">Atendimento (Amanhã)</p>
                    <p class="fs-30 mb-2">0</p>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-6 col-xl-3 mb-lg-0 stretch-card transparent">
            <div class="card card-light-blue">
                <div class="card-body">
                    <p class="mb-4">Atendimento (Semana)</p>
                    <p class="fs-30 mb-2">0</p>
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
