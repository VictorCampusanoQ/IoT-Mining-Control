<?php 
require_once "../modelo/Sensor.php";

$sensor=new Sensor();

$idsensor=isset($_POST["idsensor"])? limpiarCadena($_POST["idsensor"]):"";
$codigo=isset($_POST["codigo"])? limpiarCadena($_POST["codigo"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$idequipo=isset($_POST["idequipo"])? limpiarCadena($_POST["idequipo"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idsensor)){
			$rspta=$sensor->insertar($codigo,$nombre,$idequipo,$descripcion);
			echo $rspta ? "Sensor registrado" : "sensor no se pudo registrar";
		}
		else {
			$rspta=$sensor->editar($idsensor,$codigo,$nombre,$idequipo,$descripcion);
			echo $rspta ? "Sensor actualizado" : "Sensor no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$sensor->desactivar($idsensor);
 		echo $rspta ? "Sensor Desactivado" : "Sensor no se puede desactivar";
 		break;
	break;

	case 'activar':
		$rspta=$sensor->activar($idsensor);
 		echo $rspta ? "Sensor activado" : "Sensor no se puede activar";
 		break;
	break;

	case 'mostrar':
		$rspta=$sensor->mostrar($idsensor);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
 		break;
	break;

	case 'listar':
		$rspta=$sensor->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->condicion)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idsensor.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idsensor.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idsensor.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idsensor.')"><i class="fa fa-check"></i></button>',
				"1"=>$reg->codigo, 
				"2"=>$reg->nombre,
				"3"=>$reg->equipo,
 				"4"=>$reg->descripcion,
 				"5"=>($reg->condicion)?'<span class="label bg-green">Activado</span>':
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