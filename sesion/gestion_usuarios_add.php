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
          <link rel="stylesheet" href="css/estilos_virtual.css" 			type="text/css">
           <title> Gestion Usuarios Adicionar </title>
        </head>
       <body>
        <table width="100%" align=center cellpadding=5 border=0 bgcolor="#000000">
    	   <tr>
           <td valign="top" align=left width=70%>
              <table width="100%" align=center border=0>
            	   <tr>
                  <td valign="top" align=center width=30%>
                     <img src="imagen/taximetro.jpg" border=0 width=350 height=80> 
             	    </td>
                  <td valign="top" align=center width=60%>
                     <h1><font color=yellow>Sistema de Taximetro inteligente </font></h1>
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
<?php
include "menu_admin.php";


if ((isset($_POST["enviado"])))
  {
   //echo "grabar cambios modificación";
   $nombre_usuario = $_POST["nombre_usuario"];
   $nombre_usuario = str_replace("ñ","n",$nombre_usuario);
   $nombre_usuario = str_replace("Ñ","N",$nombre_usuario);
   $num_id = $_POST["num_id"];
   $tipo_usuario = $_POST["tipo_usuario"];
   $direccion = $_POST["direccion"];
   $login = $_POST["login"];
   $activo = $_POST["activo"];
   $password = $_POST["password"];
   $id_tarjeta = $_POST["id_tarjeta"];
   $ocupacion = $_POST["ocupacion"];
   $mail = $_POST["mail"];
   $password_enc = md5($password);
   $mysqli = new mysqli($host, $user, $pw, $db);
   $sqlcon = "SELECT * from usuarios where identificacion='$num_id'";
   $resultcon = $mysqli->query($sqlcon);
   $rowcon = $resultcon->fetch_array(MYSQLI_NUM);
   $numero_filas = $resultcon->num_rows;
  
   if ($numero_filas > 0)
     { 
     
         header('Location: interfaz_administrador.php?mensaje=5');
     }
   else
    {
      $sql = "INSERT INTO usuarios(tipo_usuario, nombre_completo, identificacion, passwd, direccion, login, activo, id_tarjeta, ocupacion, mail) 
      VALUES ('$tipo_usuario','$nombre_usuario','$num_id','$password_enc','$direccion','$login','$activo','$id_tarjeta','$ocupacion','$mail')";
      //echo "sql es...".$sql;
      $result1 = $mysqli->query($sql);
      
      if ($result1 == 1) 
        {
          header('Location: interfaz_administrador.php?mensaje=3');
        }
      else
         header('Location: interfaz_administrador.php?mensaje=4');
      
    }
}

else

