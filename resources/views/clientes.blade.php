@extends('blanck')
@section('title', 'Meus Clientes')
@section('tela')  
  <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
          <div class="card-body">
          <h4 class="card-title"> <i class="ti-user"></i> Cadastrar Cliente</h4>            
          <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">
              Add novo cliente            
          </button>
            <hr>
            <div class="table-responsive">
              <table class="table table-hover">
                  <thead>
                      <tr>
                          <th>Nome </th>
                          <th><i class="mdi ti-phone"></i>  WhastApp</th>
                          <th><i class="ti-instagram"></i> Instagram</th>                    
                      </tr>
                  </thead>
                  <tbody>
                      <tr>
                          <td>Rafael Santos Andrade </td>
                          <td><a href="#"> 98 9 87030735 </a></td>
                          <td><a href="#">@fael.andrade </a></td>                   
                      </tr>               
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
        <h4 class="card-title">Add novo cliente.</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form class="forms-sample" action="{{route('salvar')}}" method="POST">
          @csrf
              <div class="form-group">
                <input type="text" name="nome" class="form-control" id="exampleInputUsername1" placeholder="Nome completo">
              </div>
              <div class="form-group">
                <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
              </div>
              <div class="form-group">
                <input type="text" name="whastapp" class="form-control" id="exampleInputUsername1" placeholder="2º N contato / WhastApp">
              </div>
              <div class="form-group">
                <input type="text" name="instagram" class="form-control" id="exampleInputUsername1" placeholder="Instagram">
              </div>  
              
              <button>Salvar </button>
        
            </form>
        </div>
        <div class="modal-footer">
          {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary">Salvar </button> --}}
        </div>
      </div>
    </div>
  </div>
@endsection