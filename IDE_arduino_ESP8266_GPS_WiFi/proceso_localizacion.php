<?php
include "conexion.php";  // Conexión tiene la información sobre la conexión de la base de datos.

$lat = $_GET["latitud"]; 
$lon = $_GET["longitud"]; 
$ID_TARJ = $_GET["ID_TARJ"];
$vel = 0;
$alt = 0;

//$vel = $_GET["velocidad"]; 
//$alt = $_GET["altitud"]; 


$mysqli = new mysqli($host, $user, $pw, $db); // Aquí se hace la conexión a la base de datos.

//CURDATE(),CURTIME()

date_default_timezone_set('America/Bogota'); // esta línea es importante cuando el servidor es REMOTO y está ubicado en otros países como USA o Europa. Fija la hora de Colombia para que grabe correctamente el dato de fecha y hora con CURDATE y CURTIME, en la base de datos.

$sql1 = "INSERT into conductores (ID_TARJ, latitud, longitud) VALUES ('$ID_TARJ', '$lat', '$lon')"; 
echo "sql1...".$sql1; // Se imprime la cadena sql enviada a la base de datos, se utiliza para depurar el programa php, en caso de algún error.
$result1 = $mysqli->query($sql1);
echo "result es...".$result1; // Si result es 1, quiere decir que el ingreso a la base de datos fue correcto.


?>
