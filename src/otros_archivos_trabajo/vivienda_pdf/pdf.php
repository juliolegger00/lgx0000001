<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL ^ E_NOTICE);
date_default_timezone_set('America/Bogota');
header("Content-Type: text/html;charset=utf-8");

$_id_=$_GET["id"];

$rest = substr($_id_, 0, 15);
$_id_=str_replace($rest,"",$_id_);


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


$_url_="http://192.168.102.10/wordpress/wp-json/wp/v2/info_texto_vivienda/113";
$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL, $_url_);
$result = curl_exec($ch);
curl_close($ch);

$obj_info_text = json_decode($result);
//print_r($obj_info_text);exit();
//echo $obj->access_token;









$asesorvirtual=$array_formulario["asesorvirtual"];
if($asesorvirtual=="")$asesorvirtual=$array_info_session_usuario["user_display_name"];




	$fecha="Bogotá D.C., ".$fecha;//.date('l, d M Y');
	$cedula= "".$array_formulario["fs_numeroDocumento_campo"];

$_pagina_coti='
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Documento sin título</title>
		<style>
			.body{
				color:#555;
				background-color:#EEEEEE;
			}
			.titulo_cotizador{
				position:absolute;
				right:10px;
				color: #011F5B;
				font-size:18px;
			}
			.fecha{
				position:absolute;
				right:10px;
				top:30px;
			}
			.proyecto{
				border-radius:10px;
				border:1px solid #CCC;
				background-color:#F9F9F9;
				padding:2px 5px;
				height: 50px;
				width:750px;
			}
			.cont_proyecto{
				float:left;
				padding-left:10px;
				height:60px;
				width:580px;
			}
			.cliente{
				border-radius:10px;
				border:1px solid #CCC;
				background-color:#F9F9F9;
				padding:2px 5px;
				height: 50px;
				width:690px;
				margin-top:2px;
			}
			.forma_pago{
				border-radius:10px;
				border:1px solid #CCC;
				background-color:#F9F9F9;
				padding:2px 5px;
				height: 45px;
				width:640px;
				margin-top:2px;
			}
			.cotizacion_valores{
				border-radius:10px;
				border:1px solid #CCC;
				background-color:#F9F9F9;
				padding:2px 5px;
				height: 300px;
				width:750px;
				margin-top:2px;
			}
			.adicionales{
				border-radius:10px;
				border:1px solid #CCC;
				background-color:#F9F9F9;
				padding:2px 5px;
				height: 50px;
				width:750px;
				margin-top:2px;
			}
			.terminos{
				border-radius:10px;
				border:1px solid #CCC;
				background-color:#F9F9F9;
				padding:2px 5px;
				height: 50px;
				width:735px;
				margin-top:2px;
			}
			.documentos{
				border-radius:10px;
				border:1px solid #CCC;
				background-color:#F9F9F9;
				padding:2px 5px;
				height: 50px;
				width:750px;
				margin-top:2px;
			}
			.final{
				border-radius:10px;
				border:1px solid #CCC;
				background-color:#F9F9F9;
				padding:2px 5px;
				height: 50px;
				width:750px;
				margin-top:2px;
				box-shadow: 5px 5px 18px -4px #FFF;
			}
		</style>
	</head>
	<body class="body">
		<img src="images/logo-colsubsidio.png" style="border:none;" />
		<div class="fecha">'.$fecha.'</div>
		<div class="titulo_cotizador">Cotización de proyectos Vivienda Colsubsidio</div>
		<div style="clear:both; padding:30px;"></div>

		<div class="proyecto">
			<img src="images/Proyectos_Vivienda.jpg" width="150" style="float:left;" />
			<div class="cont_proyecto">
				<strong>'.$array_formulario["proyecto_vivienda_seleccionado"].' - '.$array_formulario["fs_ciudad_filtro"].'</strong>
				<br />
				Los apartamentos cuentan con:
				'.$array_formulario["proyecto_vivienda_seleccionado_inventarioproyecto"].'
				<table width="100%" border="0" cellspacing="0" cellpadding="2" bordercolor="#CCC" style="margin-top:10px;">
				  <tr>
					<th width="180px;" scope="col">Valor del proyecto</th>
					<th width="180px;" scope="col">Área contruida</th>
					<th width="180px;" scope="col">Área privada</th>
				  </tr>
				  <tr>
					<td>$'.@number_format($array_formulario["proyecto_vivienda_seleccionado_valorproyecto"],0,",",".").'</td>
					<td>'.@number_format($array_formulario["proyecto_vivienda_seleccionado_areaconstruida"],0,",",".").'</td>
					<td>'.@number_format($array_formulario["proyecto_vivienda_seleccionado_areaprivada"],0,",",".").'</td>
				  </tr>
				</table>
			</div>
		</div>

		<div class="cliente">
			<strong>Cliente:</strong>
			<div style="clear:both; padding:0px;"></div>
			<table border="0" cellspacing="0" cellpadding="2" bordercolor="#555" style="margin:5px 0px;">
			  <tr>
				<th width="140px;" scope="col">No. Documento</th>
				<th width="220px;" scope="col">Nombres y apellidos</th>
				<th width="200px;" scope="col">Correo electrónico</th>
				<th width="110px;" scope="col">Celular</th>
				<th width="70px;" scope="col">Afiliado</th>
			  </tr>
			  <tr>
				<td>'.$array_formulario["fs_tipo_documento_campo"].'. '.$array_formulario["fs_numeroDocumento_campo"].'</td>
				<td>'.$array_formulario["fs_nombres_campo"].'</td>
				<td>'.$array_formulario["fs_email_campo"].'</td>
				<td>'.$array_formulario["fs_celular_campo"].'</td>
				<td>'.$array_formulario["fs_afiliadoColsubsidio_campo"].'</td>
			  </tr>
			</table>
		</div>

		<div class="forma_pago">
			<strong>Forma de pago:</strong>
			<div style="clear:both; padding:0px;"></div>
			<table border="0" cellspacing="0" cellpadding="2" bordercolor="#555" style="margin:5px 0px;">
			  <tr>
				<th width="220px;" scope="col">Ingresos grupo familiar</th>
				<th width="220px;" scope="col">Ahorros</th>
				<th width="220px;" scope="col">Cesantías</th>
			  </tr>
			  <tr>
				<td>$'.number_format($array_formulario["fs_ingresosGrupoFamiliar_campo"],0,",",".").'</td>
				<td>$'.number_format($array_formulario["fs_ahorros_campo"],0,",",".").'</td>
				<td>$'.number_format($array_formulario["fs_cesantias_campo"],0,",",".").'</td>
			  </tr>
			</table>
		</div>

		<div class="cotizacion_valores">
			<br />
			<table border="0" cellspacing="0" cellpadding="2" bordercolor="#555" style="margin:5px 0px 0px 0px;">
				<tr>
					<td align="center" bgcolor="#011f5a" colspan="5" style="color:#FFF;"> Proyecto preferencial para afiliados a Colsubsidio</td>
				</tr>
				<tr>
					<td width="240" bgcolor="#4674C1" style="color:#FFF;" ><strong>Condiciones de venta</strong></td>
					<td width="250" bgcolor="#4674C1" style="color:#FFF; text-align:right;" ><strong>Sin acabados</strong></td>
					<td width="250" bgcolor="#ffc92f" style="color:#FFF; text-align:right;" ><strong>Con acabados</strong></td>
				</tr>
				<tr>
					<td><strong>Valor del inmueble</strong></td>
					<td bgcolor="#d7e5fb" style="text-align:right;"><strong>$ '.number_format($array_sinacabados["valordelinmueble"],0,",",".").'</strong></td>
					<td bgcolor="#fdf3d6" style="text-align:right;"><strong>$ '.number_format($array_conacabados["valordelinmueble"],0,",",".").'</strong></td>
				</tr>
				<tr>
					<td>Cuota inicial &nbsp;<strong>'.$array_formulario["proyecto_vivienda_cuotainicial_porcentaje"].'</strong><strong> % </strong></td>
					<td style="text-align:right;" >$ '.number_format($array_sinacabados["cuotainicial"],0,",",".").'</td>
					<td style="text-align:right;" >$ '.number_format($array_conacabados["cuotainicial"],0,",",".").'</td>
				</tr>
				<tr>
					<td>Separación</td>
					<td bgcolor="#d7e5fb" style="text-align:right;">$ '.number_format($array_sinacabados["separacion"],0,",",".").'</td>
					<td bgcolor="#fdf3d6" style="text-align:right;">$ '.number_format($array_conacabados["separacion"],0,",",".").'</td>
				</tr>
				<tr>
					<td>Ingresos grupo familiar</td>
					<td style="text-align:right;">$ '.number_format($array_sinacabados["fs_ingresosGrupoFamiliar_campo"],0,",",".").'</td>
					<td style="text-align:right;">$ '.number_format($array_conacabados["fs_ingresosGrupoFamiliar_campo"],0,",",".").'</td>
				  </tr>
				  <tr>
					<td>Subsidio aproximado</td>
					<td bgcolor="#d7e5fb" style="text-align:right;">$ '.number_format($array_sinacabados["subsidioaproximado"],0,",",".").'</td>
					<td bgcolor="#fdf3d6" style="text-align:right;">$ '.number_format($array_conacabados["subsidioaproximado"],0,",",".").'</td>
				  </tr>
				  <tr>
					<td>Ahorros</td>
					<td style="text-align:right;">$ '.number_format($array_sinacabados["ahorros"],0,",",".").'</td>
					<td style="text-align:right;">$ '.number_format($array_conacabados["ahorros"],0,",",".").'</td>
				  </tr>
				  <tr>
					<td>Cesantías</td>
					<td bgcolor="#d7e5fb" style="text-align:right;">$ '.number_format($array_sinacabados["cesantias"],0,",",".").'</td>
					<td bgcolor="#fdf3d6" style="text-align:right;">$ '.number_format($array_conacabados["cesantias"],0,",",".").'</td>
				  </tr>
				  <tr>
					<td>Saldo en cuota inicial</td>
					<td style="text-align:right;">$ '.number_format($array_sinacabados["saldodecuotainicial"],0,",",".").'</td>
					<td style="text-align:right;">$ '.number_format($array_conacabados["saldodecuotainicial"],0,",",".").'</td>
				  </tr>
				  <tr>
					<td> '.$array_sinacabados["numerocuotasmensuales"].'  &nbsp; Cuotas mensuales </td>
					<td bgcolor="#d7e5fb" style="text-align:right;">$ '.number_format($array_sinacabados["cuotasmensuales"],0,",",".").' </td>
					<td bgcolor="#fdf3d6" style="text-align:right;">$ '.number_format($array_conacabados["cuotasmensuales"],0,",",".").' </td>
				  </tr>
			</table>
			<table border="0" cellspacing="0" cellpadding="2" bordercolor="#555" style="margin:5px 0px 0px 0px;">
				 <tr>
					<td align="center" bgcolor="#011f5a" colspan="5" style="color:#FFF;"> Información Crédito hipotecario </td>
				  </tr>
				  <tr>
					<td width="240"> Plazo (Aprox)</td>
					<td width="123" bgcolor="#4674C1" style="color:#FFF; text-align:right;">Cuota UVR </td>
					<td width="123" bgcolor="#4674C1" style="color:#FFF; text-align:right;">Cuota Pesos</td>
					<td width="122" bgcolor="#ffc92f" style="color:#FFF; text-align:right;">Cuota UVR </td>
					<td width="122" bgcolor="#ffc92f" style="color:#FFF; text-align:right;">Cuota Pesos</td>
				  </tr>
				  <tr>
					<td>10 años</td>
					<td bgcolor="#d7e5fb" style="text-align:right;">$ '.number_format($array_sinacabados["cuotauvr_10"],0,",",".").'</td>
					<td bgcolor="#d7e5fb" style="text-align:right;">$ '.number_format($array_sinacabados["cuotapesos_10"],0,",",".").'</td>
					<td bgcolor="#fdf3d6" style="text-align:right;">$ '.number_format($array_conacabados["cuotauvr_10"],0,",",".").'</td>
					<td bgcolor="#fdf3d6" style="text-align:right;">$ '.number_format($array_conacabados["cuotapesos_10"],0,",",".").'</td>
				  </tr>
				  <tr>
					<td>15 años</td>
					<td style="text-align:right;">$ '.number_format($array_sinacabados["cuotauvr_15"],0,",",".").'</td>
					<td style="text-align:right;">$ '.number_format($array_sinacabados["cuotapesos_15"],0,",",".").'</td>
          <td style="text-align:right;">$ '.number_format($array_conacabados["cuotauvr_15"],0,",",".").'</td>
					<td style="text-align:right;">$ '.number_format($array_conacabados["cuotapesos_15"],0,",",".").'</td>
				  </tr>
				  <tr>
					<td>20 años</td>
					<td bgcolor="#d7e5fb" style="text-align:right;">$ '.number_format($array_sinacabados["cuotauvr_20"],0,",",".").'</td>
					<td bgcolor="#d7e5fb" style="text-align:right;">$ '.number_format($array_sinacabados["cuotapesos_20"],0,",",".").'</td>
					<td bgcolor="#fdf3d6" style="text-align:right;">$ '.number_format($array_conacabados["cuotauvr_20"],0,",",".").'</td>
					<td bgcolor="#fdf3d6" style="text-align:right;">$ '.number_format($array_conacabados["cuotapesos_20"],0,",",".").'</td>
				  </tr>
			</table>
		</div>

		<div class="adicionales">
			<table border="0" cellspacing="0" cellpadding="2" bordercolor="#555" style="margin:5px 0px;">
			  <tr>
				<th width="250px;" scope="col">Fecha de entrega: (aprox)</th>
				<th width="250px;" scope="col">Gastos de escrituración:(aprox)</th>
				<th width="250px;" scope="col">Valor administración (aprox)</th>
			  </tr>
			  <tr>
				<td>   '.$array_formulario["trimestre_entrega"].'  </td>
				<td>$ '.number_format($array_formulario["vr_gastos_escrituracion"],0,",",".").'</td>
				<td>$ '.number_format($array_formulario["vr_administracion"],0,",",".").'</td>
			  </tr>
			</table>
		</div>
		<div class="documentos">
			<strong>Documentos:</strong>
			<p>
			 '.$obj_info_text->texto_doc_requeridos.'
			</p>
		</div>

		<div class="terminos">

  			'.$obj_info_text->texto_legales.'
		</div>

		<div class="final">
			<table border="0" cellspacing="0" cellpadding="2" bordercolor="#555" style="margin:5px 0px;">
			  <tr>
				<th width="220px;" scope="col">Asesor</th>
				<th width="220px;" scope="col">Télefono del proyecto</th>
				<th width="220px;" scope="col">Email de proyecto</th>
			  </tr>
			  <tr>
				<td>'.$asesorvirtual.'</td>
				<td>'.$array_formulario["proyecto_vivienda_telefono"].'</td>
				<td>'.$array_formulario["proyecto_vivienda_email"].'</td>
			  </tr>
			</table>
		</div>

	</body>
</html>
';


    //ob_start();
    //include dirname(__FILE__).'/res/bookmark.php';
    //$content = ob_get_clean();

require __DIR__.'/vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;

$html2pdf = new Html2Pdf();
$html2pdf->writeHTML($_pagina_coti);
$html2pdf->output();


?>
