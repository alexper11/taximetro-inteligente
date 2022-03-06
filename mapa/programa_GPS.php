<?php
include "conexion.php";  // Conexión tiene la información sobre la conexión de la base de datos.

$lon = $_GET["longitud"]; 
$lat = $_GET["latitud"]; 
$vel = $_GET["velocidad"];;
$alt = $_GET["altitud"];;

//$vel = $_GET["velocidad"]; 
//$alt = $_GET["altitud"]; 
$ID_TARJ = $_GET["ID_TARJ"];

$mysqli = new mysqli($host, $user, $pw, $db); // Aquí se hace la conexión a la base de datos.

//CURDATE(),CURTIME()

date_default_timezone_set('America/Bogota'); // esta línea es importante cuando el servidor es REMOTO y está ubicado en otros países como USA o Europa. Fija la hora de Colombia para que grabe correctamente el dato de fecha y hora con CURDATE y CURTIME, en la base de datos.

$sql1 = "INSERT into ubicaciones (id_tarj, latitud, longitud, fecha, hora, velocidad, altitud) VALUES ('$ID_TARJ', '$lat', '$lon', CURDATE(), CURTIME(),'$vel','$alt')"; 
echo "sql1...".$sql1; // Se imprime la cadena sql enviada a la base de datos, se utiliza para depurar el programa php, en caso de algún error.
$result1 = $mysqli->query($sql1);
echo "result es...".$result1; // Si result es 1, quiere decir que el ingreso a la base de datos fue correcto.


?>
