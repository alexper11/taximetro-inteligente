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
           <title> Interfaz administrador </title>
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
                    bgcolor="#EEEEEE" class="_espacio_celdas" 					
                    style="color: #FFFFFF; 
			             font-weight: bold">
			    <font FACE="arial" SIZE=2 color="#000044"> <b><h1>Interfaz administrador </h1></b></font>  


		       </td>
	          <td height="20%" align="right" 				
                    bgcolor="#EEEEEE" class="_espacio_celdas" 					
                    style="color: #FFFFFF; 
			             font-weight: bold">
			  <img src="imagen/gestion_usuarios.jpg" border=0 width=115 height=115>    
		       </td>
		     </tr>
		    </table>
    <table width="100%" align=center cellpadding=5 border=0 bgcolor="#EEEEEE">
      <tr>
       <td align=left width=50%>
        <form action="gestion_usuarios.php" method="POST">
         <table border=0 width=100%>   
          <tr>
           <td align=left >
             <font FACE="arial" SIZE=2 color="#000000">Consulta por cedula: <input type="number" name=id_con value=""></font>
           </td>
           <td align=right >
             <font FACE="arial" SIZE=2 color="#000000">Consulta por nombre: <input type="text" name=nombre_con value=""></font>
           </td>
          </tr>
         </table>
        </td>
       <td align=left width=50%>
         <table border=0 width=100%>   
          <tr>
           <td align=right width=50%>
             <font FACE="arial" SIZE=2 color="#000000">Estado Usuario: 
             <select name=estado>
             <?php
             if (isset($_POST["estado"]))
              {
                $estado = $_POST["estado"];
                 if ($_POST["estado"]!="")
                  {  
                    if ($estado == "2")
                     {
                      echo "<option value=".$estado."> Todos los Usuarios</option>";
                      echo "<option value=1> Usuarios solo Activos</option>";
                      echo "<option value=0> Usuarios solo Inactivos</option>";
                     }
                    else if ($estado == "1")
                     {
                      echo "<option value=".$estado."> Usuarios solo Activos</option>";
                      echo "<option value=2> Todos los Usuarios</option>";
                      echo "<option value=0> Usuarios solo Inactivos</option>";
                     }
                    else if ($estado == "0")
                     { 
                      echo "<option value=".$estado."> Usuarios solo Inactivos</option>";
                      echo "<option value=2> Todos los Usuarios</option>";
                      echo "<option value=1> Usuarios solo Activos</option>";
                     }
                  }  
               }
              else
               {
                 ?>
                  <option value=2> Todos los Usuarios</option>
                  <option value=1> Usuarios solo Activos </option>
                  <option value=0> Usuarios solo Inactivos &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
              <?php
               }
              ?>  
              </select>
           </td>
           <td align=center width=50%>
             <font FACE="arial" SIZE=2 color="#000000"><input type="submit" name=Consultar value="Consultar"></font>
           </td>
          </tr>
         </table>
          <input type="hidden" value="1" name="enviado">
         </form>
        </td>
      </tr>


      <tr>
       <td>
         &nbsp;&nbsp;&nbsp;
       </td>
      <td align=center>
        <a href="gestion_usuarios_add.php"> <b>Nuevo Usuario </b></a>    
      </td>
      </tr>
     <?php
      if (isset($_GET["mensaje"]))
      {
        $mensaje = $_GET["mensaje"];
        if ($_GET["mensaje"]!=""){?>
      
  		     <tr>
             <td> </td>
             <td height="20%" align="left">
                  <table width=60% border=1>
                   <tr>
                    <?php 
                       if ($mensaje == 1)
                         echo "<td bgcolor=#DDFFDD class=_espacio_celdas_p 					
                    style=color: #000000; font-weight: bold >Usuario actualizado correctamente.";
                       if ($mensaje == 2)
                         echo "<td bgcolor=#FFDDDD class=_espacio_celdas_p 					
                    style=color: #000000; font-weight: bold >Usuario no fue actualizado correctamente.";
                       if ($mensaje == 3)
                         echo "<td bgcolor=#DDFFDD class=_espacio_celdas_p 					
                    style=color: #000000; font-weight: bold >Usuario creado correctamente.";
                       if ($mensaje == 4)
                         echo "<td bgcolor=#FFDDDD class=_espacio_celdas_p 					
                    style=color: #000000; font-weight: bold >Usuario no fue creado. Se presentó un inconveniente";
                       if ($mensaje == 5)
                         echo "<td bgcolor=#FFDDDD class=_espacio_celdas_p 					
                    style=color: #000000; font-weight: bold >Usuario no fue creado. Ya existe usuario con la misma cédula.";

             echo "</td></tr>
                  </table>
              </td>
    		     </tr>";

            }
           }   
            ?>                         

	  	     <tr>
                  <td colspan=2 height="20%" align="left" 				
                    bgcolor="#EEEEEE" class="_espacio_celdas" 					
                    style="color: #FFFFFF; 
			             font-weight: bold">

     <table width=80% border=1 align=center>
			 <tr>	
				<td bgcolor="yellow" align=center> 
				  <font FACE="arial" SIZE=2 color="#004400"> <b>Nombre Usuario</b></font>  
				</td>	
				<td bgcolor="yellow" align=center> 
				  <font FACE="arial" SIZE=2 color="#004400"> <b>Cedula ciudadania</b></font>  
				</td> 	
				<td bgcolor="yellow" align=center> 
				  <font FACE="arial" SIZE=2 color="#004400"> <b>Direccion</b></font>  
				</td> 	
				<td bgcolor="yellow" align=center> 
				  <font FACE="arial" SIZE=2 color="#004400"> <b>Usuario</b></font>  
				</td>
				<td bgcolor="yellow" align=center> 
				  <font FACE="arial" SIZE=2 color="#004400"> <b>Tipo Usuario</b></font>  
				</td>
				<td bgcolor="yellow" align=center> 
				  <font FACE="arial" SIZE=2 color="#004400"> <b>Id dispositivo</b></font>  
				</td>
				<td bgcolor="yellow" align=center> 
				  <font FACE="arial" SIZE=2 color="#004400"> <b>Activo (S/N)</b></font>  
				</td>
        <td bgcolor="yellow" align=center> 
          <font FACE="arial" SIZE=2 color="#004400"> <b>Placa Vehiculo</b></font>  
        </td>
        <td bgcolor="yellow" align=center> 
          <font FACE="arial" SIZE=2 color="#004400"> <b>Mail</b></font>  
        </td>
   	    <td bgcolor="yellow" align=center> 
				  <font FACE="arial" SIZE=2 color="#004400"> <b>Modificar</b></font>  
				</td>
        <td bgcolor="yellow" align=center> 
          <font FACE="arial" SIZE=2 color="#004400"> <b>Eliminar</b></font>  
        </td>
			</tr>
				  
