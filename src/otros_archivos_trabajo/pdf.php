<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('America/Bogota');
header("Content-Type: text/html;charset=utf-8");

require_once 'dompdf/lib/html5lib/Parser.php'; 
require_once 'dompdf/src/Autoloader.php';
Dompdf\Autoloader::register();
use Dompdf\Dompdf;
	
	$fecha="Bogotá D.C., ".date('l, d M Y');
	$senores= "";
	$persona= "";
	$cedula= "".$_POST['Documento'];
	$ciudad= "";
	$asunto= "<strong>Asunto: Respuesta a PQR </strong>".$_POST['NumeroPQR'];
	$numero_pqr="";
	$encabezado="Respetados Señores:";
	$cuerpo="Reciba un cordial saludo. En respuesta a su requerimiento recibido el ".$_POST['FechaCreacionCaso'].", mediante el cual solicita el pago de la cuota a favor de su trabajadora ----- identificada con CC. ".$_POST['Documento'].".";
	$respuesta="Por lo anterior nos permitimos detallar la respuesta así:"."<br />";
	$descripcion="".$_POST['CampoRespuesta'];
	$respuesta2=$_POST['CampoRespuesta'];
	
	$fin_pagina="Cordialmente,<br /><br />
				Coordinación de Servicio al Cliente Corporativo";
	
