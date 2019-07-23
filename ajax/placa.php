<?php 
require_once "../modelo/Placa.php";

$placa=new Placa();

$idplaca=isset($_POST["idplaca"])? limpiarCadena($_POST["idplaca"]):"";
$codigo=isset($_POST["codigo"])? limpiarCadena($_POST["codigo"]):"";
$idequipo=isset($_POST["idequipo"])? limpiarCadena($_POST["idequipo"]):"";
$alto=isset($_POST["alto"])? limpiarCadena($_POST["alto"]):"";
$ancho=isset($_POST["ancho"])? limpiarCadena($_POST["ancho"]):"";
$espesor=isset($_POST["espesor"])? limpiarCadena($_POST["espesor"]):"";
$fecha_instalacion=isset($_POST["fecha_instalacion"])? limpiarCadena($_POST["fecha_instalacion"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idplaca)){
			$rspta=$placa->insertar($codigo,$idequipo,$alto,$ancho,$espesor,$fecha_instalacion);
			echo $rspta ? "Sensor registrado" : "sensor no se pudo registrar";
		}
		else {
			$rspta=$placa->editar($idplaca,$codigo,$idequipo,$alto,$ancho,$espesor,$fecha_instalacion);
			echo $rspta ? "Sensor actualizado" : "Sensor no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$placa->desactivar($idplaca);
 		echo $rspta ? "Sensor Desactivado" : "Sensor no se puede desactivar";
 		break;
	break;

	case 'activar':
		$rspta=$placa->activar($idplaca);
 		echo $rspta ? "Sensor activado" : "Sensor no se puede activar";
 		break;
	break;

	case 'mostrar':
		$rspta=$placa->mostrar($idplaca);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
 		break;
	break;

	case 'listar':
		$rspta=$placa->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->condicion)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idplaca.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idplaca.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idplaca.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idplaca.')"><i class="fa fa-check"></i></button>',
				"1"=>$reg->codigo, 
				"2"=>$reg->equipo,
 				"3"=>$reg->alto,
 				"4"=>$reg->ancho,
 				"5"=>$reg->espesor,
 				"6"=>$reg->fecha_instalacion,
 				"7"=>($reg->condicion)?'<span class="label bg-green">Activado</span>':
 				'<span class="label bg-red">Desactivado</span>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;
	case 'selectEquipo':
		require_once "../modelo/Equipo.php";
		$equipo = new Equipo();
		$rspta = $equipo->select();
		while ($reg = $rspta ->fetch_object())
		{
			echo '<option value=' . $reg->idequipo .'>' . $reg->nombre . '</option>';
		}
 		
	break;
}
?>