<?php
         $mysqli = new mysqli($host, $user, $pw, $db);
		     if ((isset($_POST["enviado"])))
         {
           $id_con = $_POST["id_con"];
           $nombre_con = $_POST["nombre_con"];
           $estado = $_POST["estado"];
           $sql1 = "SELECT * from usuarios order by nombre_completo";
           if (($id_con == "") and ($nombre_con == ""))
             {
              if ($estado != "2")
                $sql1 = "SELECT * from usuarios where activo='$estado' order by nombre_completo";
             }
           if (($id_con != "") and ($nombre_con == ""))
             {
              if ($estado == "2")
                $sql1 = "SELECT * from usuarios where identificacion='$id_con'";
              else
                $sql1 = "SELECT * from usuarios where identificacion='$id_con' and activo='$estado'";
             }
           if (($id_con == "") and ($nombre_con != ""))
             {
              if ($estado == "2")
                $sql1 = "SELECT * from usuarios where nombre_completo LIKE '%$nombre_con%' order by nombre_completo";
              else
                $sql1 = "SELECT * from usuarios where nombre_completo LIKE '%$nombre_con%' and activo='$estado' order by nombre_completo";
              }
           if (($id_con != "") and ($nombre_con != ""))
             {
              if ($estado == "2")
                 $sql1 = "SELECT * from usuarios where nombre_completo LIKE '%$nombre_con%' and identificacion='$id_con'";
              else
                $sql1 = "SELECT * from usuarios where nombre_completo LIKE '%$nombre_con%' and identificacion='$id_con' and activo='$estado'";
             }      
          }
         else
             $sql1 = "SELECT * from usuarios order by nombre_completo";
             
         //echo "sql1 es...".$sql1;
         
         $result1 = $mysqli->query($sql1);
         while($row1 = $result1->fetch_array(MYSQLI_NUM))
         {
			    $id_usu  = $row1[0];
			    $id_usu_enc = md5($id_usu);
			    $nombre_usuario  = $row1[1];
	     	  $num_id = $row1[2];
	     	  $direccion = $row1[3];
	     	  $usuario= $row1[5];
          $tipo_usuario  = $row1[7];
          $id_tarjeta = $row1[8];
	     	  $activo= $row1[9];
          $ocupacion= $row1[10];
          $mail= $row1[11];
			    if ($activo == 1)
				    $desc_activo = "S";
			    else
				    $desc_activo = "N";

     	    $sql3 = "SELECT * from tipo_usuario where id='$tipo_usuario'";
          $result3 = $mysqli->query($sql3);
          $row3 = $result3->fetch_array(MYSQLI_NUM);
			    $desc_tipo_usuario = $row3[1];

?>
		
		        <tr>	
				<td bgcolor="#EEEEEE" align=center> 
				  <font FACE="arial" SIZE=2 color="#000000"> <b> <?php echo $nombre_usuario; ?></b></font>  
				</td>	
				<td bgcolor="#EEEEEE" align=center> 
				  <font FACE="arial" SIZE=2 color="#000000"> <b><?php echo $num_id; ?></b></font>  
				</td>	
				<td bgcolor="#EEEEEE" align=center> 
				  <font FACE="arial" SIZE=2 color="#000000"> <b><?php echo $direccion; ?></b></font>  
				</td> 	
				<td bgcolor="#EEEEEE" align=center> 
				  <font FACE="arial" SIZE=2 color="#000000"> <b><?php echo $usuario; ?></b></font>  
				</td>
				<td bgcolor="#EEEEEE" align=center> 
				  <font FACE="arial" SIZE=2 color="#000000"> <b><?php echo $desc_tipo_usuario; ?></b></font>  
				</td>
				<td bgcolor="#EEEEEE" align=center> 
				  <font FACE="arial" SIZE=2 color="#000000"> <b><?php echo $id_tarjeta; ?></b></font>  
				</td>
				<td bgcolor="#EEEEEE" align=center> 
				  <font FACE="arial" SIZE=2 color="#000000"> <b><?php echo $desc_activo; ?></b></font>  
				</td>
        <td bgcolor="#EEEEEE" align=center> 
          <font FACE="arial" SIZE=2 color="#000000"> <b><?php echo $ocupacion; ?></b></font>  
        </td>
        <td bgcolor="#EEEEEE" align=center> 
          <font FACE="arial" SIZE=2 color="#000000"> <b><?php echo $mail; ?></b></font>  
        </td>
        <td bgcolor="#EEEEEE" align=center> 
				  <font FACE="arial" SIZE=2 color="#000000"> <a href="gestion_usuarios_mod.php?id_usu=<?php echo $id_usu_enc; ?>"> <img src="imagen/icono_edit.jpg" border=0 width=40 height=30></a></font>  
				</td>
        <?php
        if ($desc_tipo_usuario == 'administrador'){
           ?>
            <td bgcolor="#EEEEEE" align=center> 
          <font FACE="arial" SIZE=2 color="#000000"> <b>No aplica</b></font>  
        </td>
        <?php
          }
          else
          {
        ?>
         <td bgcolor="#EEEEEE" align=center> 
          <font FACE="arial" SIZE=2 color="#000000"> <input type="submit" name=Eliminar value="Eliminar" onclick = "<?php echo $id_usu_enc; $sql6 = "DELETE from usuarios where  id=5"; $q = $mysqli->query($sql6); ?>"></font>  
                           
        </td>
        <?php
         }
        ?>

	     </tr>
		     
	     	         
<?php
			   }
?>


                   </table>
<br><br><hr>
                  </td>
                </tr>  
        </table>
        
       </body>
      </html>


   