$_pagina_pqr="
	<!DOCTYPE html>
	<html>
		<head>
			<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
			<style> 
				body {
					background-image: url(\"images/membrete-01.png\");
					background-color: #fff;
					background-repeat: no-repeat;
					background-size:contain;
					color:#444 !important;
					font-size:14px !important;
					font-family:Arial, Helvetica, sans-serif;
					padding-top:70px;
				}
				.fecha {
					position: absolute;
					left:450px;
					top: 10px;
				}
				.proyecto{
					background-image: url(\"../wordpress/wp-content/uploads/2018/08/ocana-01.jpg\");
					background-color: #fff;
					background-repeat: no-repeat;
					background-size:contain;
					color:#444 !important;
					font-size:14px !important;
					font-family:Arial, Helvetica, sans-serif;
					padding-top:70px;
				}
			</style>
		</head>
		
		<body>
			<div class=\"fecha\">".$fecha."</div>
			
			<div class=\"proyecto\">
				
				<h4>Caminos del Sie</h4>
				<p><strong>Los apartamentos cuentan con:</strong></p>
				<p>2 alcobas, area social, 1 disponible, 1 baño social, 1 disponible para baño o vestier, cocina, zona de ropas.</p>
			</div>
			<div>Valor del proyectos $109.800.000</div>
			<div>Área Construida 43,50 metros</div>
			<div>Área Privada 35,50 metros</div>
			
			
			<table cellpadding='0' cellspacing='0' style='max-width:600px; margin:auto;' width='100%'>
			 <tbody>
			  <tr>
				<td align='center' bgcolor='#011f5a' colspan='5' style='color:#FFF !important;'> Proyecto preferencial para afiliados a Colsubsidio</td>
			  </tr>
			  <tr>
				<td bgcolor='#4674C1' style='color:#FFF !important;' width='40%'><strong>Condiciones de venta</strong></td>
				<td bgcolor='#4674C1' colspan='2' style='color:#FFF !important;' width='30%'><strong>Sin acabados</strong></td>
				<td bgcolor='#ffc92f' colspan='2' style='color:#FFF !important;' width='30%'><strong>Con acabados</strong></td>
			  </tr>
			  <tr>
				<td><strong>Valor del inmueble</strong></td>
				<td bgcolor='#d7e5fb' class='text-right' colspan='2'><strong>$ 102.000.000</strong></td>
				<td bgcolor='#fdf3d6' class='text-right' colspan='2'><strong>$ 110.000.000</strong></td>
			  </tr>
			  <tr>
				<td><div style='float: left;display: inline-block'> Cuota inicial &nbsp;</div>
				  <div style='float: left;display: inline-block'><strong>30</strong></div>
				  <div style='float: left;display: inline-block'><strong> % </strong></div></td>
				<td class='text-right' colspan='2'>$ 30.600.000</td>
				<td class='text-right' colspan='2'>$ 33.000.000</td>
			  </tr>
			  <tr>
				<td>Separación</td>
				<td bgcolor='#d7e5fb' class='text-right' colspan='2'>$ 1.000.000</td>
				<td bgcolor='#fdf3d6' class='text-right' colspan='2'><font style='vertical-align: inherit;'><font style='vertical-align: inherit;'>$ 1.000.000</font></font></td>
			  </tr>
			  <tr>
				<td>Ingresos grupo familiar</td>
				<td class='text-right' colspan='2'>$ 1.500.000</td>
				<td class='text-right' colspan='2'><font style='vertical-align: inherit;'><font style='vertical-align: inherit;'>$ 1.500.000</font></font></td>
			  </tr>
			  <tr>
				<td>Subsidio aproximado</td>
				<td bgcolor='#d7e5fb' class='text-right' colspan='2'>$ 23.437.260</td>
				<td bgcolor='#fdf3d6' class='text-right' colspan='2'><font style='vertical-align: inherit;'><font style='vertical-align: inherit;'>$ 23.437.260</font></font></td>
			  </tr>
			  <tr>
				<td>Ahorros</td>
				<td class='text-right' colspan='2'>$ 2.000.000</td>
				<td class='text-right' colspan='2'><font style='vertical-align: inherit;'><font style='vertical-align: inherit;'>$ 2.000.000</font></font></td>
			  </tr>
			  <tr>
				<td>Cesantías</td>
				<td bgcolor='#d7e5fb' class='text-right' colspan='2'><font style='vertical-align: inherit;'><font style='vertical-align: inherit;'>$ 1.000.000</font></font></td>
				<td bgcolor='#fdf3d6' class='text-right' colspan='2'><font style='vertical-align: inherit;'><font style='vertical-align: inherit;'>$ 1.000.000</font></font></td>
			  </tr>
			  <tr>
				<td>Saldo en cuota inicial</td>
				<td class='text-right' colspan='2'>$ 3.162.740</td>
				<td class='text-right' colspan='2'>$ 5.562.740</td>
			  </tr>
			  <tr>
				<td><div style='float: left;display: inline-block'> 11 </div>
				  <div style='float: left;display: inline-block'> &nbsp; Cuotas mensuales </div></td>
				<td bgcolor='#d7e5fb' class='text-right' colspan='2'>$ 287.522</td>
				<td bgcolor='#fdf3d6' class='text-right' colspan='2'>$ 505.704</td>
			  </tr>
			  <!--bindings={
		  'ng-reflect-ng-if': 'true'
		}--><!---->
			  <tr>
				<td align='center' bgcolor='#011f5a' colspan='5' style='color:#FFF !important;'> Información Crédito hipotecario Colsubsidio </td>
			  </tr>
			  <tr>
				<td colspan='1'><strong>Crédito requerido</strong></td>
				<td bgcolor='#d7e5fb' colspan='2'><strong>$ 71.400.000</strong></td>
				<td bgcolor='#fdf3d6' colspan='2'><strong>$ 77.000.000</strong></td>
			  </tr>
			  <tr>
				<td>Plazo (Aprox)</td>
				<td bgcolor='#4674C1' style='color:#FFF !important;'>Cuota UVR </td>
				<td bgcolor='#4674C1' style='color:#FFF !important;'>Cuota Pesos</td>
				<td bgcolor='#ffc92f' style='color:#FFF !important;'><font style='vertical-align: inherit;'><font style='vertical-align: inherit;'>Cuota UVR </font></font></td>
				<td bgcolor='#ffc92f' style='color:#FFF !important;'><font style='vertical-align: inherit;'><font style='vertical-align: inherit;'>Cuota Pesos</font></font></td>
			  </tr>
			  <tr>
				<td>10 años</td>
				<td bgcolor='#d7e5fb' class='text-right'>$ 825.609</td>
				<td bgcolor='#d7e5fb' class='text-right'>$ 1.062.827</td>
				<td bgcolor='#fdf3d6' class='text-right'>$ 888.245</td>
				<td bgcolor='#fdf3d6' class='text-right'>$ 1.146.186</td>
			  </tr>
			  <tr>
				<td>15 años</td>
				<td class='text-right'>$ 635.185</td>
				<td class='text-right'>$ 902.868</td>
				<td class='text-right'>$ 682.886</td>
				<td class='text-right'>$ 973.681</td>
			  </tr>
			  <tr>
				<td>20 años</td>
				<td bgcolor='#d7e5fb' class='text-right'>$ 544.150</td>
				<td bgcolor='#d7e5fb' class='text-right'>$ 837.486</td>
				<td bgcolor='#fdf3d6' class='text-right'>$ 584.711</td>
				<td bgcolor='#fdf3d6' class='text-right'>$ 903.172</td>
			  </tr>
			</tbody>
		  </table>
			
			
			
			<table width='100%' border='1' cellpadding='4' cellspacing='0' bordercolor='#011F5B'>
			  <tr>
				<th scope='col' style='background-color:#011F5B; color:#FFF !important;' width='40%'>Afiliado</th>
				<th scope='col' style='background-color:#011F5B; color:#FFF !important;' width='60%'>Descripción</th>
			  </tr>
			  <tr>
				<td>".$persona."<br />".$cedula."</td>
				<td>".$descripcion."</td>
			  </tr>
			</table>				
		</body>
	</html>
";
			 
	 	  
			$dompdf = new DOMPDF();
			$dompdf->load_html($_pagina_pqr);
			$dompdf->set_paper("letter", "portrait");
			$dompdf->render();
			
			$dompdf->stream("dompdf_out.pdf", array("Attachment" => false));
			$output = $dompdf->output();			
			//file_put_contents('pdf/aporte_'.$boleta.'_'.$cedula.'.pdf', $output);
			//exit(0);
 
 
//echo $_pagina_pqr;

?>