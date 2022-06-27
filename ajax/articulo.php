<?php
header('Access-Control-Allow-Origin: *');
// header("application/x-www-form-urlencoded");
require_once "../modelos/Articulo.php";

$articulo = new Articulo();
// $_POST = json_decode(file_get_contents('php://input'), true);
$idarticulo = isset($_POST["idarticulo"]) ? limpiarCadena($_POST["idarticulo"]) : "";
$idcategoria = isset($_POST["idcategoria"]) ? limpiarCadena($_POST["idcategoria"]) : "";
$codigo = isset($_POST["codigo"]) ? limpiarCadena($_POST["codigo"]) : "";
$nombre = isset($_POST["nombre"]) ? limpiarCadena($_POST["nombre"]) : "";
$stock = isset($_POST["stock"]) ? limpiarCadena($_POST["stock"]) : "";
$descripcion = isset($_POST["descripcion"]) ? limpiarCadena($_POST["descripcion"]) : "";
$imagen = isset($_POST["imagen"]) ? limpiarCadena($_POST["imagen"]) : "";

switch ($_GET["op"]) {
	case 'guardaryeditar':
		echo json_encode($_POST);
		return;
		if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name'])) {
			$imagen = $_POST["imagenactual"];
		} else {
			$ext = explode(".", $_FILES["imagen"]["name"]);
			if ($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png") {
				$imagen = round(microtime(true)) . '.' . end($ext);
				move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/articulos/" . $imagen);
			}
		}
		if (empty($idarticulo)) {
			$rspta = $articulo->insertar($idcategoria, $codigo, $nombre, $stock, $descripcion, $imagen);
			echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
		} else {
			$rspta = $articulo->editar($idarticulo, $idcategoria, $codigo, $nombre, $stock, $descripcion, $imagen);
			echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos";
		}
		break;


	case 'desactivar':
		$rspta = $articulo->desactivar($idarticulo);
		echo $rspta ? "Datos desactivados correctamente" : "No se pudo desactivar los datos";
		break;
	case 'activar':
		$rspta = $articulo->activar($idarticulo);
		echo $rspta ? "Datos activados correctamente" : "No se pudo activar los datos";
		break;

	case 'mostrar':
		$rspta = $articulo->mostrar($idarticulo);
		echo json_encode($rspta);
		break;

	case 'listar':
		$rspta = $articulo->listar();
		$data = array();

		while ($reg = $rspta->fetch_object()) {
			$data[] = array(
				"op" => ($reg->condicion) ? '<button class="btn btn-warning btn-xs" onclick="mostrar(' . $reg->idarticulo . ')"><i class="fas fa-pencil-alt"></i></button>' . ' ' . '<button class="btn btn-danger btn-xs" onclick="desactivar(' . $reg->idarticulo . ')"><i class="fas fa-trash-alt"></i></button>' : '<button class="btn btn-warning btn-xs" onclick="mostrar(' . $reg->idarticulo . ')"><i class="fas fa-eye"></i></button>' . ' ' . '<button class="btn btn-primary btn-xs" onclick="activar(' . $reg->idarticulo . ')"><i class="fas fa-check"></i></button>',
				"name" => $reg->nombre,
				"cat" => $reg->categoria,
				"cod" => $reg->codigo,
				"stock" => $reg->stock,
				"img" => "<img src='../files/articulos/" . $reg->imagen . "' height='50px' width='50px'>",
				"desc" => $reg->descripcion,
				"est" => ($reg->condicion) ? '<span class="badge badge-success">Activado</span>' : '<span class="badge badge-success">Desactivado</span>'
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

	case 'selectCategoria':
		require_once "../modelos/Categoria.php";
		$categoria = new Categoria();

		$rspta = $categoria->select();

		while ($reg = $rspta->fetch_object()) {
			echo '<option value=' . $reg->idcategoria . '>' . $reg->nombre . '</option>';
		}
		break;
}