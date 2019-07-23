var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	})
	// Cargamos los items al select equipos
	$.post("../ajax/sensor.php?op=selectEquipo",function(r)
	{
		$("#idequipo").html(r);
		$("#idequipo").selectpicker('refresh');
	});
}

//Función limpiar
function limpiar()
{
	$("codigo").val("");
	$("#nombre").val("");
	//$("#idequipo").val("");
	$("#descripcion").val("");
	$("#idsensor").val("");
}

//Función mostrar formulario
function mostrarform(flag)
{
	limpiar();
	if (flag)
	{
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
	}
	else
	{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}
}

//Función cancelarform
function cancelarform()
{
	limpiar();
	mostrarform(false);
}

//Función Listar
function listar()
{
	tabla=$('#tbllistado').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    buttons: [		          
		            'copyHtml5',
		            'excelHtml5',
		            'csvHtml5',
		            'pdf'
		        ],
		"ajax":
				{
					url: '../ajax/sensor.php?op=listar',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 10,//Paginación
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
}
//Función para guardar o editar

function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/sensor.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {                    
	          bootbox.alert(datos);	          
	          mostrarform(false);
	          tabla.ajax.reload();
	    }

	});
	limpiar();
}

function mostrar(idsensor)
{
	$.post("../ajax/sensor.php?op=mostrar",{idsensor : idsensor}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

		$("#codigo").val(data.codigo);
		$("#nombre").val(data.nombre);
		$("#idequipo").val(data.idequipo);
		$("#idequipo").selectpicker('refresh');
		$("#descripcion").val(data.descripcion);
 		$("#idsensor").val(data.idsensor);

 	})
}

//Función para desactivar registros
function desactivar(idsensor)
{
	bootbox.confirm("¿Está Seguro de desactivar el Sensor?", function(result){
		if(result)
        {
        	$.post("../ajax/sensor.php?op=desactivar", {idsensor : idsensor}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

//Función para activar registros
function activar(idsensor)
{
	bootbox.confirm("¿Está Seguro de activar el Sensor?", function(result){
		if(result)
        {
        	$.post("../ajax/sensor.php?op=activar", {idsensor : idsensor}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}


init();