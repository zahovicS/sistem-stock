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
                    <h1 class="m-0">Productos <button class="btn btn-success" onclick="mostrarform(true)"
                            id="btnagregar"><i class="fa fa-plus-circle"></i>Agregar</button> <a target="_blank"
                            href="../reportes/rptarticulos.php"><button class="btn btn-info">Reporte</button></a></h1>

                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="escritorio.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Productos</li>
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
                    <div id="tableArticulo"></div>
                </div>
                <div class="card card-success" id="formularioregistros">
                    <div class="card-header">
                        <h3 class="card-title">Agregar/Editar producto</h3>
                    </div>
                    <div class="card-body">
                        <form action="" name="formulario" id="formulario" method="POST">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="">Nombre(*):</label>
                                    <input class="form-control form-control-border border-width-2" type="hidden"
                                        name="idarticulo" id="idarticulo">
                                    <input class="form-control form-control-border border-width-2" type="text"
                                        name="nombre" id="nombre" maxlength="150" placeholder="Nombre" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">Categoria(*):</label>
                                    <select name="idcategoria" id="idcategoria"
                                        class="form-control form-control-border border-width-2 selectpicker"
                                        data-Live-search="true" required></select>
                                </div>
                                <div class="form-group col-lg-2">
                                    <label for="">Stock</label>
                                    <input class="form-control form-control-border border-width-2" type="number"
                                        name="stock" id="stock" required>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="">Descripción</label>
                                    <input class="form-control form-control-border border-width-2" type="text"
                                        name="descripcion" id="descripcion" maxlength="256" placeholder="Descripcion">
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="">Código:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button type="button" class="btn btn-danger"
                                                onclick="generarbarcode()">Generar</button>
                                        </div>
                                        <input class="form-control form-control-border border-width-2" type="text"
                                            name="codigo" id="codigo" placeholder="código del prodccto" required>
                                    </div>
                                </div>
                                <div class="form-group col-lg-12">
                                    <label for="">Imagen:</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="imagen" id="imagen">
                                        <input type="hidden" name="imagenactual" id="imagenactual">
                                        <label class="custom-file-label" for="customFile">Elija el archivo</label>
                                    </div>
                                    <img src="" alt="" width="150px" height="120" id="imagenmuestra">
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
<?php
    } else {
        require 'noacceso.php';
    }
    require 'footer.php'
    ?>
<script src="scripts/articulo.js"></script>

<?php
}
ob_end_flush();
?>