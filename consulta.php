<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>Monitoreo INGESER</title>
</head>
<body>
<?php
$conexion = mysql_connect("localhost", "root", "");
mysql_select_db("datos", $conexion);
mysql_query("SET NAMES 'utf8'");

$resultado = mysql_query("SELECT DISTINCT `chipId` FROM `tabla` WHERE 1");

?>
<form action="respuesta.php" method="POST">
  <select name="chipId">
  <?php
    while ($row=mysql_fetch_array($resultado))
      {
       echo "<option>";
        echo $row[0];
        echo "</option>";
      }
    mysql_close();
  ?>
  </select><br>
  <input type="date" name="fecha" ><br>
  <input type="submit" name="Enviar" >
</form>
</body> 
</html>