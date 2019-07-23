<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Sensor
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($codigo,$nombre,$idequipo,$descripcion)
	{
		$sql="INSERT INTO sensor (codigo,nombre,idequipo,descripcion,condicion)
		VALUES ('$codigo','$nombre','$idequipo','$descripcion','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idsensor,$codigo,$nombre,$idequipo,$descripcion)
	{
		$sql="UPDATE sensor SET codigo='$codigo',nombre='$nombre',idequipo='$idequipo',descripcion='$descripcion' WHERE idsensor='$idsensor'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar sensores
	public function desactivar($idsensor)
	{
		$sql="UPDATE sensor SET condicion='0' WHERE idsensor='$idsensor'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar sensores
	public function activar($idsensor)
	{
		$sql="UPDATE sensor SET condicion='1' WHERE idsensor='$idsensor'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idsensor)
	{
		$sql="SELECT * FROM sensor  WHERE idsensor='$idsensor'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT s.idsensor,s.codigo,s.nombre,s.idequipo,e.nombre AS equipo ,s.descripcion,s.condicion FROM sensor s INNER JOIN equipo e ON s.idequipo=e.idequipo";
		return ejecutarConsulta($sql);		
	}
}

?>