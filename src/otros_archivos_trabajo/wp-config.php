<?php
/** 
 * Configuración básica de WordPress.
 *
 * Este archivo contiene las siguientes configuraciones: ajustes de MySQL, prefijo de tablas,
 * claves secretas, idioma de WordPress y ABSPATH. Para obtener más información,
 * visita la página del Codex{@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} . Los ajustes de MySQL te los proporcionará tu proveedor de alojamiento web.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** Ajustes de MySQL. Solicita estos datos a tu proveedor de alojamiento web. ** //
/** El nombre de tu base de datos de WordPress */
define('DB_NAME', 'leggerne_vivienda');


/** Tu nombre de usuario de MySQL */
define('DB_USER', 'leggerne_user');


/** Tu contraseña de MySQL */
define('DB_PASSWORD', 'R1.9Ae01n5');


/** Host de MySQL (es muy probable que no necesites cambiarlo) */
define('DB_HOST', 'localhost');


/** Codificación de caracteres para la base de datos. */
define('DB_CHARSET', 'utf8mb4');


/** Cotejamiento de la base de datos. No lo modifiques si tienes dudas. */
define('DB_COLLATE', '');

/**#@+
 * Claves únicas de autentificación.
 *
 * Define cada clave secreta con una frase aleatoria distinta.
 * Puedes generarlas usando el {@link https://api.wordpress.org/secret-key/1.1/salt/ servicio de claves secretas de WordPress}
 * Puedes cambiar las claves en cualquier momento para invalidar todas las cookies existentes. Esto forzará a todos los usuarios a volver a hacer login.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', '!2V`GNjyc4xOMpEMR_$j}PlnXW)pJdH2p7WfH5|.RNLfcvl%+w( ,K)hlsYA=^&e');

define('SECURE_AUTH_KEY', '[)k@`7h$iy2:t7-$.m5p85!-`4?J_+YD,SV$J@*u8K05VYv|z7Mpy$j/f{QfA]pL');

define('LOGGED_IN_KEY', '<:jxGS5r^ZYe;;H#VL.b~Eqkn]O5xk{0n[Ucuzh@jN97 XNMQW]2Rio1/M;$q+0+');

define('NONCE_KEY', '&VSr+LcG%L|/MT1&+3*sifr[xezxHf@7lvu0<Qj~wyQ|fh{N)FnNiHw4#{sJIV+d');

define('AUTH_SALT', 'vV3R#]w-Ed;^,Upc4Dx+>,SEzi+X}(FV{)&AMMPe&?Spa_YBP_dN>*h=GC#QmGJs');

define('SECURE_AUTH_SALT', '$1Oe*!w5i|HZnV{C=$6BC;K&MvShv,0V DWgxfB#7iwBI$;Q;i$0--Nk:@ab*ErV');

define('LOGGED_IN_SALT', 'V=p[5l5II,.;+>A_c 4_x%P.bNS&u]W0}6&%i_m5I>X/XT1~  mql1gges~g61 K');

define('NONCE_SALT', 'G)K-AU2xPP}!9/;H<V;e*:e0W{Y[8$1AXjvk-$[`k9>era,Tf2UPfhyM>.ko&Q79');

define('JWT_AUTH_SECRET_KEY', '12.3dsfg');

define('JWT_AUTH_CORS_ENABLE', true);

/**#@-*/

/**
 * Prefijo de la base de datos de WordPress.
 *
 * Cambia el prefijo si deseas instalar multiples blogs en una sola base de datos.
 * Emplea solo números, letras y guión bajo.
 */
$table_prefix  = 'wp_';



/**
 * Para desarrolladores: modo debug de WordPress.
 *
 * Cambia esto a true para activar la muestra de avisos durante el desarrollo.
 * Se recomienda encarecidamente a los desarrolladores de temas y plugins que usen WP_DEBUG
 * en sus entornos de desarrollo.
 */
define('WP_DEBUG', false);

/* ¡Eso es todo, deja de editar! Feliz blogging */

/** WordPress absolute path to the Wordpress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');




