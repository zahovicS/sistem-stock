 <?php
    if (strlen(session_id()) < 1)
        session_start();

    ?>
 <!DOCTYPE html>
 <html lang="es">

 <head>
     <meta charset="utf-8" />
     <meta name="viewport" content="width=device-width, initial-scale=1" />
     <title>SISVentas | Escritorio</title>

     <!-- Google Font: Source Sans Pro -->
     <link rel="stylesheet"
         href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />
     <!-- Font Awesome Icons -->
     <link rel="stylesheet" href="../public/plugins/fontawesome-free/css/all.min.css" />
     <!-- Grid JS -->
     <link href="https://cdn.jsdelivr.net/npm/gridjs/dist/theme/mermaid.min.css" rel="stylesheet" />
     <!-- IonIcons -->
     <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" />
     <!-- Theme style -->
     <link rel="stylesheet" href="../public/css/adminlte.min.css">
     <!-- Custom css -->
     <link rel="stylesheet" href="../public/css/app.css">
     <!-- Sweet Alert -->
     <link rel="stylesheet" href="../public/plugins/sweetalert2/sweetalert2.min.css" />
     <link rel="stylesheet" href="../public/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css" />
     <!-- Select 2 -->
     <link rel="stylesheet" href="../public/plugins/select2/css/select2.min.css" />
     <link rel="stylesheet" href="../public/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css" />

 </head>
 <!-- dark-mode -->

 <body class="hold-transition sidebar-mini control-sidebar-slide-open layout-navbar-fixed layout-fixed">
     <div class="wrapper">
         <!-- Navbar -->
         <nav class="main-header nav-flat navbar navbar-expand navbar-white navbar-light border-bottom-0">
             <!-- Left navbar links -->
             <ul class="navbar-nav">
                 <li class="nav-item">
                     <a class="nav-link" data-widget="pushmenu" href="javascript:void(0)" role="button"><i
                             class="fas fa-bars"></i></a>
                 </li>
             </ul>
             <!-- Right navbar links -->
             <ul class="navbar-nav ml-auto">
                 <li class="nav-item">
                     <a class="nav-link" data-widget="fullscreen" href="javascript:void(0)" role="button">
                         <i class="fas fa-expand-arrows-alt"></i>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a class="nav-link" href="javascript:void(0)" id="toggle-dark-mode" role="button">
                         <i class="far fa-moon"></i>
                     </a>
                 </li>
             </ul>
         </nav>
         <!-- /.navbar -->

         <!-- Main Sidebar Container -->
         <aside class="main-sidebar elevation-4 sidebar-dark-teal">
             <!-- Brand Logo -->
             <a href="javascript:void(0)" class="brand-link">
                 <img src="../public/img/AdminLTELogo.png" alt="AdminLTE Logo"
                     class="brand-image img-circle elevation-3" style="opacity: 0.8" />
                 <span class="brand-text font-weight-light">SIS VENTAS</span>
             </a>

             <!-- Sidebar -->
             <div class="sidebar">
                 <!-- Sidebar user panel (optional) -->
                 <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                     <div class="image">
                         <img src="../files/usuarios/<?php echo $_SESSION['imagen']; ?>" class="img-circle elevation-2"
                             alt="User Image" />
                     </div>
                     <div class="info">
                         <a href="javascript:void(0)" class="d-block"><?php echo $_SESSION['nombre']; ?></a>
                     </div>
                 </div>


                 <!-- Sidebar Menu -->
                 <nav class="mt-2">
                     <ul class="nav nav-flat nav-legacy nav-sidebar flex-column" data-widget="treeview" role="menu"
                         data-accordion="false">
                         <li class="nav-header">TIENDA</li>
                         <?php
                            if ($_SESSION['escritorio'] == 1) {
                                echo '<li class="nav-item">
                              <a href="escritorio.php" class="nav-link">
                                  <i class="nav-icon fas fa-tachometer-alt"></i>
                                  <p>Escritorio</p>
                              </a>
                          </li>';
                            }
                            ?>
                         <?php
                            if ($_SESSION['almacen'] == 1) {
                                echo '<li class="nav-item">
                <a href="javascript:void(0)" class="nav-link">
                    <i class="nav-icon fas fa-box-open"></i>
                    <p>
                        Almacen
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="articulo.php" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Productos</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="categoria.php" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Categorías</p>
                        </a>
                    </li>
                </ul>
            </li>';
                            }
                            ?>

                         <?php
                            if ($_SESSION['ventas'] == 1) {
                                echo '<li class="nav-item">
                <a href="javascript:void(0)" class="nav-link">
                    <i class="nav-icon fas fa-receipt"></i>
                    <p>
                        Ventas
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="venta.php" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Ventas</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="cliente.php" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Clientes</p>
                        </a>
                    </li>
                </ul>
            </li>';
                            }
                            ?>

                         <?php
                            if ($_SESSION['compras'] == 1) {
                                echo '<li class="nav-header">ADMINISTRACIÓN</li><li class="nav-item">
                <a href="javascript:void(0)" class="nav-link">
                    <i class="nav-icon fas fa-dollar-sign"></i>
                    <p>
                        Compras
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="ingreso.php" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Ingreso</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="proveedor.php" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Proveedor</p>
                        </a>
                    </li>
                </ul>
            </li>';
                            }
                            ?>
                         <?php
                            if ($_SESSION['acceso'] == 1) {
                                echo '
                <li class="nav-item">
                <a href="javascript:void(0)" class="nav-link">
                    <i class="nav-icon fas fa-key"></i>
                    <p>
                        Accesos
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="usuario.php" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Usuarios</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="permiso.php" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Permisos</p>
                        </a>
                    </li>
                </ul>
            </li>';
                            }
                            ?>
                         <?php
                            if ($_SESSION['consultac'] == 1) {
                                echo '<li class="nav-item">
                <a href="javascript:void(0)" class="nav-link">
                    <i class="nav-icon far fa-chart-bar"></i>
                    <p>
                      Consultar Compras
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="comprasfecha.php" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Compras por fechas</p>
                        </a>
                    </li>
                </ul>
            </li>';
                            }
                            ?>
                         <?php
                            if ($_SESSION['consultav'] == 1) {
                                echo '<li class="nav-item">
                <a href="javascript:void(0)" class="nav-link">
                    <i class="nav-icon fas fa-chart-line"></i>
                    <p>
                        Consultar Ventas
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="ventasfechacliente.php" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Consulta Ventas</p>
                        </a>
                    </li>
                </ul>
            </li>';
                            }
                            ?>
                         <li class="nav-item">
                             <a href="../ajax/usuario.php?op=salir" class="nav-link bg-danger">
                                 <i class="nav-icon fas fa-window-close"></i>
                                 <p>
                                     Cerrar sesión
                                     <!-- <span class="right badge badge-danger">New</span> -->
                                 </p>
                             </a>
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
                     <div class="row">