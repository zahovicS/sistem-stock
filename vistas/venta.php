<?php
//activamos almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
  header("Location: login.html");
} else {


  require 'header.php';

  if ($_SESSION['ventas'] == 1) {

?>
<div class="col-md-12">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Ventas <button class="btn btn-success" onclick="mostrarform(true)"
                            id="btnagregar"><i class="fa fa-plus-circle"></i>Agregar</button></h1>

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
                    <div id="tbllistado"></div>
                </div>
                <div class="card card-info" id="formularioregistros">
                    <div class="card-header">
                        <h3 class="card-title">NUEVA VENTA</h3>
                    </div>
                    <div class="card-body">
                        <form action="" name="formulario" id="formulario" method="POST">
                            <div class="row">
                                <div class="form-group col-md-8">
                                    <label for="">Cliente(*):</label>
                                    <input class="form-control" type="hidden" name="idventa" id="idventa">
                                    <select name="idcliente" id="idcliente"
                                        class="form-control form-control-border border-width-2 selectpicker" required>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">Fecha(*): </label>
                                    <input class="form-control form-control-border border-width-2" type="date"
                                        name="fecha_hora" id="fecha_hora" required>
                                </div>
                                <div class="form-group col-lg-3">
                                    <label for="">Tipo Comprobante(*): </label>
                                    <select name="tipo_comprobante" id="tipo_comprobante"
                                        class="form-control form-control-border border-width-2 selectpicker" required>
                                        <option value="Boleta">Boleta</option>
                                        <option value="Factura">Factura</option>
                                        <option value="Ticket">Ticket</option>
                                    </select>
                                </div>
                                <div class="form-group col-lg-3">
                                    <label for="">Tipo pago(*): </label>
                                    <select name="tipo_pago" id="tipo_pago"
                                        class="form-control form-control-border border-width-2 selectpicker" required>
                                        <option value="C">Contado</option>
                                        <option value="T">Tarjeta</option>
                                    </select>
                                </div>
                                <!-- <div class="form-group col-lg-2">
                                    <label for="">Serie: </label>
                                    <input class="form-control form-control-border border-width-2" type="text"
                                        name="serie_comprobante" id="serie_comprobante" maxlength="7"
                                        placeholder="Serie">
                                </div>
                                <div class="form-group col-lg-2">
                                    <label for="">Número: </label>
                                    <input class="form-control form-control-border border-width-2" type="text"
                                        name="num_comprobante" id="num_comprobante" maxlength="10" placeholder="Número"
                                        required>
                                </div> -->
                                <div class="form-group col-lg-2">
                                    <label for="">Impuesto: </label>
                                    <input class="form-control form-control-border border-width-2" type="text"
                                        name="impuesto" id="impuesto" value="0" readonly>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="">Observación: </label>
                                    <textarea cols="30" rows="1" class="form-control form-control-border border-width-2"
                                        name="observacion" id="observacion"></textarea>
                                </div>

                            </div>
                            <div class="form-group col-12 px-0">
                                <button data-toggle="modal" data-target="#myModal" id="btnAgregarArt" type="button"
                                    class="btn btn-primary"><span class="fa fa-plus"></span>Agregar Articulos</button>
                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-xs-12 px-0">
                                <table id="detalles" class="table table-bordered table-condensed">
                                    <thead style="background-color:#E2EFFB">
                                        <th style="width: 6%;">Opciones</th>
                                        <th>Producto</th>
                                        <th style="width: 15%;">Cantidad</th>
                                        <th style="width: 15%;">Precio Venta</th>
                                        <th style="width: 15%;">Descuento</th>
                                        <th style="width: 10%;">Subtotal</th>
                                    </thead>
                                    <tfoot>
                                        <th colspan="5">TOTAL</th>
                                        <th>
                                            <h4 id="total">S/. 0.00</h4><input type="hidden" name="total_venta"
                                                id="total_venta">
                                        </th>
                                    </tfoot>
                                    <tbody id="cuerpoTablaVenta">

                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 px-0">
                                <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i>
                                    Guardar</button>
                                <button class="btn btn-danger" onclick="cancelarform()" type="button"
                                    id="btnCancelar"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Modal-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Seleccione un Articulo</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="tblarticulos"></div>
            </div>
            <div class="modal-footer justify-content-between">
                <button class="btn btn-danger" type="button" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- fin Modal-->
<?php
  } else {
    require 'noacceso.php';
  }

  require 'footer.php';
  ?>
<script src="scripts/venta.js"></script>
<?php
}

ob_end_flush();
?>