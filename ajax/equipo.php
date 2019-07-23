<?php 
require_once "../modelo/Equipo.php";

$equipo=new Equipo();

$idequipo=isset($_POST["idequipo"])? limpiarCadena($_POST["idequipo"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$imagen=isset($_POST["imagen"])? limpiarCadena($_POST["imagen"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
	/* **************************** Validar que se suba una imagen valida jpg,jpeg,png ***************************** */
		if (!file_exists($_FILES['imagen']['tmp_name'])|| !is_uploaded_file($_FILES['imagen']['tmp_name']))
		{
			$imagen=$_POST["imagenactual"];
		}
		else
		{
			$ext = explode(".", $_FILES["imagen"]["name"]);
			if($_FILES['imagen']['type']== "image/jpg" || $_FILES['imagen']['type']== "image/jpeg" || $_FILES['imagen']['type']== "image/png")
			{
				$imagen = round(microtime(true)).'.'. end($ext);
				move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/equipos/".$imagen);
			}
		}
		//************************************************************************************************ */
		if (empty($idequipo)){
			$rspta=$equipo->insertar($nombre,$descripcion,$imagen);
			echo $rspta ? "equipo registrado" : "equipo no se pudo registrar";
		}
		else {
			$rspta=$equipo->editar($idequipo,$nombre,$descripcion,$imagen);
			echo $rspta ? "Equipo actualizado" : "Equipo no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$equipo->desactivar($idequipo);
 		echo $rspta ? "Equipo Desactivado" : "Equipo no se puede desactivar";
 		break;
	break;

	case 'activar':
		$rspta=$equipo->activar($idequipo);
 		echo $rspta ? "Equipo activado" : "Equipo no se puede activar";
 		break;
	break;

	case 'mostrar':
		$rspta=$equipo->mostrar($idequipo);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
 		break;
	break;

	case 'listar':
		$rspta=$equipo->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->condicion)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idequipo.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idequipo.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idequipo.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idequipo.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->nombre,
                "2"=>$reg->descripcion,
                "3"=>"<img src='../files/equipos/".$reg->imagen."' height='50px' width='50px'>",
 				"4"=>($reg->condicion)?'<span class="label bg-green">Activado</span>':
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
}
?>