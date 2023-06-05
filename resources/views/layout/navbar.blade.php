<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" 
integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" 
crossorigin="anonymous">
</script>

<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  
<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav" id="menu">
    
    <li class="nav-item">
      <a class="nav-link" href="{{route('dashboard')}}" >
         <i class="icon-grid menu-icon"></i>
         <span class="material-icons"></span>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>

    <li class="nav-item">
      <a id="link-agendamento" class="nav-link" href="{{route('agendamento')}}" aria-controls="ui-basic" >    {{-- style="background: #4B49AC" --}}     
        <i class="mdi mdi-calendar-clock menu-icon" ></i>{{--style="color: #fff"--}}  
        <span class="menu-title" >{{--style="color: #fff"--}}
        Agendamento
        </span>
      </a>
    </li>

    <li class="nav-item">
      <a id="link-procedimento" class="nav-link"  href="{{route('procedimento')}}" aria-controls="ui-basic">
        <i class="icon-columns menu-icon"></i>
        <span class="menu-title">
          Registrar procedimento
        </span>       
      </a>
    </li>

    <li class="nav-item">
      <a id="link-clientes" class="nav-link"  href="{{route('clientes')}}" 
      aria-expanded="false" aria-controls="auth">
        <i class="icon-head menu-icon"></i>
        <i class="fas fa-shield-alt"></i>       
        <span class="menu-title">
          Meus clientes
        </span>        
      </a>
    </li>
 
    <li class="nav-item">
      <a class="nav-link" onclick="loadContent('views/anamnese.php')">
        <i class="icon-paper menu-icon"></i>
        <span class="menu-title">Ficha anamnese</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="{{route('atendimento')}}">
        <i class="icon-paper menu-icon"></i>
        <span class="menu-title">Atendimento</span>
      </a>
    </li>
    
  </ul>
</nav>

