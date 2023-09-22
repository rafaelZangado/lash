<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
crossorigin="anonymous">
</script>

<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav" id="menu">

    <li class="nav-item">
        <a class="nav-link" style="background: {{ request()->is('/') ? '#4B49AC' : '' }}" href="{{route('atendimento')}}">
            <i class="icon-grid menu-icon" style="color: {{ request()->is('/*') ? '#fff' : '' }}"></i>
            <span class="material-icons"></span>
            <span class="menu-title" style="color: {{ request()->is('/*') ? '#fff' : '' }}">
                Dashboard
            </span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" style="background: {{ request()->is('procedimento') ? '#4B49AC' : '' }}"  href="{{route('procedimento')}}">
            <i class="icon-grid menu-icon" style="color: {{ request()->is('procedimento*') ? '#fff' : '' }}"></i>
            <span class="material-icons"></span>
            <span class="menu-title" style="color: {{ request()->is('procedimento*') ? '#fff' : '' }}">
                Procedimento
            </span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" style="background: {{ request()->is('clientes') ? '#4B49AC' : '' }}"  href="{{route('clientes')}}">
            <i class="icon-grid menu-icon" style="color: {{ request()->is('clientes*') ? '#fff' : '' }}"></i>
            <span class="material-icons"></span>
            <span class="menu-title" style="color: {{ request()->is('clientes*') ? '#fff' : '' }}">
                Clientes
            </span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" style="background: {{ request()->is('myconfig') ? '#4B49AC' : '' }}"  href="{{route('myconfig')}}">
            <i class="icon-grid menu-icon" style="color: {{ request()->is('myconfig*') ? '#fff' : '' }}"></i>
            <span class="material-icons"></span>
            <span class="menu-title" style="color: {{ request()->is('myconfig*') ? '#fff' : '' }}">
                Configuração
            </span>
        </a>
    </li>

  </ul>
</nav>

