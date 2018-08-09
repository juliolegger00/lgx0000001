
import {Component,   HostListener } from '@angular/core';
import {OnInit } from "@angular/core";
import {CONFIG } from "../config/config";
import {HttpClient,   HttpParams } from '@angular/common/http';
import {delay } from 'rxjs/internal/operators/delay';

import { Ng4LoadingSpinnerService } from 'ng4-loading-spinner';
import { Observable, BehaviorSubject, of } from 'rxjs';
import { take  } from 'rxjs/operators';


import { FormBuilder, FormGroup, Validators, FormControl } from '@angular/forms';
import { Router } from '@angular/router';



@Component({
    selector: 'app-cotizador_personal',
    templateUrl: './cotizador_personal.component.html'

})

export class Cotizador_personalComponent implements OnInit {


    regFormPaso1: FormGroup;
    regFormPaso2: FormGroup;
    submitted = false;
    recaptcha2_valido = false;
    hidden_paso1 = false;
    hidden_paso2 = true;
    hidden_paso3 = true;

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
        ANOS_20: 7243,
        ANOS_15: 8518,
        ANOS_10: 11185,
        ANOS_5: 19437,
    };

    //var CONDICIONES DE VENTA


    constructor(
        private http: HttpClient,
        private spinnerService: Ng4LoadingSpinnerService,
        private formBuilder: FormBuilder,
        private router: Router,
    ) {
        this.initializeFormularioPaso1();
        this.initializeFormularioPaso2(); // paso2

    } //fin constructor

    ngOnInit() {
        this.initializeData();

    } //fin metodo ngOnInit

    public initializeFormularioPaso1() {

        this.regFormPaso1 = new FormGroup({
            fs_ciudad_filtro: new FormControl('', Validators.required),
            fs_proyecto_filtro: new FormControl('', Validators.required),
            fs_proyectosTamano_filtro: new FormControl('', Validators.required),
            fs_como_se_entero_filtro: new FormControl('', Validators.required),
            fs_tipo_documento_campo: new FormControl('', Validators.required),
            fs_nombres_campo: new FormControl('', Validators.required),
            fs_numeroDocumento_campo: new FormControl('', Validators.required),
            fs_email_campo: new FormControl('', Validators.required),
            fs_afiliadoColsubsidio_campo: new FormControl('', Validators.required),
            fs_celular_campo: new FormControl('', Validators.required),
            fs_abeasdata_campo: new FormControl('', Validators.required),
        });
    } // fin initializeFormulario

    public initializeFormularioPaso2() {

        this.regFormPaso2 = new FormGroup({
            fs_ingresosGrupoFamiliar_campo: new FormControl('', Validators.required),
            fs_ahorros_campo: new FormControl('', Validators.required),
            fs_cesantias_campo: new FormControl('', Validators.required),

        });
    } // fin initializeFormulario


    get fs() {

        let nombre_tipo_documento: string = "";
        this.data_lst_tipo_documento.forEach((item, index) => {
            if (this.f.fs_tipo_documento_campo.value.indexOf(item.id_tipo_documento) > -1) {
                nombre_tipo_documento = item.title.rendered;
            }
        });

        let fs_formulario = {
            "fs_ciudad_filtro": this.f.fs_ciudad_filtro.value,
            "fs_proyecto_filtro": this.f.fs_proyecto_filtro.value,
            "fs_proyectosTamano_filtro": this.f.fs_proyectosTamano_filtro.value,
            "fs_como_se_entero_filtro": this.f.fs_como_se_entero_filtro.value,
            "fs_tipo_documento_campo": this.f.fs_tipo_documento_campo.value,
            "fs_nombre_documento_campo": nombre_tipo_documento,
            "fs_numeroDocumento_campo": this.f.fs_numeroDocumento_campo.value,
            "fs_nombres_campo": this.f.fs_nombres_campo.value,
            "fs_email_campo": this.f.fs_email_campo.value,
            "fs_afiliadoColsubsidio_campo": this.f.fs_afiliadoColsubsidio_campo.value,
            "fs_celular_campo": this.f.fs_celular_campo.value,
            "fs_abeasdata_campo": this.f.fs_abeasdata_campo.value,
            "proyecto_vivienda_seleccionado": this.proyecto_vivienda_seleccionado,
            "texto_cotizacion_persona": this.texto_cotizacion_persona,
        };

        return fs_formulario;
    }

    public initializeData() {

        this.spinnerService.show();
        this.http.get(CONFIG.api_texto_cotizacion_persona).pipe(delay(0)).subscribe(data => {
            this.texto_cotizacion_persona = data;
        });

        this.spinnerService.show();
        this.addElementToObservableArray_como_se_entero_lista(CONFIG.lang_seleccione);
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
            });

        });

        this.spinnerService.show();
        this.http.get(CONFIG.api_lista_proyectos_vivienda).pipe(delay(0)).subscribe(data => {
            this.proyecto_vivienda_lista = data;
            this.proyecto_vivienda_seleccionado = data[0];

            ///cargar galeria_imagenes
            if (this.proyecto_vivienda_seleccionado.id > 0) {
                this.removeRoomAll_galeria_imagenes_lista();


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

                        this.addElementToObservableArray_galeria_imagenes_lista(data_imagen);


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



    regresarPaso1() {

        this.hidden_paso1 = false;
        this.hidden_paso2 = true;
        this.hidden_paso3 = true;
        return;
    }

    onSubmit_paso1() {

        // stop here if form is invalid
        if (this.regFormPaso1.invalid) {
            this.hidden_paso1 = false;
            this.hidden_paso2 = true;
            this.hidden_paso3 = true;
            return;
        }


        //if(!this.recaptcha2_valido){
        //  this.hidden_paso1 = false;
        //  return;
        //}


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


    onSubmit_paso2() {

        // stop here if form is invalid
        if (this.regFormPaso1.invalid) {
            this.hidden_paso1 = true;
            this.hidden_paso2 = false;
            this.hidden_paso3 = true;
            return;
        }


        this.crear_calculos_paso3_sinacabados();
        this.crear_calculos_paso3_conacabados();
        this.hidden_paso1 = true;
        this.hidden_paso2 = true;
        this.hidden_paso3 = false;
        return;
    }


    onSubmit_paso3() {

    }



    public crear_calculos_paso3_conacabados() {

        this.condiciones_venta.conacabados.numerocuotasmensuales=11;
        this.condiciones_venta.conacabados.ingresosgrupofamiliar = parseInt(this.f2.fs_ingresosGrupoFamiliar_campo.value);
        this.condiciones_venta.conacabados.ahorros = parseInt(this.f2.fs_ahorros_campo.value);
        this.condiciones_venta.conacabados.cesantias = parseInt(this.f2.fs_cesantias_campo.value);
        this.condiciones_venta.conacabados.valordelinmueble = parseInt(this.proyecto_vivienda_seleccionado.precio_con_acabados);
        this.condiciones_venta.conacabados.separacion = parseInt(this.proyecto_vivienda_seleccionado.vr_separacion);
        this.condiciones_venta.conacabados.cuotainicial = (this.condiciones_venta.conacabados.valordelinmueble * 30 / 100);

        debugger

        let subsidioaproximado = (this.condiciones_venta.conacabados.ingresosgrupofamiliar <= 1562484 ? 23437260 :
            (this.condiciones_venta.conacabados.ingresosgrupofamiliar <= 3124968 ? 15624840 :
                (this.condiciones_venta.conacabados.ingresosgrupofamiliar > 3124968 ? 0 : 0)));
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
        let rate = 0.011;
        let nper = 12 * 10; //años
        let type = 1;

        let PMT = (-fv - pv * Math.pow(1 + rate, nper)) / (1 + rate * type) / ((Math.pow(1 + rate, nper) - 1) / rate);
        let cuotapesos_10 = PMT ;//+ 100000;

        this.condiciones_venta.conacabados.cuotapesos_10 = cuotapesos_10;

        //cuotapesos_10

        //cuotapesos_15

        fv = 0;
        pv = -1 * (this.condiciones_venta.conacabados.creditorequerido);
        rate = 0.011;
        nper = 12 * 15; //años
        type = 1;

        PMT = (-fv - pv * Math.pow(1 + rate, nper)) / (1 + rate * type) / ((Math.pow(1 + rate, nper) - 1) / rate);
        let cuotapesos_15 = PMT ;// + 100000;

        this.condiciones_venta.conacabados.cuotapesos_15 = cuotapesos_15;

        //cuotapesos_15

        //cuotapesos_20

        fv = 0;
        pv = -1 * (this.condiciones_venta.conacabados.creditorequerido);
        rate = 0.011;
        nper = 12 * 20; //años
        type = 1;

        PMT = (-fv - pv * Math.pow(1 + rate, nper)) / (1 + rate * type) / ((Math.pow(1 + rate, nper) - 1) / rate);
        let cuotapesos_20 = PMT ;//+ 100000;

        this.condiciones_venta.conacabados.cuotapesos_20 = cuotapesos_20;

        //cuotapesos_20

    }




      public  crear_calculos_paso3_sinacabados() {

            this.condiciones_venta.sinacabados.numerocuotasmensuales=11;
            this.condiciones_venta.sinacabados.ingresosgrupofamiliar = parseInt(this.f2.fs_ingresosGrupoFamiliar_campo.value);
            this.condiciones_venta.sinacabados.ahorros = parseInt(this.f2.fs_ahorros_campo.value);
            this.condiciones_venta.sinacabados.cesantias = parseInt(this.f2.fs_cesantias_campo.value);
            this.condiciones_venta.sinacabados.valordelinmueble = parseInt(this.proyecto_vivienda_seleccionado.precio_sin_acabados);
            this.condiciones_venta.sinacabados.separacion = parseInt(this.proyecto_vivienda_seleccionado.vr_separacion);
            this.condiciones_venta.sinacabados.cuotainicial = (this.condiciones_venta.sinacabados.valordelinmueble * 30 / 100);

            let subsidioaproximado = (this.condiciones_venta.sinacabados.ingresosgrupofamiliar <= 1562484 ? 23437260 :
                (this.condiciones_venta.sinacabados.ingresosgrupofamiliar <= 3124968 ? 15624840 :
                    (this.condiciones_venta.sinacabados.ingresosgrupofamiliar > 3124968 ? 0 : 0)));
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
            let rate = 0.011;
            let nper = 12 * 10; //años
            let type = 1;

            let PMT = (-fv - pv * Math.pow(1 + rate, nper)) / (1 + rate * type) / ((Math.pow(1 + rate, nper) - 1) / rate);
            let cuotapesos_10 = PMT ;//+ 100000;

            this.condiciones_venta.sinacabados.cuotapesos_10 = cuotapesos_10;

            //cuotapesos_10

            //cuotapesos_15

            fv = 0;
            pv = -1 * (this.condiciones_venta.sinacabados.creditorequerido);
            rate = 0.011;
            nper = 12 * 15; //años
            type = 1;

            PMT = (-fv - pv * Math.pow(1 + rate, nper)) / (1 + rate * type) / ((Math.pow(1 + rate, nper) - 1) / rate);
            let cuotapesos_15 = PMT ;// + 100000;

            this.condiciones_venta.sinacabados.cuotapesos_15 = cuotapesos_15;

            //cuotapesos_15

            //cuotapesos_20

            fv = 0;
            pv = -1 * (this.condiciones_venta.sinacabados.creditorequerido);
            rate = 0.011;
            nper = 12 * 20; //años
            type = 1;

            PMT = (-fv - pv * Math.pow(1 + rate, nper)) / (1 + rate * type) / ((Math.pow(1 + rate, nper) - 1) / rate);
            let cuotapesos_20 = PMT ;//+ 100000;

            this.condiciones_venta.sinacabados.cuotapesos_20 = cuotapesos_20;

            //cuotapesos_20





        }

    onSeleccion_tipo_documento_lista() {}
    onSeleccion_como_se_entero_lista() {}

    public onSeleccion_ciudades_lista() {
        //console.log(this.f.fs_ciudad_filtro.value);
        this.spinnerService.show();
        this.removeRoomAll_proyectosTamano_lista();
        this.removeRoomAll_proyectos_lista();
        this.addElementToObservableArray_proyectos_lista(CONFIG.lang_seleccione);
        this.getListaProyectos();
        this.spinnerService.hide();
    }

    public onSeleccion_proyectos_lista() {
        this.spinnerService.show();
        this.removeRoomAll_proyectosTamano_lista();
        this.addElementToObservableArray_proyectosTamano_lista(CONFIG.lang_seleccione);
        this.getListaproyectosTamano();
        this.spinnerService.hide();


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
                this.proyecto_vivienda_seleccionado = this.proyecto_vivienda_lista[i];

                ///cargar galeria_imagenes
                if (this.proyecto_vivienda_seleccionado.id > 0) {
                    this.removeRoomAll_galeria_imagenes_lista();


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

                            this.addElementToObservableArray_galeria_imagenes_lista(data_imagen);


                        });
                        // buscar info media
                    } // for lista de images


                }
                ///cargar galeria_imagenes

            }
        }

        this.spinnerService.hide();
    } //onSeleccion_proyectosTamano_lista

    public getListaproyectosTamano() {

        let temp_proyectosTamano_lista0 = [];
        let temp_proyectosTamano_lista1 = [];
        let i = 0;
        let i0 = 0;

        for (i = 0; i < this.proyecto_vivienda_lista.length; i++) {

            if (
                (this.f.fs_ciudad_filtro.value.indexOf(this.proyecto_vivienda_lista[i].ubicacion) > -1) &&
                (this.f.fs_proyecto_filtro.value.indexOf(this.proyecto_vivienda_lista[i].proyecto) > -1)
            ) {
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
