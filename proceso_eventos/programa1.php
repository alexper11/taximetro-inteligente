<?php
include "conexion.php";  // Conexión tiene la información sobre la conexión de la base de datos.
$mysqli = new mysqli($host, $user, $pw, $db); // Aquí se hace la conexión a la base de datos.

$lat = $_GET["latitud"];
$lon = $_GET["longitud"];
$id_tar = $_GET["idtar"];
$id = $_GET["id"];  


/*
$latitud = "5";
$longitud = "6";
$id_tar = "1";
$id = "8";
*/


$sql1 = "UPDATE datos_recorrido SET latitud_inicio ='$lat', longitud_inicio = '$lon' where id = '$id' and id_tar = '$id_tar'";
        	echo "sql1...".$sql1;
        	$result1 = $mysqli->query($sql1);
            echo "result es...".$result1;


/*
$lat = "34";
$long = "42";
$dist= "3";
$tar= "4000";
//$hum = $_GET["humedad"]; // el dato de humedad que se recibe aquí con GET denominado humedad, es enviado como parametro en la solicitud que realiza la tarjeta microcontrolada
//$temp = $_GET["temperatura"]; // el dato de temperatura que se recibe aquí con GET denominado temperatura, es enviado como parametro en la solicitud que realiza la tarjeta microcontrolada





$ID_TARJ = "1";
//$ID_TARJ = $_GET["ID_TARJ"];

$mysqli = new mysqli($host, $user, $pw, $db); // Aquí se hace la conexión a la base de datos.

date_default_timezone_set('America/Bogota'); // esta línea es importante cuando el servidor es REMOTO y está ubicado en otros países como USA o Europa. Fija la hora de Colombia para que grabe correctamente el dato de fecha y hora con CURDATE y CURTIME, en la base de datos.

$sql1 = "INSERT into datos_medidos (ID_TARJ, latitud, longitud, fecha, tarifa, distancia) VALUES ('$ID_TARJ', '$lat', '$long', CURDATE(), '$tar', '$dist')"; // Aquí se ingresa el valor recibido a la base de datos.
echo "sql1...".$sql1; // Se imprime la cadena sql enviada a la base de datos, se utiliza para depurar el programa php, en caso de algún error.
$result1 = $mysqli->query($sql1);
echo "result es...".$result1; // Si result es 1, quiere decir que el ingreso a la base de datos fue correcto.
*/
?>
