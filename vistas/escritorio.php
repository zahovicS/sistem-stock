<?php
//activamos almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
    header("Location: login.html");
} else {
    require 'header.php';
    if ($_SESSION['escritorio'] == 1) {

        require_once "../modelos/Consultas.php";
        $consulta = new Consultas();
        $rsptac = $consulta->totalcomprahoy();
        $regc = $rsptac->fetch_object();
        $totalc = $regc->total_compra;

        $rsptav = $consulta->totalventahoy();
        $regv = $rsptav->fetch_object();
        $totalv = $regv->total_venta;

        //obtener valores para cargar al grafico de barras
        $compras10 = $consulta->comprasultimos_10dias();
        $fechasc = '';
        $totalesc = '';
        while ($regfechac = $compras10->fetch_object()) {
            $fechasc = $fechasc . '"' . $regfechac->fecha . '",';
            $totalesc = $totalesc . $regfechac->total . ',';
        }


        //quitamos la ultima coma
        $fechasc = substr($fechasc, 0, -1);
        $totalesc = substr($totalesc, 0, -1);



        //obtener valores para cargar al grafico de barras
        $ventas12 = $consulta->ventasultimos_12meses();
        $fechasv = '';
        $totalesv = '';
        while ($regfechav = $ventas12->fetch_object()) {
            $fechasv = $fechasv . '"' . $regfechav->fecha . '",';
            $totalesv = $totalesv . $regfechav->total . ',';
        }


        //quitamos la ultima coma
        $fechasv = substr($fechasv, 0, -1);
        $totalesv = substr($totalesv, 0, -1);
?>
<div class="col-md-12">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Escritorio</h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="escritorio.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Escritorio</li>
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
            <div class="col-lg-6 col-12">
                <!-- small card -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3><strong>S/. <?php echo $totalc; ?> </strong></h3>
                        <p>Compras</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <a href="ingreso.php" class="small-box-footer">
                        Compras <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <!-- small card -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3><strong>S/. <?php echo $totalv; ?> </strong></h3>
                        <p>Ventas</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <a href="venta.php" class="small-box-footer">
                        Ventas <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-12">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">Compras de los ultimos 10 dias</h3>
                            <!-- <a href="javascript:void(0);">View Report</a> -->
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="compras" width="400" height="300"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">Ventas de los ultimos 12 meses</h3>
                            <!-- <a href="javascript:void(0);">View Report</a> -->
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="ventas" width="400" height="300"></canvas>

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

    require 'footer.php';
    ?>
<script>
//variables
const fechasc = [<?php echo $fechasc ?>]
const totalesc = [<?php echo $totalesc ?>]
const fechasv = [<?php echo $fechasv ?>]
const totalesv = [<?php echo $totalesv ?>]
</script>
<script src="./scripts/escritorio.js"></script>
<?php
}
ob_end_flush();
?>