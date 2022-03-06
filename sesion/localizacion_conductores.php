<?php

// PROGRAMA DE MENU ADMINISTRADOR
include "conexion.php";
                                                 
session_start();
if ($_SESSION["autenticado"] != "SIx3")
    {
      header('Location: index.php?mensaje=3');
    }
else
    {      
        $mysqli = new mysqli($host, $user, $pw, $db);
  	    $sqlusu = "SELECT * from tipo_usuario where id='1'"; //CONSULTA EL TIPO DE USUARIO CON ID=1, ADMINISTRADOR
        $resultusu = $mysqli->query($sqlusu);
        $rowusu = $resultusu->fetch_array(MYSQLI_NUM);
  	    $desc_tipo_usuario = $rowusu[1];
        if ($_SESSION["tipo_usuario"] != $desc_tipo_usuario)
          header('Location: index.php?mensaje=4');
    }

?>
    <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 	Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
     <html>
       <head>
           <style>
       #map {
        height: 600px;
        width: 70%;
       }
    </style>
           <title> Localización de conductores</title>
        </head>
       <body>
        <table width="100%" align=center cellpadding=5 border=0 bgcolor="black">
    	   <tr>
           <td valign="top" align=left width=70%>
              <table width="100%" align=center border=0>
            	   <tr>
                  <td valign="top" align=center width=30%>
                     <img src="imagen/taximetro2.jpg" border=0 width=350 height=80> 
             	    </td>
                  <td valign="top" align=center width=60%>
                     <h1><font color=yellow>Sistema Taximetro inteligente </font></h1>
             	    </td>
           	    </tr>
         	    </table>
           </td>
           <td valign="top" align=right>
              <font FACE="arial" SIZE=2 color="#FFFFFF"> <b><u><?php  echo "Nombre Usuario</u>:   ".$_SESSION["nombre_usuario"];?> </b></font><br>
              <font FACE="arial" SIZE=2 color="#FFFFFF"> <b><u><?php  echo "Tipo Usuario</u>:   ".$desc_tipo_usuario;?> </b></font><br>  
              <font FACE="arial" SIZE=2 color="#00FFFF"> <b><u> <a href="cerrar_sesion.php"> Cerrar Sesion </a></u></b></font>  

           </td>
	     </tr>
     </table>
    <table width="100%" align=center cellpadding=5 border=0 bgcolor="#FFFFFF">
<?php
include "menu_admin.php";
?>
 	    <tr valign="top">
         <td height="20%" align="left" 				
            bgcolor="#FFFFFF" class="_espacio_celdas" 					
            style="color: #FFFFFF; 
            font-weight: bold">
    		    <font FACE="arial" SIZE=2 color="#000044"> <b><h1>Localizacion de conductores</h1></b></font>  
	       </td>
         <td height="20%" align="right" 				
             bgcolor="#FFFFFF" class="_espacio_celdas" 					
             style="color: #FFFFFF; 
            font-weight: bold">
    			  <img src="imagen/generar_informes.jpg" border=0 width=115 height=115>    
		     </td>
	    </tr>
	  </table>


