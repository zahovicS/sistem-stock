<?php
require_once "../modelos/Venta.php";
if (strlen(session_id()) < 1)
	session_start();

$venta = new Venta();

$idventa = isset($_POST["idventa"]) ? limpiarCadena($_POST["idventa"]) : "";
$idcliente = isset($_POST["idcliente"]) ? limpiarCadena($_POST["idcliente"]) : "";
$idusuario = $_SESSION["idusuario"];
$tipo_comprobante = isset($_POST["tipo_comprobante"]) ? limpiarCadena($_POST["tipo_comprobante"]) : "";
// $serie_comprobante = isset($_POST["serie_comprobante"]) ? limpiarCadena($_POST["serie_comprobante"]) : "";
// $num_comprobante = isset($_POST["num_comprobante"]) ? limpiarCadena($_POST["num_comprobante"]) : "";
$fecha_hora = isset($_POST["fecha_hora"]) ? limpiarCadena($_POST["fecha_hora"]) : "";
$impuesto = isset($_POST["impuesto"]) ? limpiarCadena($_POST["impuesto"]) : "";
$total_venta = isset($_POST["total_venta"]) ? limpiarCadena($_POST["total_venta"]) : "";





switch ($_GET["op"]) {
	case 'guardaryeditar':
		if (empty($idventa)) {
			$rspta = $venta->insertar($idcliente, $idusuario, $tipo_comprobante, $fecha_hora, $impuesto, $total_venta, $_POST["idarticulo"], $_POST["cantidad"], $_POST["precio_venta"], $_POST["descuento"]);
			echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
		} else {
		}
		break;


	case 'anular':
		$rspta = $venta->anular($idventa);
		echo $rspta ? "Ingreso anulado correctamente" : "No se pudo anular el ingreso";
		break;

	case 'mostrar':
		$rspta = $venta->mostrar($idventa);
		echo json_encode($rspta);
		break;

	case 'listarDetalle':
		//recibimos el idventa
		$id = $_GET['id'];

		$rspta = $venta->listarDetalle($id);
		$total = 0;
		echo ' <thead style="background-color:#E2EFFB">
        <th  style="width: 6%;">Opciones</th>
        <th>Producto</th>
        <th  style="width: 15%;">Cantidad</th>
        <th  style="width: 15%;">Precio Venta</th>
        <th  style="width: 15%;">Descuento</th>
        <th style="width: 10%;">Subtotal</th>
       </thead><tbody id="cuerpoTablaVenta">';
		while ($reg = $rspta->fetch_object()) {
			echo '<tr class="filas">
			<td></td>
			<td>' . $reg->nombre . '</td>
			<td>' . $reg->cantidad . '</td>
			<td>' . $reg->precio_venta . '</td>
			<td>' . $reg->descuento . '</td>
			<td>' . $reg->subtotal . '</td></tr>';
			$total = $total + ($reg->precio_venta * $reg->cantidad - $reg->descuento);
		}
		echo '</tbody><tfoot>
         <th colspan="5">TOTAL</th>
         <th><h4 id="total">S/. ' . $total . '</h4><input type="hidden" name="total_venta" id="total_venta"></th>
       </tfoot>';
		break;

	case 'listar':
		$rspta = $venta->listar();
		$data = array();

		while ($reg = $rspta->fetch_object()) {
			$url = '../reportes/exFactura.php?id=';
			$data[] = array(
				"op" => (($reg->estado == 'Aceptado') ? '<button class="btn btn-warning btn-xs" onclick="mostrar(' . $reg->idventa . ')"><i class="fas fa-eye"></i></button>' . ' ' . '<button class="btn btn-danger btn-xs" onclick="anular(' . $reg->idventa . ')"><i class="fas fa-times"></i></button>' : '<button class="btn btn-warning btn-xs" onclick="mostrar(' . $reg->idventa . ')"><i class="fas fa-eye"></i></button>') .
					'<a target="_blank" href="' . $url . $reg->idventa . '"> <button class="btn btn-info btn-xs"><i class="fas fa-receipt"></i></button></a>',
				"fecha" => $reg->fecha,
				"clie" => $reg->cliente,
				"user" => $reg->usuario,
				"tipo" => $reg->tipo_comprobante,
				"numero" => $reg->serie . '-' . $reg->num_comprobante,
				"total" => $reg->total_venta,
				"est" => ($reg->estado == 'Aceptado') ? '<span class="badge badge-success">Aceptado</span>' : '<span class="badge badge-danger">Anulado</span>'
			);
		}
		$results = array(
			"sEcho" => 1, //info para datatables
			"iTotalRecords" => count($data), //enviamos el total de registros al datatable
			"iTotalDisplayRecords" => count($data), //enviamos el total de registros a visualizar
			"aaData" => $data
		);
		echo json_encode($results);
		break;

	case 'selectCliente':
		require_once "../modelos/Persona.php";
		$persona = new Persona();

		$rspta = $persona->listarc();

		while ($reg = $rspta->fetch_object()) {
			echo '<option value=' . $reg->idpersona . '>' . $reg->nombre . '</option>';
		}
		break;

	case 'listarArticulos':
		require_once "../modelos/Articulo.php";
		$articulo = new Articulo();

		$rspta = $articulo->listarActivosVenta();
		$data = array();

		while ($reg = $rspta->fetch_object()) {
			$data[] = array(
				"op" => '<button class="btn btn-warning btn-sm" onclick="agregarDetalle(' . $reg->idarticulo . ',\'' . $reg->nombre . '\',' . $reg->precio_venta . ')"><span class="fa fa-plus"></span></button>',
				"name" => $reg->nombre,
				"cat" => $reg->categoria,
				"cod" => $reg->codigo,
				"stock" => $reg->stock,
				"price" => $reg->precio_venta,
				"image" => "<img src='../files/articulos/" . $reg->imagen . "' height='50px' width='50px'>"

			);
		}
		$results = array(
			"sEcho" => 1, //info para datatables
			"iTotalRecords" => count($data), //enviamos el total de registros al datatable
			"iTotalDisplayRecords" => count($data), //enviamos el total de registros a visualizar
			"aaData" => $data
		);
		echo json_encode($results);

		break;
	case 'contarVentas':
		$rspta = $venta->contarVentas($tipo_comprobante);
		$reg = $rspta->fetch_object();
		echo json_encode($reg);
		break;
}