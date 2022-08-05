<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Gestion RH</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/css/app.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper" id="app">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">

    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
          <a class="nav-link" id="menu" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
      </li>
    </ul>

    <!-- SEARCH FORM -->
    

  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
      <span class="brand-text font-weight-light" style="margin-left: 30px">Préfecture de Fès</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="./img/profile/profile.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">
              Bonjour
                @switch( strval(Auth::user()->Sex) )
                    @case('Homme')
                       Mr.
                    @break


                    @case('Femme')
                        Mme.
                    @break
                 @endswitch
                {{ ucfirst (Auth::user()->nom) }}

          </a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          
          @can('isUser')
            <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
            <i class="nav-icon fa fa-list" style="color:lightseagreen"></i>
              <p>
                Mes Demandes
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/Demande_conge" class="nav-link">
                <i class="fa-solid fa-calendar-days fa-fw" style="margin-left: 15px"></i>
                  <p>Congé</p>
                </router-link>
                <router-link to="/Demande_document_RH" class="nav-link" >
                <i class="fa-solid fa-file fa-fw" style="margin-left: 15px"></i>
                  <p>Document RH</p>
                </router-link>
              </li>
            </ul>
          </li>
          @endcan

          @can('isAdmin')
          <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
          <i class="nav-icon fa fa-list" style="color:lightseagreen"></i>
            <p>
              Mes Demandes
              <i class="right fa fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <router-link to="/Demande_conge" class="nav-link">
              <i class="fa-solid fa-calendar-days fa-fw" style="margin-left: 15px"></i>
                <p>Congé</p>
              </router-link>
              <router-link to="/Demande_document_RH" class="nav-link" >
              <i class="fa-solid fa-file fa-fw" style="margin-left: 15px"></i>
                <p>Document RH</p>
              </router-link>
            </li>
          </ul>
        </li>
        @endcan


         <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-file-circle-check" style="color:lightskyblue"></i>
              <p>
                Depot d'une demande
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/Depot_Demande_conge" class="nav-link">
                <i class="fa-solid fa-calendar-days fa-fw" style="margin-left: 15px"></i>
                  <p>Congé</p>
                </router-link>
                <router-link to="/Depot_Demande_document_RH" class="nav-link">
                <i class="fa-solid fa-file fa-fw" style="margin-left: 15px"></i>
                  <p>Document RH</p>
                </router-link>
              </li>
            </ul>
          </li>
          @can('isAuthor')
          <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
          <i class="nav-icon fa fa-list" style="color:yellow"></i>
            <p>
              Mes Demandes
              <i class="right fa fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <router-link to="/Demande_conge" class="nav-link">
              <i class="fa-solid fa-calendar-days fa-fw"></i>
                <p>Congé</p>
              </router-link>
              <router-link to="/Demande_document_RH" class="nav-link">
              <i class="fa-solid fa-file fa-fw"></i>
                <p>Document RH</p>
              </router-link>
            </li>
          </ul>
        </li>
        @endcan

          @can('isAuthor')
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
            <i class="nav-icon fa fa-cog" style="color:GreenYellow"></i>
              <p>
                Liste des demandes
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/Demande_conge_chef" class="nav-link">
                <i class="fa-solid fa-calendar-days fa-fw"></i>
                  <p>Congé</p>
                </router-link>
                <router-link to="/Demande_document_RH_chef" class="nav-link">
                <i class="fa-solid fa-file fa-fw"></i>
                  <p>Document RH</p>
                </router-link>
              </li>
            </ul>
          </li>
          @endcan
          @can('isAdmin')
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-cog" style="color:GreenYellow"></i>
              <p>
                Management
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/users" class="nav-link">
                  <i  class="fas fa-users nav-icon"></i>
                  <p>Utilisateurs</p>
                </router-link>
                <router-link to="/Division" class="nav-link">
                  <i class="fas fa-layer-group nav-icon"></i>
                  <p>Divisions</p>
                </router-link>

                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                  <i class="nav-icon fa fa-list" ></i>
                    <p>
                      Demandes
                      <i class="right fa fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <router-link to="/Demande_conge_all" class="nav-link">
                      <i class="fa-solid fa-calendar-days fa-fw"></i>
                        <p>Congé</p>
                      </router-link>
                      <router-link to="/Demande_document_RH_all" class="nav-link">
                      <i  class="fa-solid fa-file fa-fw"></i>
                        <p>Document RH</p>
                      </router-link>
                    </li>
                  </ul>
                </li>
              </li>

            </ul>
          </li>

         @endcan
          <li class="nav-item">
                <router-link to="/profile" class="nav-link">
                    <i class="nav-icon fas fa-user" style="color:lightcoral"></i>
                    <p>
                        Profil
                    </p>
                </router-link>
         </li>

          <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                              document.getElementById('logout-form').submit();">
                    <i class="nav-icon fa fa-power-off " style="color:red"></i>
                    <p>
                        {{ __('Déconnexion') }}
                    </p>
                 </a>

             <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                 @csrf
             </form>
        </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <router-view></router-view>

        <vue-progress-bar></vue-progress-bar>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


  <!-- Main Footer -->
  <footer class="main-footer">

  </footer>
</div>
<!-- ./wrapper -->

<script src="/js/app.js"></script>
</body>
</html>
