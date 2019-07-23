<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Equipo
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($nombre,$descripcion,$imagen)
	{
		$sql="INSERT INTO equipo (nombre,descripcion,imagen,condicion)
		VALUES ('$nombre','$descripcion','$imagen','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idequipo,$nombre,$descripcion,$imagen)
	{
		$sql="UPDATE equipo SET nombre='$nombre',descripcion='$descripcion',imagen='$imagen' WHERE idequipo='$idequipo'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar equipos
	public function desactivar($idequipo)
	{
		$sql="UPDATE equipo SET condicion='0' WHERE idequipo='$idequipo'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar equipos
	public function activar($idequipo)
	{
		$sql="UPDATE equipo SET condicion='1' WHERE idequipo='$idequipo'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idequipo)
	{
		$sql="SELECT * FROM equipo WHERE idequipo='$idequipo'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM equipo";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT * FROM equipo WHERE condicion=1 ";
		return ejecutarConsulta($sql);		
	}
}

?>