@extends('blanck')
@section('title', 'Procedimento')

@section('tela')

    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Procedimento</h4>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">
                    Add novo procedimento
                </button>

                <hr>
                <div class="table-responsive">
                <table class="table table-hover">
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
                                    <a href="{{ route('procedimentoEdite', ['id' => $procedimento->id]) }}">
                                        Editar
                                    </a> |
                                    <a href="{{ route('procedimentoDelet', ['id' => $procedimento->id]) }}">
                                        Deletar
                                    </a>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>

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
                    <input type="text" name='nome' class="form-control" id="exampleInputUsername1" placeholder="procedimento">
                </div>
                <div class="form-group">
                    <input type="text" name='descricao' class="form-control" id="exampleInputUsername1" placeholder="Descrição">
                </div>
                <div class="form-group">
                    <input type="text" name='preco' class="form-control" id="valor" id="exampleInputUsername1" onkeyup="moeda()" placeholder="R$ 0.00">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Salvar </button>
                </div>
            </form>
        </div>
        </div>
    </div>
    </div>

@endsection
