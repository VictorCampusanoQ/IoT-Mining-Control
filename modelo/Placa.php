<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Placa
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($codigo,$idequipo,$alto,$ancho,$espesor,$fecha_instalacion)
	{
		$sql="INSERT INTO placa (codigo,idequipo,alto,ancho,espesor,fecha_instalacion,condicion)
		VALUES ('$codigo','$idequipo','$alto','$ancho','$espesor','$fecha_instalacion','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idplaca,$codigo,$idequipo,$alto,$ancho,$espesor,$fecha_instalacion)
	{
		$sql="UPDATE placa SET codigo='$codigo',idequipo='$idequipo',alto='$alto',ancho='$ancho',espesor='$espesor',fecha_instalacion='$fecha_instalacion' WHERE idplaca='$idplaca'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar sensores
	public function desactivar($idplaca)
	{
		$sql="UPDATE placa SET condicion='0' WHERE idplaca='$idplaca'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar sensores
	public function activar($idplaca)
	{
		$sql="UPDATE placa SET condicion='1' WHERE idplaca='$idplaca'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idplaca)
	{
		$sql="SELECT * FROM placa  WHERE idplaca='$idplaca'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT p.idplaca,p.codigo,p.idequipo,e.nombre AS equipo ,p.alto,p.ancho,p.espesor,p.fecha_instalacion,p.condicion FROM placa p INNER JOIN equipo e ON p.idequipo=e.idequipo";
		return ejecutarConsulta($sql);		
	}
}

?>