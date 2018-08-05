import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import {Routes, RouterModule} from "@angular/router";

import { FormsModule } from '@angular/forms';

import { HttpClientModule } from '@angular/common/http';
import { HttpClientXsrfModule } from '@angular/common/http'

import { Ng4LoadingSpinnerModule } from 'ng4-loading-spinner';

import { AppComponent } from './app.component';
import {Cotizador_personalComponent} from "./cotizador_vivienda/cotizador_personal.component";
import {Cotizador_formapagoComponent} from "./cotizador_vivienda/cotizador_formapago.component";

import { ReactiveFormsModule } from '@angular/forms';


import { NgxCaptchaModule } from 'ngx-captcha';

//servicios





const appRoutes: Routes = [
    {path:'', component: Cotizador_personalComponent},
    {path:'formapagopersonal', component: Cotizador_formapagoComponent}
];

@NgModule({
  declarations: [
    AppComponent,
    Cotizador_personalComponent,
    Cotizador_formapagoComponent
  ],
  imports: [
    BrowserModule,
    FormsModule,
    ReactiveFormsModule,
    RouterModule.forRoot(appRoutes) ,
    Ng4LoadingSpinnerModule.forRoot() ,
    // import HttpClientModule after BrowserModule.
    HttpClientModule,
    NgxCaptchaModule.forRoot({
      reCaptcha2SiteKey: '6Ld981EUAAAAAAoQaJIh9o88bOFC0WrHx6zEAw7g', // optional, can be overridden with 'siteKey' component property
      invisibleCaptchaSiteKey: 'yyy' // optional, can be overridden with 'siteKey' component property
    }),
    HttpClientXsrfModule.withOptions({
      cookieName: 'My-Xsrf-Cookie',
      headerName: 'My-Xsrf-Header',  }),
  ],
  providers: [ ],
  bootstrap: [AppComponent]
})
export class AppModule { }
