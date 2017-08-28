<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Medidor de Temperatur</title>

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


    <script src="js/loader.js"></script>
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/jquery-3.2.1.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/highcharts.js"></script>
    <script src="js/exporting.js"></script>


    
    <script type="text/javascript">

      google.charts.load('current', {'packages':['gauge']});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['Temperatura', 0]
         
        ]);
        var options = {
          width: 300, height: 300,
          redFrom: 80, redTo: 100,
          yellowFrom:65, yellowTo: 80,
          minorTicks: 5
        };
        var chart = new google.visualization.Gauge(document.getElementById('temperatura'));
        chart.draw(data, options);
        setInterval(function() {
            var JSON=$.ajax({
                url:"http://192.168.1.11/temperatura/DatoSensores.php?q=1",
                dataType: 'json',
                async: false}).responseText;
            var Respuesta=jQuery.parseJSON(JSON);
            
          data.setValue(0, 1,Respuesta[0].temperatura);
          chart.draw(data, options);
        }, 3000);
        
      }
    </script>



</head>
<body>
<div class="jumbotron text-center">
    <h1>Monitoreo de Temperatura</h1>
    <h4>En tiempo real</h4> 
  </div>
<br>

<div class="container">
        <div class="row">


<div class="col-sm-4">
       <div id="temperatura" ></div>

<br>
</div>

<div class="col-sm-4"></div>

<div class="col-sm-4">


 <?php
$conexion = mysql_connect("localhost", "root", "");
mysql_select_db("datos", $conexion);
mysql_query("SET NAMES 'utf8'");

$resultado = mysql_query("SELECT DISTINCT `chipId` FROM `tabla` WHERE 1");

?>

<br>
<br>
<br>

<h4>Registros</h4>
<form action="respuesta.php" method="POST">
  ChipId:
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

  </select>
  <br>
  <br>
  Fecha:
  <input type="date" name="fecha" ><br><br>
  <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-screenshot"></span> Graficar</button>
</form>

<br>
</div>  
</body>
</html>