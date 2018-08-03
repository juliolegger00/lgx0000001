import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import {Routes, RouterModule} from "@angular/router";

import { FormsModule } from '@angular/forms';

import { HttpClientModule } from '@angular/common/http';
import { HttpClientXsrfModule } from '@angular/common/http'

import { Ng4LoadingSpinnerModule } from 'ng4-loading-spinner';

import { AppComponent } from './app.component';
import {Cotizador_personalComponent} from "./cotizador_vivienda/cotizador_personal.component";

import { ReactiveFormsModule } from '@angular/forms';

//servicios





const appRoutes: Routes = [
  {path:'', component: Cotizador_personalComponent}
];

@NgModule({
  declarations: [
    AppComponent,
    Cotizador_personalComponent
  ],
  imports: [
    BrowserModule,
    FormsModule,
    ReactiveFormsModule,
    RouterModule.forRoot(appRoutes) ,
    Ng4LoadingSpinnerModule.forRoot() ,
    // import HttpClientModule after BrowserModule.
    HttpClientModule,
    HttpClientXsrfModule.withOptions({
      cookieName: 'My-Xsrf-Cookie',
      headerName: 'My-Xsrf-Header',  }),
  ],
  providers: [ ],
  bootstrap: [AppComponent]
})
export class AppModule { }
