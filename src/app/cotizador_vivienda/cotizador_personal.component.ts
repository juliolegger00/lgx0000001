
import {Component,   HostListener } from '@angular/core';
import {OnInit } from "@angular/core";
import {CONFIG } from "../config/config";
import {ViewChild, ElementRef } from  "@angular/core";
import {HttpClient,   HttpParams, HttpHeaders } from '@angular/common/http';
import {delay } from 'rxjs/internal/operators/delay';

import { Ng4LoadingSpinnerService } from 'ng4-loading-spinner';
import { Observable, BehaviorSubject, of } from 'rxjs';
import { take  } from 'rxjs/operators';


import { FormBuilder, FormGroup, Validators, FormControl } from '@angular/forms';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';

import * as jspDF from 'jspdf';



import html2canvas from 'html2canvas';

import { registerLocaleData } from '@angular/common';
import es from '@angular/common/locales/es';

/*
import {
  AccessibilityConfig, Action, AdvancedLayout, ButtonEvent, ButtonsConfig, ButtonsStrategy, ButtonType, Description, DescriptionStrategy, GalleryService,
  DotsConfig, GridLayout, Image, ImageModalEvent, LineLayout, PlainGalleryConfig, PlainGalleryStrategy, PreviewConfig
} from 'angular-modal-gallery';
*/

@Component({
    selector: 'app-cotizador_personal',
    templateUrl: './cotizador_personal.component.html'

})


export class Cotizador_personalComponent implements OnInit {


    direccion_usuario_final=CONFIG.url_usuario_final;

    id_proyecto_via_get = 0;
    id_proyecto_via_validar = false;

    regFormPaso1: FormGroup;
    regFormPaso2: FormGroup;
    submitted1 = false;
    submitted2 = false;
    recaptcha2_valido = false;
    hidden_paso1 = false;
    hidden_paso2 = true;
    hidden_paso3 = true;

    mostrar_info_proyecto = false;

    texto_cotizacion_persona: any = {};
    proyecto_vivienda_lista: any = {};
    proyecto_vivienda_seleccionado: any = {};

    fs_ciudades_lista_obsArray: BehaviorSubject < any[] > = new BehaviorSubject < any[] > ([]);
    fs_ciudades_lista$: Observable < any > = this.fs_ciudades_lista_obsArray.asObservable();

    fs_proyectos_lista_obsArray: BehaviorSubject < any[] > = new BehaviorSubject < any[] > ([]);
    fs_proyectos_lista$: Observable < any > = this.fs_proyectos_lista_obsArray.asObservable();

    fs_proyectosTamano_lista_obsArray: BehaviorSubject < any[] > = new BehaviorSubject < any[] > ([]);
    fs_proyectosTamano_lista$: Observable < any > = this.fs_proyectosTamano_lista_obsArray.asObservable();

    fs_como_se_entero_lista_obsArray: BehaviorSubject < any[] > = new BehaviorSubject < any[] > ([]);
    fs_como_se_entero_lista$: Observable < any > = this.fs_como_se_entero_lista_obsArray.asObservable();

    fs_tipo_documento_lista_obsArray: BehaviorSubject < any[] > = new BehaviorSubject < any[] > ([]);
    fs_tipo_documento_lista$: Observable < any > = this.fs_tipo_documento_lista_obsArray.asObservable();
    data_lst_tipo_documento: any = {};

    fs_galeria_imagenes_lista_obsArray: BehaviorSubject < any[] > = new BehaviorSubject < any[] > ([]);
    fs_galeria_iamgenes_lista$: Observable < any > = this.fs_galeria_imagenes_lista_obsArray.asObservable();


    //images_obsArray: BehaviorSubject < Image[] > =  new BehaviorSubject < Image[] > ([]);
    //images$: Observable < any > = this.images_obsArray.asObservable();

    images_obsArray: BehaviorSubject < any[] > = new BehaviorSubject < any[] > ([]);
    images$: Observable < any > = this.images_obsArray.asObservable();
    i_pos_gal_ima = 0;

    fs_ingresosGrupoFamiliar_value: any=0;
    fs_ahorros_value: any=0;
    fs_cesantias_value: any=0;

    tokenValido = false;
    tokenNameUser: string = "";

    idListaCiudadesPre = 0;
    idtipo_documentoPre = 0;

    ListaCiudades_validar = false;
    ListaProyectos_validar = false;
    ListaproyectosTamano_validar = false;
    ListaCiudades_via_get = "";
    ListaProyectos_via_get = "";
    ListaproyectosTamano_via_get = "";

    Cuotainicial_asesor = 30;
    Cuotasmensuales_asesor = 11;
    Subsidio_asesor = true;
    imagen_principal = "";

    afiliadoColsubsidio_valido=true;

    fs_celular_campo_minlength=false;
    fs_celular_campo_maxlength=false;

    fs_numeroDocumento_campo_minlength=false;
    fs_numeroDocumento_campo_maxlength=false;

    fs_ingresosGrupoFamiliar_campo_min=false;
    fs_ahorros_campo_min=false;
    fs_cesantias_campo_min=false;

    proyecto_image_pdf="";

    pdfIdGenerado="";


    pdfSrc="";
    //var CONDICIONES DE VENTA


    condiciones_venta = {
        sinacabados: {
            valordelinmueble: 0,
            cuotainicial: 0,
            separacion: 0,
            subsidioaproximado: 0,
            ingresosgrupofamiliar: 0,
            ahorros: 0,
            cesantias: 0,
            saldodecuotainicial: 0,
            numerocuotasmensuales: 0,
            cuotasmensuales: 0,
            creditorequerido: 0,
            cuotauvr_10: 0,
            cuotauvr_15: 0,
            cuotauvr_20: 0,
            cuotapesos_10: 0,
            cuotapesos_15: 0,
            cuotapesos_20: 0,
        },
        conacabados: {
            valordelinmueble: 0,
            cuotainicial: 0,
            separacion: 0,
            subsidioaproximado: 0,
            ingresosgrupofamiliar: 0,
            ahorros: 0,
            cesantias: 0,
            saldodecuotainicial: 0,
            numerocuotasmensuales: 0,
            cuotasmensuales: 0,
            creditorequerido: 0,
            cuotauvr_10: 0,
            cuotauvr_15: 0,
            cuotauvr_20: 0,
            cuotapesos_10: 0,
            cuotapesos_15: 0,
            cuotapesos_20: 0,
        },
    };

    tabla_uvr = {
        ANOS_20: 0,
        ANOS_15: 0,
        ANOS_10: 0,
        ANOS_5: 0,
    };

    tabla_tasainteres=0;


    texto_legales_sb="";

    estilopopup="none";
    var_abrir_popup=false;

    //var CONDICIONES DE VENTA


