<?php  

include "conexion.php";  // Conexión tiene la información sobre la conexión de la base de datos.
$mysqli = new mysqli($host, $user, $pw, $db); // Aquí se hace la conexión a la base de datos.

$id_tar = "1";  //Identificador tarjeta
$id = "";


$sql1 = "SELECT * from estado_servicio where id_tar='$id_tar' and estado =1";
$result1 = $mysqli->query($sql1);

while($row1 = $result1->fetch_array(MYSQLI_NUM))
{
 $id = $row1[0];
}

echo $id;
return $id;






?>