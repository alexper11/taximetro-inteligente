<?php
/*
Descripción: Cálculo de la distancia entre 2 puntos en función de su latitud/longitud
*/

$latitud1 = $_GET["latitud1"];
$longitud1 = $_GET["longitud1"];
$latitud2 = $_GET["latitud2"];
$longitud2 = $_GET["longitud2"]; 


/*
$latitud1 = "48.8668164";
$longitud1 = "2.3332265";
$latitud2 = "48.8668879";
$longitud2 = "2.3333821";
*/

function distanceCalculation($latitud1, $longitud1, $latitud2, $longitud2, $decimals = 2) {
	// Cálculo de la distancia en grados
	$degrees = rad2deg(acos((sin(deg2rad($latitud1))*sin(deg2rad($latitud2))) + (cos(deg2rad($latitud1))*cos(deg2rad($latitud2))*cos(deg2rad($longitud1-$longitud2)))));
 

			$distance = $degrees * 111.13384; // 1 grado = 111.13384 km, basándose en el diametro promedio de la Tierra (12.735 km)

	return round($distance, $decimals);
}



$km = distanceCalculation($latitud1, $longitud1, $latitud2, $longitud2); // Calcular la distancia en 
echo "$km";

//48.8668164,2.3332265   ---> 715, 456
//48.8667449,2.3331809   --->   


/*
$point1 = array("lat" => "48.8668164", "long" => "2.3332265"); // París (Francia)
$point2 = array("lat" => "48.8668879", "long" => "2.3332721"); // Ciudad de México (México)
$km = distanceCalculation($point1['lat'], $point1['long'], $point2['lat'], $point2['long']); // Calcular la distancia en 
echo "La distancia entre inicio de recorrido y el destino final es de $km metros ";


/*
$point1 = array("lat" => "48.8666667", "long" => "2.3333333"); // París (Francia)
$point2 = array("lat" => "19.4341667", "long" => "-99.1386111"); // Ciudad de México (México)
$km = distanceCalculation($point1['lat'], $point1['long'], $point2['lat'], $point2['long']); // Calcular la distancia en 
echo "La distancia entre inicio de recorrido y el destino final es de $km metros ";
*/
?>