    constructor(
        private http: HttpClient,
        private spinnerService: Ng4LoadingSpinnerService,
        private formBuilder: FormBuilder,
        private router: Router,
        //private galleryService: GalleryService,
        private routeActive: ActivatedRoute
    ) {

        if (this.router.url == "/cotizador") this.acciones_si_esta_logeeado();

        this.id_proyecto_via_get = this.routeActive.snapshot.params['id'];

        if (this.id_proyecto_via_get != null) {
            this.id_proyecto_via_validar = true;
        }

        //console.log( "proyecto_sele:" this.id_proyecto_via_get);



        this.initializeFormularioPaso1();
        this.initializeFormularioPaso2(); // paso2

    } //fin constructor

    ngOnInit() {
        registerLocaleData(es);
        this.initializeData();

    } //fin metodo ngOnInit

    public initializeFormularioPaso1() {

        this.regFormPaso1 = new FormGroup({
            fs_ciudad_filtro: new FormControl('', []),
            fs_proyecto_filtro: new FormControl('', []),
            fs_proyectosTamano_filtro: new FormControl('', []),
            fs_como_se_entero_filtro: new FormControl('', Validators.required),
            fs_tipo_documento_campo: new FormControl('', []),
            fs_nombres_campo: new FormControl('', Validators.required),
            fs_numeroDocumento_campo: new FormControl('', [Validators.required, Validators.minLength(1), Validators.maxLength(12)]),
            fs_email_campo: new FormControl('', [Validators.required,
                Validators.pattern("[^ @]*@[^ @]*")
            ]),
            fs_afiliadoColsubsidio_campo: new FormControl('', Validators.required),
            fs_celular_campo:  new FormControl('', Validators.compose( [Validators.required ] ) ),
            fs_abeasdata_campo: new FormControl('', Validators.requiredTrue),
        });




    } // fin initializeFormulario


    public initializeFormularioPaso2() {

        this.regFormPaso2 = new FormGroup({
            fs_ingresosGrupoFamiliar_campo: new FormControl('', [Validators.required ]),
            fs_ahorros_campo: new FormControl('', [Validators.required ]),
            fs_cesantias_campo: new FormControl('', [Validators.required]),

        });
    } // fin initializeFormulario



    public cerrar_final() {
      this.estilopopup="none";
    }

    public abrir_popup() {
      this.estilopopup="block";
      this.var_abrir_popup=true;
      console.log("asdf");
    }

    /*plainGalleryRow: PlainGalleryConfig = {
    strategy: PlainGalleryStrategy.ROW,
    layout: new LineLayout({ width: '80px', height: '80px' }, { length: 0, wrap: true }, 'flex-start')
  };*/

    openModalViaService(id: number | undefined, index: number) {
        //console.log('opening gallery with index ' + index);
        //this.galleryService.openGallery(id, index);
    }


    public acciones_si_esta_logeeado() {
        //console.log("acciones_si_esta_logeeado");

        let var_token = sessionStorage.getItem(CONFIG.ss_token_val);
        if (var_token == "ok") {
            this.tokenValido = true;
            let var_token_t = JSON.parse(sessionStorage.getItem(CONFIG.ss_token));
            this.tokenNameUser = var_token_t.user_display_name;
        } else {
            this.tokenValido = false;
            this.tokenNameUser = "";
        }

    }

    public cerrar_session() {
        sessionStorage.removeItem(CONFIG.ss_token);
        sessionStorage.setItem(CONFIG.ss_token_val, "-");
        let uri = '/';
        window.location.href = uri;
    }




    get fs() {

        let nombre_tipo_documento: string = "";
        this.data_lst_tipo_documento.forEach((item, index) => {
            if (this.f.fs_tipo_documento_campo.value.indexOf(item.id_tipo_documento) > -1) {
                nombre_tipo_documento = item.title.rendered;
            }
        });

        if (this.ListaCiudades_via_get == "")
            this.ListaCiudades_via_get = this.f.fs_ciudad_filtro.value;

        if (this.ListaProyectos_via_get == "")
            this.ListaProyectos_via_get = this.f.fs_proyecto_filtro.value;

        if (this.ListaproyectosTamano_via_get == "")
            this.ListaproyectosTamano_via_get = this.f.fs_proyectosTamano_filtro.value;

        let fs_formulario = {
            fs_ciudad_filtro: this.ListaCiudades_via_get,
            fs_proyecto_filtro: this.ListaProyectos_via_get,
            fs_proyectosTamano_filtro: this.ListaproyectosTamano_via_get,
            fs_como_se_entero_filtro: this.f.fs_como_se_entero_filtro.value,
            fs_tipo_documento_campo: this.f.fs_tipo_documento_campo.value,
            fs_nombre_documento_campo: nombre_tipo_documento,
            fs_numeroDocumento_campo: this.f.fs_numeroDocumento_campo.value,
            fs_nombres_campo: this.f.fs_nombres_campo.value,
            fs_email_campo: this.f.fs_email_campo.value,
            fs_afiliadoColsubsidio_campo: this.f.fs_afiliadoColsubsidio_campo.value,
            fs_celular_campo: this.f.fs_celular_campo.value,
            fs_abeasdata_campo: this.f.fs_abeasdata_campo.value,
            proyecto_vivienda_seleccionado: this.proyecto_vivienda_seleccionado.proyecto,
            proyecto_vivienda_seleccionado_inventarioproyecto: this.proyecto_vivienda_seleccionado.InventarioProyecto,
            proyecto_vivienda_seleccionado_valorproyecto: this.proyecto_vivienda_seleccionado.valorProyecto,
            proyecto_vivienda_seleccionado_imagen: this.proyecto_image_pdf,
            proyecto_vivienda_seleccionado_areaconstruida: this.proyecto_vivienda_seleccionado.area_construida,
            proyecto_vivienda_seleccionado_areaprivada: this.proyecto_vivienda_seleccionado.areaPrivadaproyecto,
            proyecto_vivienda_cuotainicial_porcentaje: this.Cuotainicial_asesor,
            //"texto_cotizacion_persona": this.texto_cotizacion_persona,
            fs_ingresosGrupoFamiliar_campo: this.fs_ingresosGrupoFamiliar_value,
            fs_ahorros_campo: this.fs_ahorros_value,
            fs_cesantias_campo: this.fs_cesantias_value,
            fecha_escrituras_probable: this.proyecto_vivienda_seleccionado.fecha_escrituras_probable,
            trimestre_entrega: this.proyecto_vivienda_seleccionado.trimestre_entrega,
            vr_gastos_escrituracion: this.proyecto_vivienda_seleccionado.vr_gastos_escrituracion,
            vr_administracion: this.proyecto_vivienda_seleccionado.vr_administracion,
            proyecto_vivienda_telefono: this.proyecto_vivienda_seleccionado.telefono,
            proyecto_vivienda_email: this.proyecto_vivienda_seleccionado.descripcion,
            asesorvirtual:this.texto_cotizacion_persona.asesorvirtual,
        };

        return fs_formulario;
    }


    public  onSeleccion_afiliadoColsubsidio(){
      if( this.f.fs_afiliadoColsubsidio_campo.value== "si"){
        this.afiliadoColsubsidio_valido=true;
        this.proyecto_vivienda_seleccionado.valorProyecto=  parseInt(this.proyecto_vivienda_seleccionado.precio_sin_acabados); 
      }else{
        this.afiliadoColsubsidio_valido=false;
        this.proyecto_vivienda_seleccionado.valorProyecto=  parseInt(this.proyecto_vivienda_seleccionado.precio_no_afiliado_sin_acabados);
      }
    }

