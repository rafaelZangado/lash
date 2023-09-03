@extends('blanck')
@section('title', 'Meus Clientes')
@section('tela')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
          <div class="card-body">
          <h4 class="card-title"> <i class="ti-user"></i> Cadastrar Cliente</h4>
          <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">
              Add novo cliente
          </button>
            <hr>
            @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
            <div class="table-responsive">
              <table class="table table-hover table-striped" id="tabela_filter">
                  <thead>
                      <tr>
                          <th>Nome </th>
                          <th>C.P.F</th>
                          <th>WhastApp</th>
                          <th>
                            Ação
                          </th>
                      </tr>
                  </thead>
                  <tbody>
                        @foreach ($clientes as $cliente)
                            <tr>
                                <td>{{$cliente->nome}}</td>
                                <td class="cpf-mask">{{$cliente->cpf}}</td>
                                <td class="phone-mask">{{$cliente->whastapp}}</td>
                                <td>
                                    <a href="#" type="button" class="btn btn-warning btn-icon-text"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editModal{{ $cliente->id }}">
                                        <i class=" mdi mdi-border-color"></i>
                                    </a>

                                    <button type="button" class="btn btn-danger btn-icon-text"
                                        onclick="delet(this)"
                                        value="{{ $cliente->id }}">
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
                <input type="text" name="cpf" class="form-control" id="cpf" placeholder="999.999.999-99" maxlength="14">
              </div>
              <div class="form-group">
                <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
              </div>
              <div class="form-group">
                <input type="text" name="whastapp" class="form-control" id="exampleInputUsername1" placeholder="WhastApp" onkeypress="mask(this, mphone);" onblur="mask(this, mphone);">
              </div>
              <div class="form-group">
                <input type="text" name="instagram" class="form-control" id="exampleInputUsername1" placeholder="Instagram">
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button class="btn btn-primary">Salvar </button>
              </div>
            </form>
        </div>

      </div>
    </div>
  </div>

   <!--Modal - Editar-->
   @foreach ($clientes as $cliente)
   <div class="modal fade " id="editModal{{ $cliente->id }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
       <div class="modal-dialog">
           <div class="modal-content">
               <div class="modal-header">
                   <h4 class="card-title">Editar Dados do Cliente| {{$cliente->nome}} </h4>
               </div>
               <div class="modal-body">
                   <form method="POST" action="{{ route('clientesEdite', $cliente->id) }}">
                       @csrf
                       @method('PUT')

                       <!-- Adicione os campos do formulário que deseja editar -->
                       <div class="form-group">
                           <input type="text" name='nome'
                           class="form-control"
                           value="{{$cliente->nome}}"
                           placeholder="{{$cliente->nome}}">
                       </div>
                       <div class="form-group">
                           <input type="text" name='cpf'
                           class="form-control"
                           maxlength="14"
                           id="cpfInput"
                           oninput="cpfModal(this)"
                           value="{{ substr($cliente->cpf, 0, 3) . '.' . substr($cliente->cpf, 3, 3) . '.' . substr($cliente->cpf, 6, 3) . '-' . substr($cliente->cpf, 9, 2)}}"
                           placeholder="{{$cliente->cpf}}">
                       </div>
                       <div class="form-group">
                           <input type="text" name='whastapp'
                           class="form-control"
                           id="valor"
                           value="{{'(' . substr($cliente->whastapp, 0, 2) . ') ' . substr($cliente->whastapp, 2, 5) . '-' . substr($cliente->whastapp, 7)}}"
                           onkeyup="moeda()" placeholder="{{'(' . substr($cliente->whastapp, 0, 2) . ') ' . substr($cliente->whastapp, 2, 5) . '-' . substr($cliente->whastapp, 7)}}">
                       </div>
                       <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                           <button type="submit" class="btn btn-primary">Salvar</button>
                       </div>
                   </form>
               </div>
           </div>
       </div>
   </div>
@endforeach

     <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

<script>
    $(document).ready(function() {
        $('.phone-mask').mask('(00) 00000-0000');
        $('.cpf-mask').mask('000.000.000-00', {reverse: true});

    });
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
              title: 'Excluir Cliente',
              text: 'Você deseja realmente excluir o cliente ?',
              showCancelButton: true,
              confirmButtonText: 'Sim',
              cancelButtonText: 'Não',
              reverseButtons: true
          }).then((result) => {
              if (result.isConfirmed) {
                  swalWithBootstrapButtons.fire(
                      'Cliente excluido',
                      'que pena, o cliente foi excluido do nosso sistema.',
                      'success'
                  )

                  $.ajax({
                      url: '/clientes/' + valorBotao,
                      method: 'GET',
                      success: function(arg) {
                            window.location.href = 'clientes'
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
