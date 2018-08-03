
import {Component,   HostListener } from '@angular/core';
import {OnInit } from "@angular/core";
import {CONFIG } from "../config/config";
import {HttpClient,   HttpParams } from '@angular/common/http';
import {delay } from 'rxjs/internal/operators/delay';

import { Ng4LoadingSpinnerService } from 'ng4-loading-spinner';
import { Observable, BehaviorSubject, of } from 'rxjs';
import { take } from 'rxjs/operators';


import { FormBuilder, FormGroup, Validators } from '@angular/forms';

@Component({
    selector: 'app-cotizador_personal',
    templateUrl: './cotizador_personal.component.html'
})

export class Cotizador_personalComponent implements OnInit {


    registerForm: FormGroup;
    submitted = false;

    texto_cotizacion_persona: any = {};
    proyecto_vivienda_lista: any = {};
    proyecto_vivienda_seleccionado: any = {};
    ciudad_seleccionada:any ;
    ciudades_lista_obsArray: BehaviorSubject<any[]> = new BehaviorSubject<any[]>([]);
    ciudades_lista$: Observable<any> =  this.ciudades_lista_obsArray.asObservable();


    addElementToObservableArray_ciudades_lista(item) {
      this.ciudades_lista$.pipe(take(1)).subscribe(val => {
        const newArr = [...val, item];
        this.ciudades_lista_obsArray.next(newArr);
      })
    }

    constructor(
        private http: HttpClient,
        private spinnerService: Ng4LoadingSpinnerService,
        private formBuilder: FormBuilder
    ) {}

    ngOnInit() {
      this.initializeFormulario();
      this.initializeData();
    } //fin metodo ngOnInit

    public initializeFormulario(){

      this.registerForm = this.formBuilder.group({
            nombres: ['', Validators.required]
        });
    }

    // convenience getter for easy access to form fields
    //I also added a getter 'f' as a convenience property to make it
    // easier to access form controls from the template. So for example
    //you can access the email field in the template using f.email
    //instead of registerForm.controls.email.
        get f() { return this.registerForm.controls; }

        onSubmit() {
            this.submitted = true;

            // stop here if form is invalid
            if (this.registerForm.invalid) {
                return;
            }

            alert('enviar submit...!! :-)')
        }



    public initializeData() {

        this.spinnerService.show();
        this.http.get(CONFIG.api_texto_cotizacion_persona).pipe(delay(0)).subscribe(data => {
            this.texto_cotizacion_persona = data;
        });

        this.http.get(CONFIG.api_lista_proyectos_vivienda).pipe(delay(0)).subscribe(data => {
            this.proyecto_vivienda_lista = data;
            this.proyecto_vivienda_seleccionado = data[0];
            this.getListaCiudades();
            this.spinnerService.hide();
        });

    } // fin metodo initializeData


    public getListaCiudades() {

        var temp_ciudades_lista = [];
        var i = 0;

        for (i = 0; i < this.proyecto_vivienda_lista.length; i++) {
            if (temp_ciudades_lista.indexOf(this.proyecto_vivienda_lista[i].ubicacion) === -1) {
                temp_ciudades_lista.push(this.proyecto_vivienda_lista[i].ubicacion);
            }
        }

        this.addElementToObservableArray_ciudades_lista("Selecciona");
        for (i = 0; i < temp_ciudades_lista.length; i++) {
             this.addElementToObservableArray_ciudades_lista(temp_ciudades_lista[i]);
        }



    } // fin metodo getListaCiudades


    public onSeleccion_ciudades_lista(){
      console.log(this.ciudad_seleccionada);
    }


}
