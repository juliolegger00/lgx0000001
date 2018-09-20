export class CONFIG {

    public static modo_http="http://";//https
    public static dominio_http="192.168.102.10"; //"leggercolombia.com"; //"192.168.102.10"; //"192.168.102.10";//"leggercolombia.com"; //
    public static api_wp_json =    CONFIG.modo_http+CONFIG.dominio_http+"/wordpress/wp-json/wp/v2/" ;
    public static api_jwt_auth =   CONFIG.modo_http+CONFIG.dominio_http+"/wordpress/wp-json/jwt-auth/v1/token" ;
    public static api_jwt_validate =   CONFIG.modo_http+CONFIG.dominio_http+"/wordpress/wp-json/jwt-auth/v1/token/validate";
    public static api_wp_legger=   CONFIG.modo_http+CONFIG.dominio_http+"/wordpress/wp-json/legger/v1/";
    public static api_info_texto_vivienda= CONFIG.api_wp_json+"info_texto_vivienda/";
    public static api_texto_cotizacion_persona=CONFIG.api_info_texto_vivienda+"113";
    public static api_lista_proyectos_vivienda= CONFIG.api_wp_json+"proyectos_vivienda/";
    public static api_lista_como_se_entero= CONFIG.api_wp_json+"datocomo_entero/";
    public static api_lista_tipo_documento= CONFIG.api_wp_json+"tipo_documento/";
    public static api_lista_media= CONFIG.api_wp_json+"media/";
    public static api_add_cotizacion_persona= CONFIG.api_wp_legger+"add_cotizacion_persona/1/";

    public static url_usuario_final="http://localhost:4200/";

    public static ss_token="ss_token";
    public static ss_token_val="ss_token_val";

    public static lang_seleccione="Selecciona";
    public static listo_dato=0;

}
