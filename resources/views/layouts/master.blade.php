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
          <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
      </li>
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fa fa-search"></i>
          </button>
        </div>
      </div>
    </form>

  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
      <span class="brand-text font-weight-light">Gestion RH</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="./img/profile.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">
              {{Auth::user()->nom}}
          </a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

            <!-- <li class="nav-item">
            <router-link to="/dashboard" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt "></i>
                <p>
                Tableau de bord

                </p>
            </router-link>
            </li> -->
            @can('isAdmin')
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
                  <p>Demande de congé</p>
                </router-link>
                <router-link to="/Demande_document_RH_all" class="nav-link">
                <i class="fa-solid fa-file fa-fw"></i>
                  <p>Demande de document RH</p>
                </router-link>
              </li>
            </ul>
          </li>
            @endcan
            @can('isUser')
            <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
            <i class="nav-icon fa fa-list" ></i>
              <p>
                Mes Demandes
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/Demande_conge" class="nav-link">
                <i class="fa-solid fa-calendar-days fa-fw"></i>
                  <p>Demande de congé</p>
                </router-link>
                <router-link to="/Demande_document_RH" class="nav-link">
                <i class="fa-solid fa-file fa-fw"></i>
                  <p>Demande de document RH</p>
                </router-link>
              </li>
            </ul>
          </li>
          @endcan
          @can('isAuthor')
            <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
            <i class="nav-icon fa fa-list" ></i>
              <p>
                Mes Demandes
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/Demande_conge" class="nav-link">
                <i class="fa-solid fa-calendar-days fa-fw"></i>
                  <p>Demande de congé</p>
                </router-link>
                <router-link to="/Demande_document_RH" class="nav-link">
                <i class="fa-solid fa-file fa-fw"></i>
                  <p>Demande de document RH</p>
                </router-link>
              </li>
            </ul>
          </li>
          @endcan
          @can('isUser')
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-cog "></i>
              <p>
                Depot d'une demande
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/Depot_Demande_conge" class="nav-link">
                <i class="fa-solid fa-calendar-days fa-fw"></i>
                  <p>Demande de congé</p>
                </router-link>
                <router-link to="/Depot_Demande_document_RH" class="nav-link">
                <i class="fa-solid fa-file fa-fw"></i>
                  <p>Demande de document RH</p>
                </router-link>
              </li>
            </ul>
          </li>
          @endcan
          @can('isAuthor')
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
            <i class="nav-icon fa-regular fa-rectangle-list"></i>
              <p>
                Liste des demandes
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/Demande_conge_chef" class="nav-link">
                <i class="fa-solid fa-calendar-days fa-fw"></i>
                  <p>Demande de congé</p>
                </router-link>
                <router-link to="/Demande_document_RH_chef" class="nav-link">
                <i class="fa-solid fa-file fa-fw"></i>
                  <p>Demande de document RH</p>
                </router-link>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-cog "></i>
              <p>
                Depot d'une demande
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/Depot_Demande_conge" class="nav-link">
                <i class="fa-solid fa-calendar-days fa-fw"></i>
                  <p>Demande de congé</p>
                </router-link>
                <router-link to="/Depot_Demande_document_RH" class="nav-link">
                <i class="fa-solid fa-file fa-fw"></i>
                  <p>Demande de document RH</p>
                </router-link>
              </li>
            </ul>
          </li>
          @endcan
          @can('isAdmin')
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-cog "></i>
              <p>
                Management
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/users" class="nav-link">
                  <i class="fas fa-users nav-icon"></i>
                  <p>Utilisateurs</p>
                </router-link>
                <router-link to="/Division" class="nav-link">
                  <i class="fas fa-layer-group pr-2" style='font-size:17px'></i>
                  <p>Divisions</p>
                </router-link>
              </li>

            </ul>
          </li>
          
          <!-- <li class="nav-item">
                <router-link to="/developer" class="nav-link">
                    <i class="nav-icon fas fa-cogs"></i>
                    <p>
                        Developpeur
                    </p>
                </router-link>
         </li> -->
         @endcan
          <li class="nav-item">
                <router-link to="/profile" class="nav-link">
                    <i class="nav-icon fas fa-user "></i>
                    <p>
                        Profil
                    </p>
                </router-link>
         </li>

          <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                              document.getElementById('logout-form').submit();">
                    <i class="nav-icon fa fa-power-off "></i>
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
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2022-2023 <a href="https://paypal.me/AraissiWalid">PayPal me</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<script src="/js/app.js"></script>
</body>
</html>
