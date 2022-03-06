<meta http-equiv="refresh" content="5;URL=./programa2.php" >  <!-- Para que se actualice la pag web-->

<?php
include "conexion.php";  // Conexión tiene la información sobre la conexión de la base de datos.
$mysqli = new mysqli($host, $user, $pw, $db); // Aquí se hace la conexión a la base de datos.

// LAs siguientes son líneas de código HTML simple, para crear una página web



?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 	Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
  <html>
    <head>
      <title> CONSULTA SERVICIOS
		  </title>
      <meta http-equiv="refresh" content="15" />
    </head>
<center>

<form method=POST action="programa2.php">
<input type="hidden" name="enviado" value="S1">  
<input type="submit" value="Iniciar" name="Iniciar"> 
</form>

<form method=POST action="programa2.php">
<input type="hidden" name="clear" value="S2">  
<input type="submit" value="Clear" name="Clear"> 
</form>

<form method=POST action="programa2.php">
<input type="hidden" name="finalizar" value="S3">  
<input type="submit" value="Finalizar" name="Finalizar"> 
</form>


</center>


    <body style="background-color:#D7DF01;">
      <table width="90%" align=center cellpadding=4 border=1 bgcolor="#FFFFFF">

    	 <tr>
         <td valign="top" align=center width=80& colspan=10 bgcolor="black">
           <img src="img/taxi.jpg" width=800 height=250>
         </td>
 	     </tr>
 	     <tr>
         <td valign="top" align=center width=80& colspan=10 bgcolor="black">
           <h1> <font color=white>Registro de servicios</font></h1>
         </td>
 	     </tr>
      <tr>
         <td valign="top" align=center width=80& rowspan=2 bgcolor="#E1E1E1">    
          <b>Id recorrido</b>    
         </td>
          <td valign="top" align=center width=80& rowspan=2 bgcolor="#E1E1E1">   
          <b>Id de dispositivo</b>     
         </td>
          <td valign="top" align=center width=80& rowspan=2 bgcolor="#E1E1E1">    
          <b>Fecha</b>    
         </td>
         <td valign="top" align=center width=80& colspan=2 bgcolor="#E1E1E1">  
         <b>Punto inicial</b>      
         </td>
         <td valign="top" align=center width=80& colspan=2 bgcolor="#E1E1E1">  
         <b>Punto final</b>      
         </td>
         <td valign="top" align=center width=80& rowspan=2 bgcolor="#E1E1E1">   
          <b>Distancia</b>     
         </td> 
         <td valign="top" align=center width=80& rowspan=2 bgcolor="#E1E1E1">   
          <b>Tarifa</b>     
         </td>      
       </tr>
    	 <tr>
         
         <td valign="top" align=center bgcolor="#E1E1E1">
            <b>Latitud</b>
         </td>
         <td valign="top" align=center bgcolor="#E1E1E1">
            <b>Longitud</b>
         </td>
         <td valign="top" align=center bgcolor="#E1E1E1">
            <b>Latitud</b>
         </td>
         <td valign="top" align=center bgcolor="#E1E1E1">
            <b>Longitud</b>
         </td>      
         
 	     </tr>  
       
<?php

// estado == 1 --> hay servicio en proceso
// estado == 2 --> se finalizo el servicio
// estado == 0 --> servicio culminado total


// ********************************* BOTON INICIAR ******************************************

if ((isset($_POST["enviado"]))){
        $enviado = $_POST["enviado"];
        if ($enviado == "S1"){

            $id_tar = "1";
            $estado = "1";
             
        	$sql2 = "UPDATE estado_servicio SET estado ='$estado' where id_tar=1 and estado =0";
        	// Para comprobar si hay error en el insert
        	//echo "sql2...".$sql2;
        	$result2 = $mysqli->query($sql2);
            //echo "result es...".$result2;


              // Abrir visualizacion del mapa - recorrido
         ?>

         <script>
          window.open('http://localhost/taximetro/mapa/consulta.php');
         </script>
          
        <?php
          
         
          
        }
    }
?> 

<?php
// ********************************* BOTON LIMPIAR ******************************************

if ((isset($_POST["clear"]))){
        $enviado = $_POST["clear"];
        if ($enviado == "S2"){

            $id_tar = "1";
            $estado = "0";
             
            $sql3 = "UPDATE estado_servicio SET estado ='$estado' where id_tar=1 and estado =2";
        	//echo "sql3...".$sql3;
        	$result3 = $mysqli->query($sql3);
            //echo "result es...".$result3;


           // Borrar ubicaciones despues de terminado el servicio 
          
          $sql8 = "DELETE from ubicaciones where id_tarj=1";
          $result8 = $mysqli->query($sql8);
          
          

        }
    }