    public initializeData() {

        this.spinnerService.show();
        this.http.get(CONFIG.api_texto_cotizacion_persona).pipe(delay(0)).subscribe(data => {

            let data_tmp: any = {};
            data_tmp = data;
            this.texto_cotizacion_persona = data_tmp;
            this.tabla_uvr.ANOS_5= this.texto_cotizacion_persona.uvr_anos_5;
            this.tabla_uvr.ANOS_10= this.texto_cotizacion_persona.uvr_anos_10;
            this.tabla_uvr.ANOS_15= this.texto_cotizacion_persona.uvr_anos_15;
            this.tabla_uvr.ANOS_20= this.texto_cotizacion_persona.uvr_anos_20;
            this.tabla_tasainteres=parseInt(this.texto_cotizacion_persona.tasainteres);
            this.texto_legales_sb= this.texto_cotizacion_persona.texto_legales;//.replace(/\\/g, "");
            //console.log(this.texto_legales_sb);
        });

        this.spinnerService.show();
        //this.addElementToObservableArray_como_se_entero_lista(CONFIG.lang_seleccione);
        this.http.get(CONFIG.api_lista_como_se_entero).pipe(delay(0)).subscribe(data => {

            let data_lst: any = {};
            data_lst = data;

            data_lst.forEach((item, index) => {
                this.addElementToObservableArray_como_se_entero_lista(item.title.rendered);
            });

        });


        this.spinnerService.show();

        this.addElementToObservableArray_tipo_documento_lista({
            "id": CONFIG.lang_seleccione,
            "tipo_documento": CONFIG.lang_seleccione
        });

        this.http.get(CONFIG.api_lista_tipo_documento).pipe(delay(0)).subscribe(data => {

            this.data_lst_tipo_documento = data;

            this.data_lst_tipo_documento.forEach((item, index) => {
                let item_t: any = {
                    "id": item.id_tipo_documento,
                    "tipo_documento": item.title.rendered
                };
                this.addElementToObservableArray_tipo_documento_lista(item_t);
                if (item_t.id.indexOf("CC") > -1) {
                    this.idtipo_documentoPre = index + 1;
                    this.f.fs_tipo_documento_campo.setValue(item_t.id);
                }
            });

        });



        this.spinnerService.show();
        this.http.get(CONFIG.api_lista_proyectos_vivienda).pipe(delay(0)).subscribe(data => {
            this.proyecto_vivienda_lista = data;
            this.proyecto_vivienda_seleccionado = data[0];

            if (this.id_proyecto_via_get != null) {
                this.proyecto_vivienda_lista.forEach((item, index) => {

                    if (item.id == this.id_proyecto_via_get) {
                        this.proyecto_vivienda_seleccionado = item;
                        this.addElementToObservableArray_proyectos_lista(this.proyecto_vivienda_seleccionado.proyecto);
                        this.addElementToObservableArray_proyectosTamano_lista(this.proyecto_vivienda_seleccionado.area_construida);
                        this.ListaProyectos_via_get = this.proyecto_vivienda_seleccionado.proyecto;
                        this.ListaproyectosTamano_via_get = this.proyecto_vivienda_seleccionado.area_construida;
                    }
                });
            }


            ///cargar galeria_imagenes
            if (this.proyecto_vivienda_seleccionado.id > 0) {
                this.removeRoomAll_galeria_imagenes_lista();
                this.removeRoomAll_imagenes_lista();


                let galeria_ima: any = [
                    this.proyecto_vivienda_seleccionado.galeria_1,
                    this.proyecto_vivienda_seleccionado.galeria_2,
                    this.proyecto_vivienda_seleccionado.galeria_3,
                    this.proyecto_vivienda_seleccionado.galeria_4,
                    this.proyecto_vivienda_seleccionado.galeria_5
                ]


                for (var _i = 0; _i < galeria_ima.length; _i++) {
                    let item = galeria_ima[_i];

                    this.http.get(CONFIG.api_lista_media + item + "/").pipe(delay(0)).subscribe(data00 => {


                        let data_lst00: any = {};
                        data_lst00 = data00;

                        if (data_lst00.alt_text == "principal") {
                            this.imagen_principal = data_lst00.guid.rendered;
                            this.proyecto_image_pdf = data_lst00.guid.rendered;
                        }
                        let data_imagen: any = {
                            "id": data_lst00.id,
                            "dir_imagen": data_lst00.guid.rendered,
                            "leyenda": data_lst00.caption.rendered,
                            "alt_text": data_lst00.alt_text,
                        };



                        let data_imagen2: any = {}
                        /* new Image(
                                this.i_pos_gal_ima,
                                { // modal
                                  img:  data_lst00.guid.rendered,
                                  extUrl: data_lst00.guid.rendered,
                                }
                              );*/
                        this.i_pos_gal_ima++;

                        this.addElementToObservableArray_galeria_imagenes_lista(data_imagen);
                        this.addElementToObservableArray_imagenes(data_imagen2);


                    });
                    // buscar info media
                } // for lista de images


            }
            ///cargar galeria_imagenes

            this.getListaCiudades();
            this.spinnerService.hide();
        });

    } // fin metodo initializeData



    // convenience getter for easy access to form fields
    //I also added a getter 'f' as a convenience property to make it
    // easier to access form controls from the template. So for example
    //you can access the email field in the template using f.email
    //instead of regFormPaso1.controls.email.
    get f() {
        return this.regFormPaso1.controls;
    }

    get f2() {
        return this.regFormPaso2.controls;
    }


    handleSuccess_recaptcha2(event) {
        //console.log(event);
        this.recaptcha2_valido = true;
    }



    regresarPaso1(event:any) {
        this.submitted1 = false;
        this.hidden_paso1 = false;
        this.hidden_paso2 = true;
        this.hidden_paso3 = true;
        return;
    }

    onSubmit_paso3() {}

    onkeyValidarCelular(evt:any){
        this.submitted1 = true;
        let fs_celular_campo_t=this.f.fs_celular_campo.value
        let fs_celular_campo_length=0

        if(fs_celular_campo_t!=null){
           fs_celular_campo_length=fs_celular_campo_t.toString().length
        }

        if(fs_celular_campo_length<10){
          this.fs_celular_campo_minlength=true;
        }else{
            this.fs_celular_campo_minlength=false;
        }

        if(fs_celular_campo_length>10){
          this.fs_celular_campo_maxlength=true;
        }else{
            this.fs_celular_campo_maxlength=false;
        }


        return ;
    }


