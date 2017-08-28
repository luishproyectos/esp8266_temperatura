<!DOCTYPE html>
<html>
<head>
 <title>Respuesta MySQL</title>
 <meta charset="UTF-8">
</head>
<body>
<?php

$conexion = mysql_connect("localhost", "root", "");
mysql_select_db("datos", $conexion);
mysql_query("SET NAMES 'utf8'");

function temperatura_diaria ($chipId,$ano,$mes,$dia) {

 $resultado=mysql_query("SELECT UNIX_TIMESTAMP(fecha), temperatura FROM tabla WHERE year(`fecha`) = '$ano' AND month(`fecha`) = '$mes' AND day(`fecha`) = '$dia' AND `chipId`= '$chipId'");

 while ($row=mysql_fetch_array($resultado))
 {
  echo "[";
  echo ($row[0]*1000)-14400000; //le resto 4 horas = 14400000 mill
  echo ",";                     //por ser VENEZUELA (-4)
  echo $row[1];
  echo "],";
 }
}
?>

<div id="container1" style="width: 100%; height: 400px;"></div>

<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/highcharts.js"></script>
<script src="js/exporting.js"></script>

<script>
$(function () {
    $('#container1').highcharts({
        chart: {
            type: 'line',
            zoomType: 'x'
        },
        colors: ['#337ab7', '#cc3c1a'],
        title: {
            text: 'Temperatura'
        },
        xAxis: {
             type: 'datetime',         
        },
        yAxis: {
            title: {
                text: 'Temperatura'
            }
        },
      
        series: [{
            name: 'Temp',
            data: [<?php
                $chipId = $_POST ['chipId'];
                $fecha = $_POST ['fecha'];
                $ano = substr("$fecha", 0, 4); // 2017/07/16
                $mes = substr("$fecha", 5, 2);
                $dia = substr("$fecha", 8, 2);
                temperatura_diaria($chipId, $ano , $mes, $dia);
             ?>   
        ]},   
    ],
    });
});
</script>
</body>
</html>