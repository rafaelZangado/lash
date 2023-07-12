<!DOCTYPE html>
<html>

<head>
    <title>@yield('title')</title>
    @include('layout/head')
</head>

<body>


    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
            <a class="navbar-brand brand-logo mr-5" href="index.html">
              {{-- MINHA LOGO
              <img src="images/logo.svg" class="mr-2" alt="logo" /> --}}
            </a>
            <a class="navbar-brand brand-logo-mini" href="index.html">
              {{-- MINHA OUTRA LOGO
              <img src="images/logo-mini.svg" alt="logo" /></a> --}}
        </div>
        {{-- <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <span class="icon-menu"></span>
        </button>
        <ul class="navbar-nav mr-lg-2">
          <li class="nav-item nav-search d-none d-lg-block">
            <div class="input-group">
              <div class="input-group-prepend hover-cursor" id="navbar-search-icon">
                <span class="input-group-text" id="search">
                  <i class="icon-search"></i>
                </span>
              </div>
              <input type="text" class="form-control" id="navbar-search-input" placeholder="Search now" aria-label="search" aria-describedby="search">
            </div>
          </li>
        </ul>    
       
      </div> --}}
    </nav>

    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper">
            {{-- CHAMANDO O NAVBAR --}}
            @include('layout/navbar')

            <div class="main-panel">
                <div class="content-wrapper">
                    <div id="content">
                        @yield('tela')
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="{{ asset('select2/select2.min.js') }}"></script>
    <script src="{{ asset('js/select2.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    {{-- <script src="{{ asset('js/vendor.bundle.base.js') }}"></script> --}}


</body>

</html>
