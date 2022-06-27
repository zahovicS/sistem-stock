<?php
//activamos almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
  header("Location: login.html");
} else {


  require 'header.php';

  if ($_SESSION['almacen'] == 1) {

?>
<div class="col-md-12">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Categoría <button class="btn btn-success" onclick="mostrarform(true)"
                            id="btnagregar"><i class="fa fa-plus-circle"></i>Agregar</button></h1>

                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="escritorio.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Categoría</li>
                    </ol>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel-body table-responsive" id="listadoregistros">
                    <div id="tbllistado"></div>
                </div>
                <div class="card card-success" id="formularioregistros">
                    <div class="card-header">
                        <h3 class="card-title">Agregar/Editar categoría</h3>
                    </div>
                    <div class="card-body">
                        <form action="" name="formulario" id="formulario" method="POST">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="">Nombre</label>
                                    <input class="form-control" type="hidden" name="idcategoria" id="idcategoria">
                                    <input class="form-control" type="text" name="nombre" id="nombre" maxlength="50"
                                        placeholder="Nombre" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">Descripcion</label>
                                    <input class="form-control" type="text" name="descripcion" id="descripcion"
                                        maxlength="256" placeholder="Descripcion">
                                </div>
                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i>
                                    Guardar</button>
                                <button class="btn btn-danger" onclick="cancelarform()" type="button"><i
                                        class="fa fa-arrow-circle-left"></i> Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                            <thead>
                                <th>Opciones</th>
                                <th>Nombre</th>
                                <th>Descripcion</th>
                                <th>Estado</th>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <th>Opciones</th>
                                <th>Nombre</th>
                                <th>Descripcion</th>
                                <th>Estado</th>
                            </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" style="height: 400px;" id="formularioregistros">
                        <form action="" name="formulario" id="formulario" method="POST">
                            <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                <label for="">Nombre</label>
                                <input class="form-control" type="hidden" name="idcategoria" id="idcategoria">
                                <input class="form-control" type="text" name="nombre" id="nombre" maxlength="50"
                                    placeholder="Nombre" required>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                <label for="">Descripcion</label>
                                <input class="form-control" type="text" name="descripcion" id="descripcion"
                                    maxlength="256" placeholder="Descripcion">
                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i>
                                    Guardar</button>

                                <button class="btn btn-danger" onclick="cancelarform()" type="button"><i
                                        class="fa fa-arrow-circle-left"></i> Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div> -->
<?php
  } else {
    require 'noacceso.php';
  }

  require 'footer.php';
  ?>
<script src="scripts/categoria.js"></script>
<?php
}

ob_end_flush();
?>