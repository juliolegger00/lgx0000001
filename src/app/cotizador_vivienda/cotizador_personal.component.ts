
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


    registerForm: FormGroup;
    submitted = false;
    recaptcha2_valido=false;

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

    constructor(
        private http: HttpClient,
        private spinnerService: Ng4LoadingSpinnerService,
        private formBuilder: FormBuilder,
        private router: Router
    ) {
        this.initializeFormulario();
    } //fin constructor

    ngOnInit() {
        this.initializeData();
    } //fin metodo ngOnInit

    public initializeFormulario() {

        this.registerForm = new FormGroup({
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
        this.addElementToObservableArray_tipo_documento_lista({"id":CONFIG.lang_seleccione ,"tipo_documento":CONFIG.lang_seleccione});
        this.http.get(CONFIG.api_lista_tipo_documento).pipe(delay(0)).subscribe(data => {

            let data_lst: any = {};
            data_lst = data;

            data_lst.forEach((item, index) => {
                  let item_t: any = {"id":item.id_tipo_documento ,"tipo_documento":item.title.rendered};
                this.addElementToObservableArray_tipo_documento_lista(item_t);
            });

        });

        this.spinnerService.show();
        this.http.get(CONFIG.api_lista_proyectos_vivienda).pipe(delay(0)).subscribe(data => {
            this.proyecto_vivienda_lista = data;
            this.proyecto_vivienda_seleccionado = data[0];
            this.getListaCiudades();
            this.spinnerService.hide();
        });

    } // fin metodo initializeData



    // convenience getter for easy access to form fields
    //I also added a getter 'f' as a convenience property to make it
    // easier to access form controls from the template. So for example
    //you can access the email field in the template using f.email
    //instead of registerForm.controls.email.
    get f() {
        return this.registerForm.controls;
    }


    get fs(){

      let fs_formulario = {
              "fs_ciudad_filtro": this.f.fs_ciudad_filtro.value,
              "fs_proyecto_filtro": this.f.fs_proyecto_filtro.value,
              "fs_proyectosTamano_filtro": this.f.fs_proyectosTamano_filtro.value,
              "fs_como_se_entero_filtro": this.f.fs_como_se_entero_filtro.value,
              "fs_tipo_documento_campo": this.f.fs_tipo_documento_campo.value,
              "fs_nombres_campo": this.f.fs_nombres_campo.value,
              "fs_numeroDocumento_campo": this.f.fs_numeroDocumento_campo.value,
              "fs_email_campo": this.f.fs_email_campo.value,
              "fs_afiliadoColsubsidio_campo": this.f.fs_afiliadoColsubsidio_campo.value,
              "fs_celular_campo": this.f.fs_celular_campo.value,
              "fs_abeasdata_campo": this.f.fs_abeasdata_campo.value,
      };

      return fs_formulario;



    }

    handleSuccess_recaptcha2(event){
      //console.log(event);
      this.recaptcha2_valido=true;
    }


    onSubmit() {

        localStorage.removeItem("cotizador_personal");
        this.submitted = true;

        // stop here if form is invalid
        if (this.registerForm.invalid) {
            return;
        }

        if(!this.recaptcha2_valido){
          this.submitted = false;
          return;
        }

        //alert('SUCCESS!! :-)')

        localStorage.setItem("cotizador_personal",JSON.stringify(this.fs));
        this.router.navigate(["formapagopersonal"]);

    } //fin onSubmit


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