        onkeyValidarNumeroDocumento(evt:any){
            this.submitted1 = true;
            let fs_numeroDocumento_campo_t=this.f.fs_numeroDocumento_campo.value
            let fs_numeroDocumento_campo_length=0

            if(fs_numeroDocumento_campo_t!=null){
               fs_numeroDocumento_campo_length=fs_numeroDocumento_campo_t.toString().length
            }

            if(fs_numeroDocumento_campo_length<5){
              this.fs_numeroDocumento_campo_minlength=true;
            }else{
                this.fs_numeroDocumento_campo_minlength=false;
            }

            if(fs_numeroDocumento_campo_length>10){
              this.fs_numeroDocumento_campo_maxlength=true;
            }else{
                this.fs_numeroDocumento_campo_maxlength=false;
            }


            return ;
        }




    onSubmit_paso1() {

        this.submitted1 = true;
        let fs_celular_campo_t=this.f.fs_celular_campo.value
        let fs_celular_campo_length=0

        if(fs_celular_campo_t!=null){
           fs_celular_campo_length=fs_celular_campo_t.toString().length
        }


        if(fs_celular_campo_length<10){
          this.fs_celular_campo_minlength=true;
          return;
        }else{
            this.fs_celular_campo_minlength=false;
        }

        if(fs_celular_campo_length>10){
          this.fs_celular_campo_maxlength=true;
          return;
        }else{
            this.fs_celular_campo_maxlength=false;
        }




        let fs_numeroDocumento_campo_t=this.f.fs_numeroDocumento_campo.value
        let fs_numeroDocumento_campo_length=0

        if(fs_numeroDocumento_campo_t!=null){
           fs_numeroDocumento_campo_length=fs_numeroDocumento_campo_t.toString().length
        }

        if(fs_numeroDocumento_campo_length<5){
          this.fs_numeroDocumento_campo_minlength=true;
          return;
        }else{
            this.fs_numeroDocumento_campo_minlength=false;
        }

        if(fs_numeroDocumento_campo_length>10){
          this.fs_numeroDocumento_campo_maxlength=true;
          return;
        }else{
            this.fs_numeroDocumento_campo_maxlength=false;
        }







        if (this.id_proyecto_via_get == null) {
            let validar_filtros = false;

            if (this.f.fs_ciudad_filtro.value.length <= 0) {
                this.ListaCiudades_validar = true;
                validar_filtros = true;
            } else this.ListaCiudades_validar = false;

            if (this.f.fs_proyecto_filtro.value.length <= 0) {
                this.ListaProyectos_validar = true;
                validar_filtros = true;
            } else this.ListaProyectos_validar = false;

            if (this.f.fs_proyectosTamano_filtro.value.length <= 0) {
                this.ListaproyectosTamano_validar = true;
                validar_filtros = true;
            } else this.ListaproyectosTamano_validar = false;

            if (validar_filtros) return;

        } else {
            this.ListaCiudades_validar = false;
            this.ListaProyectos_validar = false;
            this.ListaproyectosTamano_validar = false;
        }

        // stop here if form is invalid
        if (this.regFormPaso1.invalid) {
            this.hidden_paso1 = false;
            this.hidden_paso2 = true;
            this.hidden_paso3 = true;
            return;
        }

        if(!this.tokenValido){
            if(!this.recaptcha2_valido){
              this.hidden_paso1 = false;
              return;
            }
        }


        this.hidden_paso1 = true;
        this.hidden_paso2 = false;
        this.hidden_paso3 = true;
        return;

        //alert('SUCCESS!! :-)')
        //localStorage.removeItem("cotizador_personal");
        //localStorage.setItem("cotizador_personal",JSON.stringify(this.fs));
        //this.router.navigate(["formapagopersonal"]);
        //learla
        //this.cotizador_personal = localStorage.getItem("cotizador_personal");

    } //fin onSubmit



    onkeyValidaringresosGrupoFamiliar(evt:any){
      this.submitted2 = true;

      if(this.fs_ingresosGrupoFamiliar_value!=null){
          if(this.fs_ingresosGrupoFamiliar_value<0){
            this.fs_ingresosGrupoFamiliar_campo_min=true;

          }else{
            this.fs_ingresosGrupoFamiliar_campo_min=false;
          }
      }else{
        this.fs_ingresosGrupoFamiliar_campo_min=true;

      }
        return;
    }
    onkeyValidarahorros(evt:any){
        this.submitted2 = true;
        if(this.fs_ahorros_value!=null){
            if(this.fs_ahorros_value<0){
              this.fs_ahorros_campo_min=true;

            }else{
              this.fs_ahorros_campo_min=false;
            }
        }else{
          this.fs_ahorros_campo_min=true;

        }
          return;
    }
    onkeyValidarcesantias(evt:any){
        this.submitted2 = true;

                 if(this.fs_cesantias_value!=null){
                     if(this.fs_cesantias_value<0){
                       this.fs_cesantias_campo_min=true;

                     }else{
                       this.fs_cesantias_campo_min=false;
                     }
                 }else{
                   this.fs_cesantias_campo_min=true;

                 }
                 return;

    }

    onSubmit_paso2() {

        this.submitted2 = true;


        if(this.fs_ingresosGrupoFamiliar_value!=null){
            if(this.fs_ingresosGrupoFamiliar_value<0){
              this.fs_ingresosGrupoFamiliar_campo_min=true;
              return;
            }else{
              this.fs_ingresosGrupoFamiliar_campo_min=false;
            }
        }else{
          this.fs_ingresosGrupoFamiliar_campo_min=true;
          return;
        }

         if(this.fs_ahorros_value!=null){
             if(this.fs_ahorros_value<0){
               this.fs_ahorros_campo_min=true;
               return;
             }else{
               this.fs_ahorros_campo_min=false;
             }
         }else{
           this.fs_ahorros_campo_min=true;
           return;
         }


         if(this.fs_cesantias_value!=null){
             if(this.fs_cesantias_value<0){
               this.fs_cesantias_campo_min=true;
               return;
             }else{
               this.fs_cesantias_campo_min=false;
             }
         }else{
           this.fs_cesantias_campo_min=true;
           return;
         }




        // stop here if form is invalid
        if (this.regFormPaso2.invalid) {
            this.hidden_paso1 = true;
            this.hidden_paso2 = false;
            this.hidden_paso3 = true;
            return;
        }


        this.crear_calculos_paso3_sinacabados();
        this.crear_calculos_paso3_conacabados();


        ////////test add///
        let ev: any;

          this.hidden_paso1 = true;
          this.hidden_paso2 = true;
          this.hidden_paso3 = false;

          if(!this.tokenValido){
            this.guardar_paso_3(ev);

            setTimeout(() => {
            //    this.downloadPDF() ;
            //this.estilopopup="block"
          }, 3000);
          }else{

          }

        ////////test add///

        window.scrollTo(0, 0);

        return;
    }

    guardar_paso_3(ev: any) {
      ////////test add///

      this.spinnerService.show();

      let info_session_usuario = JSON.parse(sessionStorage.getItem(CONFIG.ss_token));

      let guardar_cotizacion = {
          formulario: this.fs,
          condiciones_venta: this.condiciones_venta,
          "info_session_usuario": info_session_usuario,
      }

      this.spinnerService.show();
      let json = JSON.stringify(guardar_cotizacion);
      let params = "json=" + json;
      let headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');

      this.http.post(CONFIG.api_add_cotizacion_persona, params, {
          headers: headers
      }).pipe(delay(0)).subscribe(data => {

          let data_lst: any = {};
          data_lst = data;
          this.pdfIdGenerado=data_lst;
          console.log(this.pdfIdGenerado);

          this.spinnerService.hide();

          if(this.tokenValido){
              //this.downloadPDF();
              this.estilopopup="block"
          }

      });


      ////////test add///
    }