?> 

<?php
// ********************************* BOTON FINALIZAR ******************************************

if ((isset($_POST["finalizar"]))){
        $enviado = $_POST["finalizar"];
        if ($enviado == "S3"){

            $id_tar = "1";
            $estado = "2";
             
            $sql3 = "UPDATE estado_servicio SET estado ='$estado' where id_tar=1 and estado =1";
        	//echo "sql3...".$sql3;
        	$result3 = $mysqli->query($sql3);
            
 ////////  
 /* 
            $resulta = $mysqli->query($sqla);
            $sqlb = "SELECT * from usuarios"; 
            $resultb = $mysqli->query($sqlb);
            $identificacion = $rowb[3];
            $sqlc = "SELECT * from tarifa"; 
            $resultc = $mysqli->query($sqlc);

           while($rowc = $resultc->fetch_array(MYSQLI_NUM))
            {
            $costof = $rowc[0];
            $distanciaf = $rowc[1];
            }
            $sqld = "SELECT * from ubicaciones where id_tarj=1 order by id DESC LIMIT 1"; 
            $result6 = $mysqli->query($sql6);

            while($row6 = $result6->fetch_array(MYSQLI_NUM))
            {

            $lat_f = $row6[1];
            $long_f = $row6[2];
         

            }


           $sqla = "INSERT into historialr (cedula, fecha , latitudInicio, longitudInicio, latitudFinsl, longitudFinal, recorrido, costo) VALUES ('$identificacion', CURDATE(), '$latitudi', $longitudi, $latitudf,'$longitudf','$distaniaf','costof')"; 
            echo "sql1...".$sqla; // Se imprime la cadena sql enviada a la base de datos, se utiliza para depurar el programa php, en caso de algún error.

*/

  //////
        }
    }
?> 

<?php

//*********************************** MOSTRAR RECORRIDO ********************************************


//********************** Obtengo el estado del servicio - para comenzar a mostrar la informacion en la tabla ******
$sql4 = "SELECT * from estado_servicio where id_tar=1"; 
$result4 = $mysqli->query($sql4);

while($row4 = $result4->fetch_array(MYSQLI_NUM))
{

 $estado= $row4[1];
 
 
}
echo $estado;



// Si estado es igual a 1 - hay en proceso recorrido obtengo los valores del recorrido 
if ($estado == 1 or $estado == 2){

        // ***************** Coordenada de inicio *************************** 
        $sql5 = "SELECT * from ubicaciones where id_tarj=1 order by id LIMIT 1"; 
        $result5 = $mysqli->query($sql5);

        $row5 = $result5->fetch_array(MYSQLI_NUM);
      

         $id = $row5[0];
         $lat_i = $row5[1];
         $long_i = $row5[2];
         $id_t = $row5[3];
         $fecha = $row5[4];


        // *************** Ultima Coordenada tomada **************************
        $sql6 = "SELECT * from ubicaciones where id_tarj=1 order by id DESC LIMIT 1"; 
        $result6 = $mysqli->query($sql6);

        while($row6 = $result6->fetch_array(MYSQLI_NUM))
        {

         $lat_f = $row6[1];
         $long_f = $row6[2];
         

       }


       // *************** Ultima tarifa y recorrido tomado **************************
        $sql7 = "SELECT * from tarifa where id_tar=1"; 
        $result7 = $mysqli->query($sql7);

        while($row7 = $result7->fetch_array(MYSQLI_NUM))
        {

         $tarifa = $row7[0];
         $distancia = $row7[1];
         

       }



       
  ?>

        <tr>
         <td valign="top" align=center>
           <?php echo $id; ?> 
         </td>
         <td valign="top" align=center>
           <?php echo $id_t; ?> 
         </td>
         <td valign="top" align=center>
           <?php echo $fecha; ?> 
         </td>
         <td valign="top" align=center>
           <?php echo $lat_i; ?> 
         </td>
         <td valign="top" align=center>
           <?php echo $long_i; ?>
        </td>
         <td valign="top" align=center>
           <?php echo $lat_f; ?> 
         </td>
         <td valign="top" align=center>
           <?php echo $long_f; ?> 
         </td>
         <td valign="top" align=center>
           <?php echo $distancia."km"; ?> 
         </td>
         <td valign="top" align=center>
           <?php echo $tarifa." pesos"; ?> 
         </td>
        </tr>


<?php
   
}
?>



     </body>

</html>