<?php
include "conexion.php";  // Conexión tiene la información sobre la conexión de la base de datos.
$mysqli = new mysqli($host, $user, $pw, $db); // Aquí se hace la conexión a la base de datos.
$sqlubi = "SELECT * from ubicaciones order by id DESC LIMIT 100"; //CONSULTA LAS ULTIMAS 10 UBICACIONES DE LA TABLA DE LA BASE DE DATOS
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
    <h3>ULTIMAS UBICACIONES REGISTRADAS</h3>
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
          zoom: 15,
          center: uluru,
          mapTypeId: 'roadmap'
        });

    
        // LAS UBICACIONES LAS LOCALIZA UTILIZANDO UN ICONO DEFINIDO (CUADRO AZUL), UBICADO EN LA SUBCARPETA ICONS, DENOMINADO ubicacion.png

        var myicons = 'http://localhost/programas_php/Miparte/icon/';
        var icons = {
          ubicacion0: {
            icon: myicons + 'ubicacion0.png'
          },
          ubicacion1: {
            icon: myicons + 'ubicacion1.png'
          },
          ubicacion2: {
            icon: myicons + 'ubicacion2.png'
          },
          ubicacion3: {
            icon: myicons + 'ubicacion3.png'
          },
          ubicacion4: {
            icon: myicons + 'ubicacion4.png'
          },
          ubicacion5: {
            icon: myicons + 'ubicacion5.png'
          },
          ubicacion6: {
            icon: myicons + 'ubicacion6.png'
          },
          ubicacion7: {
            icon: myicons + 'ubicacion7.png'
          },
          ubicacion8: {
            icon: myicons + 'ubicacion8.png'
          },
          ubicacion9: {
            icon: myicons + 'ubicacion9.png'
          }           
        };
         
        // GUARDA EN UN ARREGLO FEATURES LOS PUNTOS DE UBICACION
        var features = [
               
           {
            position: new google.maps.LatLng(<?php echo $latitud[0];?>, <?php echo $longitud[0];?>),
            type: 'ubicacion0'
           },
           {
            position: new google.maps.LatLng(<?php echo $latitud[1];?>, <?php echo $longitud[1];?>),
            type: 'ubicacion1'
           },
           {
            position: new google.maps.LatLng(<?php echo $latitud[2];?>, <?php echo $longitud[2];?>),
            type: 'ubicacion2'
           },
           {
            position: new google.maps.LatLng(<?php echo $latitud[3];?>, <?php echo $longitud[3];?>),
            type: 'ubicacion3'
           },
           {
            position: new google.maps.LatLng(<?php echo $latitud[4];?>, <?php echo $longitud[4];?>),
            type: 'ubicacion4'
           },
           {
            position: new google.maps.LatLng(<?php echo $latitud[5];?>, <?php echo $longitud[5];?>),
            type: 'ubicacion5'
           },
           {
            position: new google.maps.LatLng(<?php echo $latitud[6];?>, <?php echo $longitud[6];?>),
            type: 'ubicacion6'
           },
           {
            position: new google.maps.LatLng(<?php echo $latitud[7];?>, <?php echo $longitud[7];?>),
            type: 'ubicacion7'
           },
           {
            position: new google.maps.LatLng(<?php echo $latitud[8];?>, <?php echo $longitud[8];?>),
            type: 'ubicacion8'
           },

               
          {
            position: new google.maps.LatLng(<?php echo $latitud[9];?>, <?php echo $longitud[9];?>),
            type: 'ubicacion9'
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

       var infowindow = new google.maps.InfoWindow({
       content: 'Conductor 1, Lat: ' + <?php echo $latitud[0];?> + ', Lon: ' + <?php echo $longitud[0];?>,
       position: uluruk
       });
       infowindow.open(map);
          features.forEach(function(feature) {
          var marker = new google.maps.Marker({
            position: feature.position,
            icon: icons[feature.type].icon,
            map: map
          });
        });
       var infowindow = new google.maps.InfoWindow({
       content: 'Conductor 2, Lat: ' + <?php echo $latitud[1];?> + ', Lon: ' + <?php echo $longitud[1];?>,
       position: uluruk
       });
       infowindow.open(map);
         features.forEach(function(feature) {
          var marker = new google.maps.Marker({
            position: feature.position,
            icon: icons[feature.type].icon,
            map: map
          });
        });
       var infowindow = new google.maps.InfoWindow({
       content2: 'Conductor 3, Lat: ' + <?php echo $latitud[2];?> + ', Lon: ' + <?php echo $longitud[2];?>,
       position: uluruk
       });
       infowindow.open(map);
       var infowindow3 = new google.maps.InfoWindow3({
       content: 'Conductor 4, Lat: ' + <?php echo $latitud[3];?> + ', Lon: ' + <?php echo $longitud[3];?>,
       position: uluruk
       });
       infowindow3.open(map);
       var infowindow = new google.maps.InfoWindow({
       content: 'Conductor 5, Lat: ' + <?php echo $latitud[4];?> + ', Lon: ' + <?php echo $longitud[4];?>,
       position: uluruk
       });
       infowindow.open(map);
       var infowindow5 = new google.maps.InfoWindow5({
       content: 'Conductor 6, Lat: ' + <?php echo $latitud[5];?> + ', Lon: ' + <?php echo $longitud[5];?>,
       position: uluruk
       });
       infowindow5.open(map);
       var infowindow6 = new google.maps.InfoWindow6({
       content: 'Conductor 7, Lat: ' + <?php echo $latitud[6];?> + ', Lon: ' + <?php echo $longitud[6];?>,
       position: uluruk
       });
       infowindow6.open(map);
       var infowindow7 = new google.maps.InfoWindow7({
       content: 'Conductor 8, Lat: ' + <?php echo $latitud[7];?> + ', Lon: ' + <?php echo $longitud[7];?>,
       position: uluruk
       });
       infowindow7.open(map);
       var infowindow8 = new google.maps.InfoWindow8({
       content: 'Conductor 9, Lat: ' + <?php echo $latitud[8];?> + ', Lon: ' + <?php echo $longitud[8];?>,
       position: uluruk
       });
       infowindow8.open(map);
       var infowindow9 = new google.maps.InfoWindow9({
       content: 'Conductor 9, Lat: ' + <?php echo $latitud[9];?> + ', Lon: ' + <?php echo $longitud[9];?>,
       position: uluruk
       });
       infowindow9.open(map);

}
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCyhs_hxNVZOGgJeV-vdHdXq72WO6nFyuI&callback=initMap">  <!-- Se deben reemplazar las XXXX por la API Key de Google MAPS -->
    </script>
  </body>
</html>