    onChangeCuotasmensuales(event: any) {
        //console.log(event.target.value)
        if (event.target.value.length > 0) this.Cuotasmensuales_asesor = event.target.value;

        this.crear_calculos_paso3_sinacabados();
        this.crear_calculos_paso3_conacabados();


    }
    onChangeCoutaInicial(event: any) {
        //console.log(event.target.value)
        if (event.target.value.length > 0) this.Cuotainicial_asesor = event.target.value;

        this.crear_calculos_paso3_sinacabados();
        this.crear_calculos_paso3_conacabados();

    }

    onChangeSubsidio_asesor(event: any) {

        //console.log(event.target.checked)
        this.Subsidio_asesor = event.target.checked;

        this.crear_calculos_paso3_sinacabados();
        this.crear_calculos_paso3_conacabados();


    }


        onSubimit_nuevaCotizacion(event: any) {
          if(this.tokenValido){
            window.location.reload();
           }
          else{
             window.location.reload();}
        }


    onSubmit_regresarpaso2() {
        this.hidden_paso1 = true;
        this.hidden_paso2 = false;
        this.hidden_paso3 = true;
    }



    public crear_calculos_paso3_conacabados() {

      let tmpValorInmueble=0;
      if( this.f.fs_afiliadoColsubsidio_campo.value== "si"){
        tmpValorInmueble= parseInt(this.proyecto_vivienda_seleccionado.precio_con_acabados);
      }else{
        tmpValorInmueble= parseInt(this.proyecto_vivienda_seleccionado.precio_no_afiliado_con_acabados);
      }

       if(tmpValorInmueble>0){

         debugger
        this.condiciones_venta.conacabados.numerocuotasmensuales = this.Cuotasmensuales_asesor;
        this.condiciones_venta.conacabados.ingresosgrupofamiliar = this.fs_ingresosGrupoFamiliar_value;
        this.condiciones_venta.conacabados.ahorros = this.fs_ahorros_value;
        this.condiciones_venta.conacabados.cesantias = this.fs_cesantias_value;
        this.condiciones_venta.conacabados.valordelinmueble = tmpValorInmueble;
        this.condiciones_venta.conacabados.separacion = parseInt(this.proyecto_vivienda_seleccionado.vr_separacion);
        this.condiciones_venta.conacabados.cuotainicial = (this.condiciones_venta.conacabados.valordelinmueble * this.Cuotainicial_asesor / 100);


        let subsidioaproximado = (this.condiciones_venta.conacabados.ingresosgrupofamiliar <= 1562484 ? 23437260 :
            (this.condiciones_venta.conacabados.ingresosgrupofamiliar <= 3124968 ? 15624840 :
                (this.condiciones_venta.conacabados.ingresosgrupofamiliar > 3124968 ? 0 : 0)));

        if (!this.Subsidio_asesor) subsidioaproximado = 0;

        this.condiciones_venta.conacabados.subsidioaproximado = subsidioaproximado;

        let saldodecuotainicial = (this.condiciones_venta.conacabados.separacion +
            this.condiciones_venta.conacabados.subsidioaproximado +
            this.condiciones_venta.conacabados.ahorros +
            this.condiciones_venta.conacabados.cesantias > this.condiciones_venta.conacabados.cuotainicial ? 0 :
            this.condiciones_venta.conacabados.cuotainicial -
            this.condiciones_venta.conacabados.separacion -
            this.condiciones_venta.conacabados.subsidioaproximado -
            this.condiciones_venta.conacabados.ahorros -
            this.condiciones_venta.conacabados.cesantias);
        this.condiciones_venta.conacabados.saldodecuotainicial = saldodecuotainicial;

        if (this.condiciones_venta.conacabados.numerocuotasmensuales > 0) {
            this.condiciones_venta.conacabados.cuotasmensuales =
                this.condiciones_venta.conacabados.saldodecuotainicial /
                this.condiciones_venta.conacabados.numerocuotasmensuales;
        } else {
            this.condiciones_venta.conacabados.cuotasmensuales = 0;
        }

        let creditorequerido = (this.condiciones_venta.conacabados.separacion +
            this.condiciones_venta.conacabados.ingresosgrupofamiliar +
            this.condiciones_venta.conacabados.subsidioaproximado +
            this.condiciones_venta.conacabados.ahorros +
            this.condiciones_venta.conacabados.cesantias > this.condiciones_venta.conacabados.cuotainicial ?
            this.condiciones_venta.conacabados.valordelinmueble -
            this.condiciones_venta.conacabados.separacion -
            this.condiciones_venta.conacabados.ingresosgrupofamiliar -
            this.condiciones_venta.conacabados.subsidioaproximado -
            this.condiciones_venta.conacabados.ahorros -
            this.condiciones_venta.conacabados.cesantias :
            this.condiciones_venta.conacabados.valordelinmueble -
            this.condiciones_venta.conacabados.cuotainicial);
        this.condiciones_venta.conacabados.creditorequerido = creditorequerido;

        this.condiciones_venta.conacabados.cuotauvr_10 =
            (this.tabla_uvr.ANOS_10 * this.condiciones_venta.conacabados.creditorequerido / 1000000) + 27000;
        this.condiciones_venta.conacabados.cuotauvr_15 =
            (this.tabla_uvr.ANOS_15 * this.condiciones_venta.conacabados.creditorequerido / 1000000) + 27000;
        this.condiciones_venta.conacabados.cuotauvr_20 =
            (this.tabla_uvr.ANOS_20 * this.condiciones_venta.conacabados.creditorequerido / 1000000) + 27000;


        //cuotapesos_10

        let fv = 0;
        let pv = -1 * (this.condiciones_venta.conacabados.creditorequerido);
        let rate = (this.tabla_tasainteres/100);//0.011;
        let nper = 12 * 10; //años
        let type = 1;

        let PMT = (-fv - pv * Math.pow(1 + rate, nper)) / (1 + rate * type) / ((Math.pow(1 + rate, nper) - 1) / rate);
        let cuotapesos_10 = PMT; //+ 100000;

        this.condiciones_venta.conacabados.cuotapesos_10 = cuotapesos_10;

        //cuotapesos_10

        //cuotapesos_15

        fv = 0;
        pv = -1 * (this.condiciones_venta.conacabados.creditorequerido);
        rate = (this.tabla_tasainteres/100);//0.011;
        nper = 12 * 15; //años
        type = 1;

        PMT = (-fv - pv * Math.pow(1 + rate, nper)) / (1 + rate * type) / ((Math.pow(1 + rate, nper) - 1) / rate);
        let cuotapesos_15 = PMT; // + 100000;

        this.condiciones_venta.conacabados.cuotapesos_15 = cuotapesos_15;

        //cuotapesos_15

        //cuotapesos_20

        fv = 0;
        pv = -1 * (this.condiciones_venta.conacabados.creditorequerido);
        rate = (this.tabla_tasainteres/100);//0.011;
        nper = 12 * 20; //años
        type = 1;

        PMT = (-fv - pv * Math.pow(1 + rate, nper)) / (1 + rate * type) / ((Math.pow(1 + rate, nper) - 1) / rate);
        let cuotapesos_20 = PMT; //+ 100000;

        this.condiciones_venta.conacabados.cuotapesos_20 = cuotapesos_20;

        //cuotapesos_20

      }//tmpValorInmueble>0
    }




