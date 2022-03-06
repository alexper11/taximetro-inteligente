<?php
include "conexion.php";  // Conexión tiene la información sobre la conexión de la base de datos.
$mysqli = new mysqli($host, $user, $pw, $db); // Aquí se hace la conexión a la base de datos.


$latf = $_GET["latitud"];
$lonf = $_GET["longitud"];
$dis = $_GET["distancia"];
$tar = $_GET["tarifa"];
$id_tar = $_GET["idtar"];
$id = $_GET["id"];  


/*
$latf= "5";
$lonf = "6";
$id_tar = "1";
$id = "13";
*/


$sql1 = "UPDATE datos_recorrido SET latitud_final ='$latf', longitd_final = '$lonf', distancia = '$dis', tarifa = '$tar' where id = '$id' and id_tar = '$id_tar'";
        	echo "sql1...".$sql1;
        	$result1 = $mysqli->query($sql1);
            echo "result es...".$result1;

?>