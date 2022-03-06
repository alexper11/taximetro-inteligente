<meta http-equiv="refresh" content="8;URL=./consulta.php" >  <!-- Para que se actualice la pag web-->

<?php
include "conexion.php";

?>
<!DOCTYPE html>
<html>
<head>

  <style>
     #map {
      height: 400px;
      width: 50%;
     }
  </style>
</head>
<body>
<?php  // Conexión tiene la información sobre la conexión de la base de datos.
$distanciatotal=0;
$tarifaparcial=0;
$mysqli = new mysqli($host, $user, $pw, $db); // Aquí se hace la conexión a la base de datos.
$sqlubi = "SELECT * from ubicaciones order by id DESC LIMIT 1000"; //CONSULTA LAS ULTIMAS 10 UBICACIONES DE LA TABLA DE LA BASE DE DATOS
$resultubi = $mysqli->query($sqlubi);
$i=0;
while($rowubi = $resultubi->fetch_array(MYSQLI_NUM))
{
 $latitud[$i] = $rowubi[1];
 $longitud[$i] = $rowubi[2];
 $fecha[$i] = $rowubi[4];
 $hora[$i] = $rowubi[5];
 $i++;

}   

?>
<div align="center"><font color="#FFFFFF" size="+5"><marquee bgcolor="#000000" direction="left" loop="20">CONSULTA DE RUTA</marquee></font></div>
  <div id="map"></div>
  <script>
    var map;

    // ALMACENA EN VARIABLES LA UBICACION INICIAL Y FINAL

    var latit= <?php echo $latitud[0] ?>;
    var longi= <?php echo $longitud[0] ?>;
    var uluru = {lat: latit, lng: longi};

    var latitk= <?php echo $latitud[$i-1] ?>;
    var longik= <?php echo $longitud[$i-1] ?>;
    var uluruk = {lat: latitk, lng: longik};

    function initMap() {
      map = new google.maps.Map(document.getElementById('map'), {
        zoom: 14,
        center: uluru,
        mapTypeId: 'roadmap'
      });

      // LAS UBICACIONES LAS LOCALIZA UTILIZANDO UN ICONO DEFINIDO (CUADRO AZUL), UBICADO EN LA SUBCARPETA ICONS, DENOMINADO ubicacion.png

      var myicons = 'http://localhost/taximetro/mapa/icons/';
      var icons = {
        ubicacion: {
          icon: myicons + 'ubicacion.png'
        }
      };

      // GUARDA EN UN ARREGLO FEATURES LOS PUNTOS DE UBICACION
      var features = [
         <?php
           for ($k=0;$k<$i;$k++)
             {

              if($k > 0){
                $lt1=$latitud[$k-1];
                $ln1=$longitud[$k-1];
                $lt2=$latitud[$k];
                $ln2=$longitud[$k];
                $degrees = rad2deg(acos((sin(deg2rad($lt1))*sin(deg2rad($lt2))) + (cos(deg2rad($lt1))*cos(deg2rad($lt2))*cos(deg2rad($ln1-$ln2)))));
                $distance[$k] = $degrees * 111133.84; //metros
                $distanciatotal= $distanciatotal + $distance[$k];
                $espera=0;
                $cargo=0;
                if($k > 10){
                $flag=$distance[$k] + $distance[$k-1] + $distance[$k-2] + $distance[$k-3] + $distance[$k-4] + $distance[$k-5];
                if($flag <= 10){
                  $cargo++;
                  $espera=$cargo*65;
                }
                }
                if($distanciatotal<=2500){

                  $tarifaparcial=3800 + $espera;
                }
                else{

                  $tarifaparcial=3800 + ($distanciatotal*0.72) + $espera;
                  //AGREGAR TIEMPO DE ESPERA
                }

                $id_tar = 1;

                $mysqli = new mysqli($host, $user, $pw, $db); // Aquí se hace la conexión a la base de datos.
                $sql6 = "UPDATE tarifa SET tarifa ='$tarifaparcial', distancia = '$distanciatotal' where id_tar='$id_tar'";
                $result6 = $mysqli->query($sql6);

                
                
                
              }
         ?>    
         {
          position: new google.maps.LatLng(<?php echo $latitud[$k];?>, <?php echo $longitud[$k];?>),
          type: 'ubicacion'
         },
         <?php

            }
         ?>    
        {
          position: new google.maps.LatLng(<?php echo $latitud[$k-1];?>, <?php echo $longitud[$k-1];?>),
          type: 'ubicacion'
        }
      ];

      // CREA LOS MARCADORES Y LOS PRESENTA EN EL MAPA
      features.forEach(function(feature) {
        var marker = new google.maps.Marker({
          position: feature.position,
          icon: icons[feature.type].icon,
          map: map
        });
      });
      // PRESENTA TAMBIEN UN MENSAJE EMERGENTE PARA LA UBICACION INICIAL Y LA FINAL.

}
  </script>
  <script async defer
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCyhs_hxNVZOGgJeV-vdHdXq72WO6nFyuI&callback=initMap">
  </script>

<table width="70%" align=left cellpadding=5 border=0 bgcolor="#FFFFFF">
       <tr>
         <td valign="top" align=center width=80& colspan=6 bgcolor="black">
           <h2> <font color=white></font></h2>
         </td>
         </tr>
         <tr>
          <br>
          <br>
         <td valign="top" align=center bgcolor="#ffff00"><font color="black" size="+3">
            <b>Tarifa Actual</b></font>
         </td>
         <td valign="top" align=center bgcolor="#ffff00"><font color="black" size="+3"> 
            <b>Distancia Recorrida</b></font>
         </td>
         </tr>
       <tr>
           <td valign="top" align=center bgcolor="#f2f2f2"><font color="black" size="+3">
             $<?php echo intval($tarifaparcial); ?></font>
           </td>
           <td valign="top" align=center bgcolor="#f2f2f2"><font color="black
          " size="+3">
             <?php echo intval($distanciatotal); ?> m </font>
           </tr>
       </table>
       <hr>
       <br><br>
     </body>
   </html>