    public crear_calculos_paso3_sinacabados() {


      let tmpValorInmueble=0;
      if( this.f.fs_afiliadoColsubsidio_campo.value== "si"){
        tmpValorInmueble= parseInt(this.proyecto_vivienda_seleccionado.precio_sin_acabados);
      }else{
        tmpValorInmueble= parseInt(this.proyecto_vivienda_seleccionado.precio_no_afiliado_sin_acabados);
      }

      if(tmpValorInmueble>0){

        debugger
        this.condiciones_venta.sinacabados.numerocuotasmensuales = this.Cuotasmensuales_asesor;
        this.condiciones_venta.sinacabados.ingresosgrupofamiliar = this.fs_ingresosGrupoFamiliar_value;
        this.condiciones_venta.sinacabados.ahorros = this.fs_ahorros_value;
        this.condiciones_venta.sinacabados.cesantias = this.fs_cesantias_value;
        this.condiciones_venta.sinacabados.valordelinmueble = tmpValorInmueble;
        this.condiciones_venta.sinacabados.separacion = parseInt(this.proyecto_vivienda_seleccionado.vr_separacion);
        this.condiciones_venta.sinacabados.cuotainicial = (this.condiciones_venta.sinacabados.valordelinmueble * this.Cuotainicial_asesor / 100);

        let subsidioaproximado = (this.condiciones_venta.sinacabados.ingresosgrupofamiliar <= 1562484 ? 23437260 :
            (this.condiciones_venta.sinacabados.ingresosgrupofamiliar <= 3124968 ? 15624840 :
                (this.condiciones_venta.sinacabados.ingresosgrupofamiliar > 3124968 ? 0 : 0)));

        if (!this.Subsidio_asesor) subsidioaproximado = 0;

        this.condiciones_venta.sinacabados.subsidioaproximado = subsidioaproximado;

        let saldodecuotainicial = (this.condiciones_venta.sinacabados.separacion +
            this.condiciones_venta.sinacabados.subsidioaproximado +
            this.condiciones_venta.sinacabados.ahorros +
            this.condiciones_venta.sinacabados.cesantias > this.condiciones_venta.sinacabados.cuotainicial ? 0 :
            this.condiciones_venta.sinacabados.cuotainicial -
            this.condiciones_venta.sinacabados.separacion -
            this.condiciones_venta.sinacabados.subsidioaproximado -
            this.condiciones_venta.sinacabados.ahorros -
            this.condiciones_venta.sinacabados.cesantias);
        this.condiciones_venta.sinacabados.saldodecuotainicial = saldodecuotainicial;

        if (this.condiciones_venta.sinacabados.numerocuotasmensuales > 0) {
            this.condiciones_venta.sinacabados.cuotasmensuales =
                this.condiciones_venta.sinacabados.saldodecuotainicial /
                this.condiciones_venta.sinacabados.numerocuotasmensuales;
        } else {
            this.condiciones_venta.sinacabados.cuotasmensuales = 0;
        }

        let creditorequerido = (this.condiciones_venta.sinacabados.separacion +
            this.condiciones_venta.sinacabados.ingresosgrupofamiliar +
            this.condiciones_venta.sinacabados.subsidioaproximado +
            this.condiciones_venta.sinacabados.ahorros +
            this.condiciones_venta.sinacabados.cesantias > this.condiciones_venta.sinacabados.cuotainicial ?
            this.condiciones_venta.sinacabados.valordelinmueble -
            this.condiciones_venta.sinacabados.separacion -
            this.condiciones_venta.sinacabados.ingresosgrupofamiliar -
            this.condiciones_venta.sinacabados.subsidioaproximado -
            this.condiciones_venta.sinacabados.ahorros -
            this.condiciones_venta.sinacabados.cesantias :
            this.condiciones_venta.sinacabados.valordelinmueble -
            this.condiciones_venta.sinacabados.cuotainicial);
        this.condiciones_venta.sinacabados.creditorequerido = creditorequerido;

        this.condiciones_venta.sinacabados.cuotauvr_10 =
            (this.tabla_uvr.ANOS_10 * this.condiciones_venta.sinacabados.creditorequerido / 1000000) + 27000;
        this.condiciones_venta.sinacabados.cuotauvr_15 =
            (this.tabla_uvr.ANOS_15 * this.condiciones_venta.sinacabados.creditorequerido / 1000000) + 27000;
        this.condiciones_venta.sinacabados.cuotauvr_20 =
            (this.tabla_uvr.ANOS_20 * this.condiciones_venta.sinacabados.creditorequerido / 1000000) + 27000;


        //cuotapesos_10

        let fv = 0;
        let pv = -1 * (this.condiciones_venta.sinacabados.creditorequerido);
        let rate = (this.tabla_tasainteres/100);//0.011;
        let nper = 12 * 10; //años
        let type = 1;

        let PMT = (-fv - pv * Math.pow(1 + rate, nper)) / (1 + rate * type) / ((Math.pow(1 + rate, nper) - 1) / rate);
        let cuotapesos_10 = PMT; //+ 100000;

        this.condiciones_venta.sinacabados.cuotapesos_10 = cuotapesos_10;

        //cuotapesos_10

        //cuotapesos_15

        fv = 0;
        pv = -1 * (this.condiciones_venta.sinacabados.creditorequerido);
        rate = (this.tabla_tasainteres/100);//0.011;
        nper = 12 * 15; //años
        type = 1;

        PMT = (-fv - pv * Math.pow(1 + rate, nper)) / (1 + rate * type) / ((Math.pow(1 + rate, nper) - 1) / rate);
        let cuotapesos_15 = PMT; // + 100000;

        this.condiciones_venta.sinacabados.cuotapesos_15 = cuotapesos_15;

        //cuotapesos_15

        //cuotapesos_20

        fv = 0;
        pv = -1 * (this.condiciones_venta.sinacabados.creditorequerido);
        rate = (this.tabla_tasainteres/100);//0.011;
        nper = 12 * 20; //años
        type = 1;

        PMT = (-fv - pv * Math.pow(1 + rate, nper)) / (1 + rate * type) / ((Math.pow(1 + rate, nper) - 1) / rate);
        let cuotapesos_20 = PMT; //+ 100000;

        this.condiciones_venta.sinacabados.cuotapesos_20 = cuotapesos_20;

        //cuotapesos_20


      }//tmpValorInmueble>0

    }

