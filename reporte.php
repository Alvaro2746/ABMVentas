<?php
include_once("config.php");
include_once("entidades/venta.php");

$venta= new Venta();

$anio = $_SESSION["aniofin"];
$mes = $_SESSION["mesfin"];
$dia = $_SESSION["diafin"];



$fechaHasta = $dia."/".$mes."/".$anio;
$fechaHasta=date($fechaHasta);

$fechaDesde = "01/01/".$anio;
$fechaDesde=date($fechaDesde);

$ventasPeriodo=$venta->obtenerFacturacionPorPeriodo($fechaDesde, $fechaHasta);
print_r($venta);
exit;



$venta->imprimirTicket();
?>