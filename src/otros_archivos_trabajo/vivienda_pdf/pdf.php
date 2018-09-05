<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL ^ E_NOTICE);
date_default_timezone_set('America/Bogota');
header("Content-Type: text/html;charset=utf-8");

$_id_=$_GET["id"];
//echo $_id_; exit();

/*conn mysql*/
 $bd_servidor="localhost";
 $bd_base="leggerne_vivienda";
 $bd_usuario="leggerne_user";
 $bd_clave="R1.9Ae01n5";
 $con = mysqli_connect($bd_servidor, $bd_usuario, $bd_clave)
		    or die('Error conectando con MySQL!');
		    mysqli_select_db($con, $bd_base) or die('Base de datos ' . $bd_base . ' no existe!');
		    mysqli_query($con, "SET NAMES 'utf8'");
		    mysqli_set_charset( $con, 'utf8');

  $sql="SELECT * FROM wp_cotizaciones_personales where id='".$_id_."' limit 0,1";
  //echo $sql; exit();
	$result = mysqli_query($con,$sql) or die('Cannot info: ' .mysqli_error($con));

	$row = mysqli_fetch_assoc($result);

  mysqli_close($con);

  //echo $row['created'];exit();

	$fecha = $row['created'];
	$json_cotizacion = json_decode($row['json_cotizacion']);

	//fs_ciudad_filtro	fs_proyecto_filtro	fs_proyectosTamano_filtro
	//fs_como_se_entero_filtro	fs_tipo_documento_campo	fs_nombre_documento_campo
	//fs_numeroDocumento_campo	fs_nombres_campo	fs_email_campo
	//fs_afiliadoColsubsidio_campo	fs_celular_campo	fs_abeasdata_campo
	//proyecto_vivienda_seleccionado	fs_ingresosGrupoFamiliar_campo	fs_ahorros_campo	fs_cesantias_campo
	//proyecto_vivienda_seleccionado_inventarioproyecto
	//proyecto_vivienda_seleccionado_valorproyecto
	//proyecto_vivienda_seleccionado_imagen
  //proyecto_vivienda_seleccionado_areaconstruida
  //proyecto_vivienda_seleccionado_areaprivada
  //proyecto_vivienda_cuotainicial_porcentaje
	//asi se trae la imagen del proyecto $array_formulario["proyecto_vivienda_seleccionado_imagen"]
	$array_formulario = (array)$json_cotizacion->formulario;

	//user_email	user_nicename	user_display_name
	$array_info_session_usuario = (array)$json_cotizacion->info_session_usuario;

	//valordelinmueble	cuotainicial	separacion	subsidioaproximado
	//ingresosgrupofamiliar	ahorros	cesantias	saldodecuotainicial	numerocuotasmensuales
	//cuotasmensuales	creditorequerido	cuotauvr_10	cuotauvr_15	cuotauvr_20
	//cuotapesos_10	cuotapesos_15	cuotapesos_20
	$array_sinacabados = (array)$json_cotizacion->condiciones_venta->sinacabados;

	//valordelinmueble	cuotainicial	separacion	subsidioaproximado	ingresosgrupofamiliar
	//ahorros	cesantias	saldodecuotainicial	numerocuotasmensuales	cuotasmensuales
	//creditorequerido	cuotauvr_10	cuotauvr_15	cuotauvr_20	cuotapesos_10	cuotapesos_15	cuotapesos_20
	$array_conacabados = (array)$json_cotizacion->condiciones_venta->conacabados;


/*conn mysql*/


	$fecha="Bogotá D.C., ".date('l, d M Y');
	$senores= "";
	$persona= "";
	$cedula= "".$array_formulario["fs_numeroDocumento_campo"];
	$ciudad= "";
	$asunto= "<strong>Asunto: Respuesta a PQR </strong>".$_id_;
	$numero_pqr="";
	$encabezado="Respetados Señores:";

	$cuerpo="Reciba un cordial saludo. En respuesta a su requerimiento recibido el ".
          $fecha.", mediante el cual solicita el pago de la cuota a favor de su trabajadora ----- identificada con CC. ".
          $array_formulario["fs_numeroDocumento_campo"].".";

	$respuesta="Por lo anterior nos permitimos detallar la respuesta así:"."<br />";
	$descripcion="".$_POST['CampoRespuesta'];
	$respuesta2=$_POST['CampoRespuesta'];

	$fin_pagina="Cordialmente,<br /><br />
				Coordinación de Servicio al Cliente Corporativo";