    onSeleccion_tipo_documento_lista() {}
    onSeleccion_como_se_entero_lista() {}

    public onSeleccion_ciudades_lista() {
        //console.log(this.f.fs_ciudad_filtro.value);
        this.spinnerService.show();
        this.removeRoomAll_proyectosTamano_lista();
        this.removeRoomAll_proyectos_lista();
        //this.addElementToObservableArray_proyectos_lista(CONFIG.lang_seleccione);

        this.getListaProyectos();
        this.spinnerService.hide();

        if (this.f.fs_ciudad_filtro.value.length <= 0) {
            this.ListaCiudades_validar = true;
        } else {
            this.ListaCiudades_validar = false;
        }


        this.ListaProyectos_validar = false;
        this.ListaproyectosTamano_validar = false;
        this.ListaCiudades_via_get = "";
        this.ListaProyectos_via_get = "";
        this.ListaproyectosTamano_via_get = "";
        this.id_proyecto_via_get = null;


    }

    public onSeleccion_proyectos_lista() {
        this.spinnerService.show();
        this.removeRoomAll_proyectosTamano_lista();
        this.addElementToObservableArray_proyectosTamano_lista(CONFIG.lang_seleccione);
        this.getListaproyectosTamano();
        this.spinnerService.hide();

        if (this.f.fs_proyecto_filtro.value.length <= 0) {
            this.ListaProyectos_validar = true;
        } else this.ListaProyectos_validar = false;

    }

    public onSeleccion_proyectosTamano_lista() {

        this.spinnerService.show();
        let i = 0;

        for (i = 0; i < this.proyecto_vivienda_lista.length; i++) {

            if (
                (this.f.fs_ciudad_filtro.value.indexOf(this.proyecto_vivienda_lista[i].ubicacion) > -1) &&
                (this.f.fs_proyecto_filtro.value.indexOf(this.proyecto_vivienda_lista[i].proyecto) > -1) &&
                (this.f.fs_proyectosTamano_filtro.value.indexOf(this.proyecto_vivienda_lista[i].area_construida) > -1)
            ) {
                this.cargarProyectoSeleccionado(this.proyecto_vivienda_lista[i]);
            }//proyecto seleeionado
        }

        this.spinnerService.hide();



        if (this.f.fs_proyectosTamano_filtro.value.length <= 0) {
            this.ListaproyectosTamano_validar = true;
        } else this.ListaproyectosTamano_validar = false;




    } //onSeleccion_proyectosTamano_lista



    public cargarProyectoSeleccionado(_param_proyectoseleccionado:any){

      this.proyecto_vivienda_seleccionado = _param_proyectoseleccionado;
      this.Cuotasmensuales_asesor=this.proyecto_vivienda_seleccionado.plazo_cuota_inicial;//cambio para cuotas

      ///cargar galeria_imagenes
      if (this.proyecto_vivienda_seleccionado.id > 0) {
          this.removeRoomAll_galeria_imagenes_lista();
          this.removeRoomAll_imagenes_lista();

          let galeria_ima: any = [
              this.proyecto_vivienda_seleccionado.galeria_1,
              this.proyecto_vivienda_seleccionado.galeria_2,
              this.proyecto_vivienda_seleccionado.galeria_3,
              this.proyecto_vivienda_seleccionado.galeria_4,
              this.proyecto_vivienda_seleccionado.galeria_5
          ]


          for (var _i = 0; _i < galeria_ima.length; _i++) {
              let item = galeria_ima[_i];

              this.http.get(CONFIG.api_lista_media + item + "/").pipe(delay(0)).subscribe(data00 => {


                  let data_lst00: any = {};
                  data_lst00 = data00;

                  let data_imagen: any = {
                      "id": data_lst00.id,
                      "dir_imagen": data_lst00.guid.rendered,
                      "leyenda": data_lst00.caption.rendered,
                      "alt_text": data_lst00.alt_text,
                  };

                  let data_imagen2: any = {}
                  /*new Image(
                                                     this.i_pos_gal_ima,
                                                     { // modal
                                                       img:  data_lst00.guid.rendered,
                                                       extUrl: data_lst00.guid.rendered,
                                                     }
                                                   );*/
                  this.i_pos_gal_ima++;

                  this.addElementToObservableArray_galeria_imagenes_lista(data_imagen);
                  this.addElementToObservableArray_imagenes(data_imagen2);

                  this.mostrar_info_proyecto=true;

              });
              // buscar info media
          } // for lista de images


      }
      ///cargar galeria_imagenes

    }//cargarProyectoSeleccionado

    public getListaproyectosTamano() {

        let temp_proyectosTamano_lista0 = [];
        let temp_proyectosTamano_lista1 = [];
        let i = 0;
        let i0 = 0;

        let tamaSeleccion="";

        for (i = 0; i < this.proyecto_vivienda_lista.length; i++) {

            if (
                (this.f.fs_ciudad_filtro.value.indexOf(this.proyecto_vivienda_lista[i].ubicacion) > -1) &&
                (this.f.fs_proyecto_filtro.value.indexOf(this.proyecto_vivienda_lista[i].proyecto) > -1)
            ) {

                if(i0==0){//primer tamaña
                  this.cargarProyectoSeleccionado(this.proyecto_vivienda_lista[i]);
                  tamaSeleccion=this.proyecto_vivienda_lista[i].area_construida;
                }

                temp_proyectosTamano_lista0.push(this.proyecto_vivienda_lista[i].area_construida);
                i0++;
            }
        }

        for (i = 0; i < i0; i++) {
            if (temp_proyectosTamano_lista1.indexOf(temp_proyectosTamano_lista0[i]) === -1) {
                temp_proyectosTamano_lista1.push(temp_proyectosTamano_lista0[i]);
            }
        }

        //this.addElementToObservableArray_proyectosTamano_lista("Selecciona");
        for (i = 0; i < temp_proyectosTamano_lista1.length; i++) {
          this.addElementToObservableArray_proyectosTamano_lista(temp_proyectosTamano_lista1[i]);
        }



        //seleecionar primer addElementToObservableArray_imagenes
        this.f.fs_proyectosTamano_filtro.setValue(tamaSeleccion);








    } //getListaproyectosTamano

    public getListaCiudades() {

        let temp_ciudades_lista = [];
        let i = 0;

        for (i = 0; i < this.proyecto_vivienda_lista.length; i++) {
            if (temp_ciudades_lista.indexOf(this.proyecto_vivienda_lista[i].ubicacion) === -1) {
                temp_ciudades_lista.push(this.proyecto_vivienda_lista[i].ubicacion);
            }
        }

        //this.addElementToObservableArray_ciudades_lista("Selecciona");
        for (i = 0; i < temp_ciudades_lista.length; i++) {
            this.addElementToObservableArray_ciudades_lista(temp_ciudades_lista[i]);

            if (this.id_proyecto_via_get != null) {
                if (this.proyecto_vivienda_seleccionado.ubicacion == temp_ciudades_lista[i]) {
                    this.idListaCiudadesPre = i;
                    this.ListaCiudades_via_get = temp_ciudades_lista[i]
                }
            }

        }

    } // fin metodo getListaCiudades



