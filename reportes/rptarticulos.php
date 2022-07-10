<?php
//activamos almacenamiento en el buffer
ob_start();
require_once '../libs/dompdf/autoload.inc.php';

use Dompdf\Dompdf;

if (strlen(session_id()) < 1)
	session_start();

if (!isset($_SESSION['nombre'])) {
	echo "debe ingresar al sistema correctamente para vosualizar el reporte";
} else {

	if ($_SESSION['almacen'] == 1) {
		//creamos las filas de los registros según la consulta mysql
		require_once "../modelos/Articulo.php";
		$articulo = new Articulo();
		$rspta = $articulo->listar();
		$productos = [];
		while ($regd = $rspta->fetch_object()) {
			array_push($productos, [
				"CODIGO" => "$regd->codigo",
				"NOMBRE" => "$regd->nombre",
				"CATEGORIA" => "$regd->categoria",
				"STOCK" => "$regd->stock",
				"DESCRIPCION" => "$regd->descripcion",
			]);
		}
		// dd($productos);
		require_once("PDF/articulos.php");
		$view = ob_get_clean();
		$dompdf = new Dompdf();
		$dompdf->setPaper('A4', 'portrait');
		$dompdf->loadHtml($view);
		$dompdf->render();
		$dompdf->stream("Reporte de productos.pdf", ['Attachment' => false]);
		exit(0);
	} else {
		echo "No tiene permiso para visualizar el reporte";
	}
}

ob_end_flush();