$_pagina_coti="
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

				<h4>".$array_formulario["proyecto_vivienda_seleccionado"]."</h4>
				<p><strong>Los apartamentos cuentan con:</strong></p>
				<p>".$array_formulario["proyecto_vivienda_seleccionado_inventarioproyecto"]."</p>
			</div>
			<div>Valor del proyectos $".$array_formulario["proyecto_vivienda_seleccionado_valorproyecto"]."</div>
			<div>Área Construida ".$array_formulario["proyecto_vivienda_seleccionado_areaconstruida"]."</div>
			<div>Área Privada ".$array_formulario["proyecto_vivienda_seleccionado_areaprivada"]."</div>


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
				<td bgcolor='#d7e5fb' class='text-right' colspan='2'><strong>$ ".$array_sinacabados["valordelinmueble"]."</strong></td>
				<td bgcolor='#fdf3d6' class='text-right' colspan='2'><strong>$ ".$array_conacabados["valordelinmueble"]."</strong></td>
			  </tr>
			  <tr>
				<td><div style='float: left;display: inline-block'> Cuota inicial &nbsp;</div>
				  <div style='float: left;display: inline-block'><strong>".$array_formulario["proyecto_vivienda_cuotainicial_porcentaje"]."</strong></div>
				  <div style='float: left;display: inline-block'><strong> % </strong></div></td>
				<td class='text-right' colspan='2'>$ ".$array_sinacabados["cuotainicial"]."</td>
				<td class='text-right' colspan='2'>$ ".$array_conacabados["cuotainicial"]."</td>
			  </tr>
			  <tr>
				<td>Separación</td>
				<td bgcolor='#d7e5fb' class='text-right' colspan='2'>$ ".$array_sinacabados["separacion"]."</td>
				<td bgcolor='#fdf3d6' class='text-right' colspan='2'><font style='vertical-align: inherit;'><font style='vertical-align: inherit;'>$ ".$array_conacabados["separacion"]."</font></font></td>
			  </tr>
			  <tr>
				<td>Ingresos grupo familiar</td>
				<td class='text-right' colspan='2'>$ ".$array_formulario["fs_ingresosGrupoFamiliar_campo"]."</td>
				<td class='text-right' colspan='2'><font style='vertical-align: inherit;'><font style='vertical-align: inherit;'>$ xxxxxx</font></font></td>
			  </tr>
			  <tr>
				<td>Subsidio aproximado</td>
				<td bgcolor='#d7e5fb' class='text-right' colspan='2'>$ ".$array_sinacabados["subsidioaproximado"]."</td>
				<td bgcolor='#fdf3d6' class='text-right' colspan='2'><font style='vertical-align: inherit;'><font style='vertical-align: inherit;'>$ ".$array_conacabados["subsidioaproximado"]."</font></font></td>
			  </tr>
			  <tr>
				<td>Ahorros</td>
				<td class='text-right' colspan='2'>$ ".$array_formulario["fs_ahorros_campo"]."</td>
				<td class='text-right' colspan='2'><font style='vertical-align: inherit;'><font style='vertical-align: inherit;'>$ xxxxx</font></font></td>
			  </tr>
			  <tr>
				<td>Cesantías</td>
				<td bgcolor='#d7e5fb' class='text-right' colspan='2'><font style='vertical-align: inherit;'><font style='vertical-align: inherit;'>$ ".$array_formulario["fs_cesantias_campo"]."</font></font></td>
				<td bgcolor='#fdf3d6' class='text-right' colspan='2'><font style='vertical-align: inherit;'><font style='vertical-align: inherit;'>$ xxxxx</font></font></td>
			  </tr>
			  <tr>
				<td>Saldo en cuota inicial</td>
				<td class='text-right' colspan='2'>$ ".$array_sinacabados["saldodecuotainicial"]."</td>
				<td class='text-right' colspan='2'>$ ".$array_conacabados["saldodecuotainicial"]."</td>
			  </tr>
			  <tr>
				<td><div style='float: left;display: inline-block'> 11 </div>
				  <div style='float: left;display: inline-block'> &nbsp; Cuotas mensuales </div></td>
				<td bgcolor='#d7e5fb' class='text-right' colspan='2'>$ ".$array_sinacabados["cuotasmensuales"]."</td>
				<td bgcolor='#fdf3d6' class='text-right' colspan='2'>$ ".$array_conacabados["cuotasmensuales"]."</td>
			  </tr>
			  <!--bindings={
		  'ng-reflect-ng-if': 'true'
		}--><!---->
			  <tr>
				<td align='center' bgcolor='#011f5a' colspan='5' style='color:#FFF !important;'> Información Crédito hipotecario Colsubsidio </td>
			  </tr>
			  <tr>
				<td colspan='1'><strong>Crédito requerido</strong></td>
				<td bgcolor='#d7e5fb' colspan='2'><strong>$ ".$array_sinacabados["creditorequerido"]."</strong></td>
				<td bgcolor='#fdf3d6' colspan='2'><strong>$ ".$array_conacabados["creditorequerido"]."</strong></td>
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
				<td bgcolor='#d7e5fb' class='text-right'>$ ".$array_sinacabados["cuotauvr_10"]."</td>
				<td bgcolor='#d7e5fb' class='text-right'>$ ".$array_sinacabados["cuotapesos_10"]."</td>
				<td bgcolor='#d7e5fb' class='text-right'>$ ".$array_conacabados["cuotauvr_10"]."</td>
				<td bgcolor='#d7e5fb' class='text-right'>$ ".$array_conacabados["cuotapesos_10"]."</td>
			  </tr>
			  <tr>
				<td>15 años</td>
				<td bgcolor='#d7e5fb' class='text-right'>$ ".$array_sinacabados["cuotauvr_15"]."</td>
				<td bgcolor='#d7e5fb' class='text-right'>$ ".$array_sinacabados["cuotapesos_15"]."</td>
				<td bgcolor='#d7e5fb' class='text-right'>$ ".$array_conacabados["cuotauvr_15"]."</td>
				<td bgcolor='#d7e5fb' class='text-right'>$ ".$array_conacabados["cuotapesos_15"]."</td>
			  </tr>
			  <tr>
				<td>20 años</td>
				<td bgcolor='#d7e5fb' class='text-right'>$ ".$array_sinacabados["cuotauvr_20"]."</td>
				<td bgcolor='#d7e5fb' class='text-right'>$ ".$array_sinacabados["cuotapesos_20"]."</td>
				<td bgcolor='#d7e5fb' class='text-right'>$ ".$array_conacabados["cuotauvr_20"]."</td>
				<td bgcolor='#d7e5fb' class='text-right'>$ ".$array_conacabados["cuotapesos_20"]."</td>
			  </tr>
			</tbody>
		  </table>



			<table width='100%' border='1' cellpadding='4' cellspacing='0' bordercolor='#011F5B'>
			  <tr>
				<th scope='col' style='background-color:#011F5B; color:#FFF !important;' width='40%'>Afiliado</th>
				<th scope='col' style='background-color:#011F5B; color:#FFF !important;' width='60%'>Descripción</th>
			  </tr>
			  <tr>
				<td>".$array_formulario["fs_nombres_campo"]."<br />".$array_formulario["fs_numeroDocumento_campo"]."</td>
				<td>".$descripcion."xxxx que descripcion xxxxxx</td>
			  </tr>
			</table>
		</body>
	</html>
";


    //ob_start();
    //include dirname(__FILE__).'/res/bookmark.php';
    //$content = ob_get_clean();

require __DIR__.'/vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;

$html2pdf = new Html2Pdf();
$html2pdf->writeHTML($_pagina_coti);
$html2pdf->output();


?>
