@extends('blanck')
@section('title', 'Configuração')
@section('tela')


    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <div class="mb-3">
                    <h3 for="formFileMultiple" class="form-label">Minha Logo</h3>
                    <label style="color: rgb(255, 2, 2)">⚠️ Ops, no momento esse campo ainda não esta disponivel</label>
                    <input class="form-control" type="file" id="formFileMultiple" multiple disabled>
                </div>
                <hr>
                <div class="mb-3">
                    <h3 for="formFileMultiple" class="form-label">Estilo do painel</h3>
                    <h4 class="card-title">Cor Botoes </h4>
                </div>
                <div class="container text-center">
                    <div class="row">
                        <div class="col">
                            <label for="exampleColorInput" class="form-label">Botão salvar</label>
                                <input type="color" class="form-control form-control-color"
                                id="exampleColorInput"
                                value="#32CD32">
                        </div>

                        <div class="col">
                                <label for="exampleColorInput" class="form-label">Botão Deletar</label>
                                <input type="color" class="form-control form-control-color"
                                id="exampleColorInput"
                                value="#FF0000">
                        </div>

                        <div class="col">
                                <label for="exampleColorInput" class="form-label">Botão Editar</label>
                                <input type="color" class="form-control form-control-color"
                                id="exampleColorInput"
                                value="#FFFF00">
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-rounded btn-icon-text" id="buttonplay"
                        value="" >
                        Salavr
                    </button>
                </div>

            </div>
        </div>
    </div>

    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Descontos ou Promoções</h4>
                <p class="card-description">
                    configure os seus produtos ou procedimento para realizar descontos ou criar uma promoção.
                </p>



            </div>
        </div>
    </div>

    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Agendamentos</h4>
            <p class="card-description">
                configurações do agendamento
            </p>
            <div class="form-group">
              <label>Pré Agendamento</label>
              <input type="text" id="valor" class="form-control form-control-lg" placeholder="R$ 0.00" value="R$ 20,00" disabled>
            </div>
            <button type="button"
            class="btn btn-primary btn-rounded btn-icon-text"
            id="buttonplay" disabled>
                Salavr
            </button>
        </div>
    </div>

  


@endsection