{

   ?>
	
	   <tr valign="top">
                <td width="50%" height="20%" align="left" 				
                    bgcolor="#FFFFFF" class="_espacio_celdas" 					
                    style="color: #FFFFFF; 
			             font-weight: bold">
			    <font FACE="arial" SIZE=2 color="#000044"> <b><h1>Gestión Usuarios </h1>  Adición Usuario</b></font>  
          

		       </td>
	          <td width="50%" height="20%" align="right" 				
                    bgcolor="#FFFFFF" class="_espacio_celdas" 					
                    style="color: #FFFFFF; 
			             font-weight: bold">
			  <img src="imagen/gestion_usuarios.jpg" border=0 width=115 height=115>    
		       </td>
		     </tr>
   	     <tr>
                  <td colspan=2 width="25%" height="20%" align="left" 				
                    bgcolor="#FFFFFF" class="_espacio_celdas" 					
                    style="color: #FFFFFF; 
			             font-weight: bold">

                   <form method=POST action="gestion_usuarios_add.php">
                   <table width=50% border=1 align=center>
			    <tr>	
				<td bgcolor="#A8DDA8" align=center> 
				  <font FACE="arial" SIZE=2 color="#004400"> <b>Nombre y apellido</b></font>  
				</td>	
				<td bgcolor="#EEEEEE" align=center> 
				  <input type="text" name=nombre_usuario value="" required>  
				</td>	
       </tr>
	     <tr>
				<td bgcolor="#A8DDA8" align=center> 
				  <font FACE="arial" SIZE=2 color="#004400"> <b>Numero de cedula</b></font>  
				</td> 	
				<td bgcolor="#EEEEEE" align=center> 
				  <input type="number" name=num_id value="" required>  
				</td>	
			     </tr>
		     <tr>
				<td bgcolor="#A8DDA8" align=center> 
				  <font FACE="arial" SIZE=2 color="#004400"> <b>Tipo Usuario</b></font>  
				</td>
				<td bgcolor="#EEEEEE" align=center> 
			    <select name=tipo_usuario required> 
           <?php 	
           $sql6 = "SELECT * from tipo_usuario order by id DESC";
           $result6 = $mysqli->query($sql6);
           while($row6 = $result6->fetch_array(MYSQLI_NUM))
            {
              $tipo_usuario_con = $row6[0];
              $desc_tipo_usuario_con = $row6[1];
           ?>   
              <option value="<?php echo $tipo_usuario_con; ?>"> <?php echo $desc_tipo_usuario_con; ?></option>  
           <?php
            }
           ?>           
          </select>
				</td>	
			     </tr>
	     <tr>
				<td bgcolor="#A8DDA8" align=center> 
				  <font FACE="arial" SIZE=2 color="#004400"> <b>Usuario</b></font>  
				</td>
				<td bgcolor="#EEEEEE" align=center> 
				  <input type="text" name=login value="" required>  
				</td>	
	     </tr>

	     <tr>
				<td bgcolor="#A8DDA8" align=center> 
				  <font FACE="arial" SIZE=2 color="#004400"> <b>Clave</b></font>  
				</td>
				<td bgcolor="#EEEEEE" align=center> 
				  <input type="password" name=password value="" required>  
				</td>	
	     </tr>

	     <tr>
				<td bgcolor="#A8DDA8" align=center> 
				  <font FACE="arial" SIZE=2 color="#004400"> <b>Dirección</b></font>  
				</td>
				<td bgcolor="#EEEEEE" align=center> 
				  <input type="text" name=direccion value="" required>  
				</td>	
	     </tr>
			 <tr>
				<td bgcolor="#A8DDA8" align=center> 
				  <font FACE="arial" SIZE=2 color="#004400"> <b>Teléfono</b></font>  
				</td>
			     <td bgcolor="#EEEEEE" align=center> 
				  <input type="number" name=telefono value="" required>  
				</td>	
       </tr>
			 <tr>
				<td bgcolor="#A8DDA8" align=center> 
				  <font FACE="arial" SIZE=2 color="#004400"> <b>Id Dispositivo</b></font>  
				</td>
			     <td bgcolor="#EEEEEE" align=center> 
				  <input type="number" name=id_tarjeta value="" required>  
				</td>	
       </tr>
	     <tr>
				<td bgcolor="#A8DDA8" align=center> 
				  <font FACE="arial" SIZE=2 color="#004400"> <b>Activo (S/N)</b></font>  
				</td>
				<td bgcolor="#EEEEEE" align=center> 
          <select name=activo required> 
            <option value="1"> S (Activo)</option>  
            <option value="0"> N (Inactivo)</option>  
          </select>
				</td>	
	     </tr>
               
          <?php
        if ($desc_tipo_usuario == 'administrador'){
           ?>
       <tr>
       <td bgcolor="#A8DDA8" align=center> 
          <font FACE="arial" SIZE=2 color="#004400"> <b>Placa vehiculo</b></font>  
        </td>
        <td bgcolor="#EEEEEE" align=center> 
          <font FACE="arial" SIZE=2 color="#004400"> <b>No aplica</b></font> 
        </td> 
       </tr>
        <?php
          }
          else
          {
        ?>
       <tr>
       <td bgcolor="#A8DDA8" align=center> 
          <font FACE="arial" SIZE=2 color="#004400"> <b>Placa vehiculo</b></font>  
        </td>
        <td bgcolor="#EEEEEE" align=center> 
          <input type="text" name=ocupacion value="" required>  
        </td> 
       </tr>
        <?php
         }
        ?>

       
       <tr>
        <td bgcolor="#A8DDA8" align=center> 
          <font FACE="arial" SIZE=2 color="#004400"> <b>Mail</b></font>  
        </td>
        <td bgcolor="#EEEEEE" align=center> 
          <input type="text" name=mail value="" required>  
        </td> 
       </tr>
      </table>
         </br>
         <input type="hidden" value="S" name="enviado">
         <table width=50% align=center border=0>
           <tr>  
             <td width=50%></td>                                                                       
             <td align=center><input style="background-color: #DBA926" type=submit color= blue value="Grabar" name="Modificar">
                  </form> 
             </td>  
             <td align=left>
                  <form method=POST action="interfaz_administrador.php">                   
                  <input style="background-color: #EEEEEE" type=submit color= blue value="Volver" name="Volver">              
                  </form> 
             </td>  
           </tr>
                   </table>
                  </form> 
<br><br><hr>
                  </td>
                </tr>  

<?php
 }
?>

        </table>
        
       </body>
      </html>


   
