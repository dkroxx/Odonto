<?php
//Metodo que nos deje conectarnos a la base de datos
$Conexion = null;

function ConectarBD(){
	global $Conexion;
	//mysqli_connect es el metodo que me permite conectarme a la base de datos y como parametro el servidor, el usuario, la clave y el nombre de la base.
	$Conexion = mysqli_connect("localhost", "root", "", "clinicaodontologica");
	//Retorna el codigo del error. Plan A.
	if(mysqli_connect_errno()){
		//Retorna la descripcion del error
		//echo("Error en conexion".mysql_connect_error());
	}
	//Para validar el error. Plan B.
	/*if(!$Conexion){
		echo("No se establecio la conexion con la BD");
		exit();
	}
	echo("Se establecio la conexion");*/
}


function AgregarPersona(){
	global $Conexion;
	ConectarBD();
	//prepare = de forma preconfigurada, manda una sentencia al servidor pero no lo ejecuta
	//? es una variable de macrosustitucion que despues se sustituye con los valores reales
	$sentencia = $Conexion -> prepare("Insert into persona (IdPersona, Nombre,Apellido1,Apellido2,FechaNacimiento) values (?,?,?,?,?)");
	//como parametro, es el tipo de dato de los valores, despues darle nombre a cada espacio
	//bind_param asocia cada variable que tengo que macrosustituir con una variable php
	$sentencia -> bind_param('sssss', $P1, $P2, $P3, $P4, $P5);
	$parametros = json_decode($_POST['Objeto']);
	$P1 = $parametros ->{'IdPersona'};
	$P2 = $parametros ->{'Nombre'};
	$P3 = $parametros ->{'Apellido1'};
	$P4 = $parametros ->{'Apellido2'};
	$P5 = $parametros ->{'FechaNacimiento'};
	$sentencia -> execute();
	$ObjRetorno = array('Resultado' => true);
	$sentencia -> close();
	$Conexion -> close();
	echo json_encode($ObjRetorno,JSON_FORCE_OBJECT);
}

function AgregarPaciente(){
	global $Conexion;
	ConectarBD();
	//prepare = de forma preconfigurada, manda una sentencia al servidor pero no lo ejecuta
	//? es una variable de macrosustitucion que despues se sustituye con los valores reales
	$sentencia = $Conexion -> prepare("Insert into cliente (FechaIngresado, Activo, IdPersona) values (?,?,?)");
	//como parametro, es el tipo de dato de los valores, despues darle nombre a cada espacio
	//bind_param asocia cada variable que tengo que macrosustituir con una variable php
	$sentencia -> bind_param('sis', $P1, $P2, $P3);
	$parametros = json_decode($_POST['Objeto']);
	$P1 = $parametros ->{'FechaIngresado'};
	$P2 = $parametros ->{'Activo'};
	$P3 = $parametros ->{'IdPersona'};
	$sentencia -> execute();
	$ObjRetorno = array('Resultado' => true);
	$sentencia -> close();
	$Conexion -> close();
	echo json_encode($ObjRetorno,JSON_FORCE_OBJECT);

}

switch ($_POST['Metodo']) {
	case 'MtoAgregar':
		AgregarPersona();
		AgregarPaciente();
		break;
	default:
		# code...
		break;
};
?>