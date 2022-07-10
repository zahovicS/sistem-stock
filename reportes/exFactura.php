<?php
//activamos almacenamiento en el buffer
ob_start();
require_once '../libs/dompdf/autoload.inc.php';
require_once "Letras.php";

use Dompdf\Dompdf;

if (strlen(session_id()) < 1)
  session_start();

if (!isset($_SESSION['nombre'])) {
  echo "debe ingresar al sistema correctamente para visualizar el reporte";
} else {

  if ($_SESSION['ventas'] == 1) {

    //obtenemos los datos de la cabecera de la venta actual
    require_once "../modelos/Venta.php";
    $venta = new Venta();
    $rsptav = $venta->ventacabecera($_GET["id"]);
    //recorremos todos los valores que obtengamos
    $ventaCabecera = $rsptav->fetch_object();
    //obtenemos todos los detalles del a venta actual
    $ventaDetalle = $venta->ventadetalles($_GET["id"]);
    $detalles = [];
    while ($regd = $ventaDetalle->fetch_object()) {
      array_push($detalles, [
        "CODIGO" => "$regd->codigo",
        "DESCRIPCION" => utf8_decode("$regd->articulo"),
        "CANTIDAD" => number_format($regd->cantidad, 2, ".", ","),
        "PU" => "$regd->precio_venta",
        "DSCTO" => "$regd->descuento",
        "SUBTOTAL" => "$regd->subtotal"
      ]);
    }
    /*aqui falta codigo de letras*/
    $V = new EnLetras();
    $V->substituir_un_mil_por_mil = true;
    $con_letra = strtoupper($V->ValorEnLetras($ventaCabecera->total_venta, " " . NOMBRE_MONEDA_EMPRESA));
    // dd($ventaCabecera);
    //PDF de la factura
    require_once("PDF/comprobante.php");
    $view = ob_get_clean();
    $dompdf = new Dompdf();
    $dompdf->setPaper(array(0, 0, 226.77, 226.77));
    $dompdf->loadHtml($view);
    $dompdf->render();
    $page_count = $dompdf->getCanvas()->get_page_number();
    unset($dompdf);
    $dompdf = new Dompdf();
    $dompdf->setPaper(array(0, 0, 226.77, 226.77 * $page_count + 20));
    $dompdf->loadHtml($view);
    $dompdf->render();
    $dompdf->stream(DOCUMENTO_EMPRESA . "_" . strtoupper($ventaCabecera->tipo_comprobante) . "_" . $ventaCabecera->serie . "-" . $ventaCabecera->num_comprobante . ".pdf", ['Attachment' => false]);
    exit(0);
  } else {
    echo "No tiene permiso para visualizar el reporte";
  }
}

ob_end_flush();