    public getListaProyectos() {

        let temp_proyectos_lista0 = [];
        let temp_proyectos_lista1 = [];
        let i = 0;
        let i0 = 0;

        for (i = 0; i < this.proyecto_vivienda_lista.length; i++) {

            if (this.f.fs_ciudad_filtro.value.indexOf(this.proyecto_vivienda_lista[i].ubicacion) > -1) {
                temp_proyectos_lista0.push(this.proyecto_vivienda_lista[i].proyecto);
                i0++;
            }
        }

        for (i = 0; i < i0; i++) {
            if (temp_proyectos_lista1.indexOf(temp_proyectos_lista0[i]) === -1) {
                temp_proyectos_lista1.push(temp_proyectos_lista0[i]);
            }
        }

        //this.addElementToObservableArray_ciudades_lista("Selecciona");
        for (i = 0; i < temp_proyectos_lista1.length; i++) {
            this.addElementToObservableArray_proyectos_lista(temp_proyectos_lista1[i]);
        }

    } // fin metodo getListaCiudades


    public downloadPDF() {

      let v1= this.randomString(15, 16);

      window.open("http://192.168.102.10/vivienda_pdf/pdf.php?id=" +v1+this.pdfIdGenerado, '_blank');
    }


    //randomString(12, 16); // 12 hexadecimal characters
    //randomString(200); // 200 alphanumeric characters
    public randomString   (len, bits)
    {
        bits = bits || 36;
        var outStr = "", newStr;
        while (outStr.length < len)
        {
            newStr = Math.random().toString(bits).slice(2);
            outStr += newStr.slice(0, Math.min(newStr.length, (len - outStr.length)));
        }
        return outStr.toUpperCase();
    }


    public downloadPDFviejo() {

      this.spinnerService.show();
        var data = document.getElementById('contentok');
        html2canvas(data, {
            //  width: 595,
            //  height: 842,
            //scale:0.8
        }).then(canvas => {

            /*
              var a = document.createElement('a');
              a.href = canvas.toDataURL("image/png");
              a.download = 'myfile.png';
              a.click();
            */

            const contentDataURL = canvas.toDataURL('image/png')
            let pdf = new jspDF('p', 'mm', 'a4'); // A4 size page of PDF
            let position = 10;
            let width = 10;
            let height = 10;


            let porcentaje = 30;
            height = 270; // canvas.height * porcentaje / 100;
            width = 170; // canvas.width * porcentaje / 100;
            //console.log(height)


            pdf.addImage(contentDataURL, 'PNG', 20, position, width, height)
            pdf.save('cotizacion_vivienda_colsubsidio.pdf'); // Generated PDF
           //this.pdfSrc= pdf.output('datauristring');
           //window.open(string);

            /*var iframe = "<iframe width='100%' height='100%' src='" + string + "'></iframe>"

            var x = window.open();
            x.document.open();
            x.document.write(iframe);
            x.document.close();*/

            this.spinnerService.hide();


        });


    }




    //galeria_5
    addElementToObservableArray_imagenes(item) {
        this.images$.pipe(take(1)).subscribe(val => {
            const newArr = [...val, item];
            this.images_obsArray.next(newArr);

        })

    }

    removeRoomAll_imagenes_lista() {
        let roomArr: any[] = this.images_obsArray.getValue();
        roomArr.splice(0, roomArr.length);
        this.images_obsArray.next(roomArr);
        this.i_pos_gal_ima = 0;
    }
    //galeria_5

    //tipo_documento
    //tipo_documento
    addElementToObservableArray_galeria_imagenes_lista(item) {
        this.fs_galeria_iamgenes_lista$.pipe(take(1)).subscribe(val => {
            const newArr = [...val, item];
            this.fs_galeria_imagenes_lista_obsArray.next(newArr);

        })
    }

    removeRoomAll_galeria_imagenes_lista() {
        let roomArr: any[] = this.fs_galeria_imagenes_lista_obsArray.getValue();
        roomArr.splice(0, roomArr.length);
        this.fs_galeria_imagenes_lista_obsArray.next(roomArr);
    }
    //tipo_documento
    //tipo_documento

    //tipo_documento
    //tipo_documento
    addElementToObservableArray_tipo_documento_lista(item) {
        this.fs_tipo_documento_lista$.pipe(take(1)).subscribe(val => {
            const newArr = [...val, item];
            this.fs_tipo_documento_lista_obsArray.next(newArr);
        })
    }
    //tipo_documento
    //tipo_documento

    //como_se_entero
    //como_se_entero
    addElementToObservableArray_como_se_entero_lista(item) {
        this.fs_como_se_entero_lista$.pipe(take(1)).subscribe(val => {
            const newArr = [...val, item];
            newArr.sort();
            this.fs_como_se_entero_lista_obsArray.next(newArr);
        })
    }
    //como_se_entero
    //como_se_entero


    //ciudades
    //ciudades
    addElementToObservableArray_ciudades_lista(item) {
        this.fs_ciudades_lista$.pipe(take(1)).subscribe(val => {
            const newArr = [...val, item];
            this.fs_ciudades_lista_obsArray.next(newArr);
        })
    }
    //ciudades
    //ciudades

    //proyectosTamano
    //proyectosTamano
    addElementToObservableArray_proyectosTamano_lista(item) {
        this.fs_proyectosTamano_lista$.pipe(take(1)).subscribe(val => {
            const newArr = [...val, item];
            this.fs_proyectosTamano_lista_obsArray.next(newArr);
        })
    }

    removeRoomAll_proyectosTamano_lista() {
        let roomArr: any[] = this.fs_proyectosTamano_lista_obsArray.getValue();
        roomArr.splice(0, roomArr.length);
        this.fs_proyectosTamano_lista_obsArray.next(roomArr);
    }
    //proyectosTamano
    //proyectosTamano


    //proyectos
    //proyectos
    addElementToObservableArray_proyectos_lista(item) {
        this.fs_proyectos_lista$.pipe(take(1)).subscribe(val => {
            const newArr = [...val, item];
            newArr.sort();
            this.fs_proyectos_lista_obsArray.next(newArr);
        })
    }

    addElementToObservableArray_proyectos_lista2(item) {
        this.fs_proyectos_lista$.pipe(take(1)).subscribe(val => {
            const newArr = [...val, item];
            this.fs_proyectos_lista_obsArray.next(newArr);
        })
    }

    removeRoomAll_proyectos_lista() {
        let roomArr: any[] = this.fs_proyectos_lista_obsArray.getValue();
        roomArr.splice(0, roomArr.length);
        this.fs_proyectos_lista_obsArray.next(roomArr);
    }
    //proyectos
    //proyectos




    //ejemplo importante no borrar
    removeRoomArr(data: any) {
        let roomArr: any[] = this.fs_proyectos_lista_obsArray.getValue();
        roomArr.forEach((item, index) => {
            if (item === data) {
                roomArr.splice(index, 1);
            }
        });
        this.fs_proyectos_lista_obsArray.next(roomArr);
    }
    //ejemplo importante no borrar

}
