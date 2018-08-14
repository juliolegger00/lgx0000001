import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import {Routes, RouterModule} from "@angular/router";

import { FormsModule } from '@angular/forms';

import { HttpClientModule } from '@angular/common/http';
import { HttpClientXsrfModule } from '@angular/common/http'

import { Ng4LoadingSpinnerModule } from 'ng4-loading-spinner';

import { AppComponent } from './app.component';
import {Cotizador_personalComponent} from "./cotizador_vivienda/cotizador_personal.component";
import {LoginComponent} from "./login/login.component";

import { ReactiveFormsModule } from '@angular/forms';

import { NgxCaptchaModule } from 'ngx-captcha';

import {NgbModule} from '@ng-bootstrap/ng-bootstrap';

import { NgxCurrencyModule } from "ngx-currency";

import 'hammerjs';
        import 'mousetrap';
        import {ModalGalleryModule} from 'angular-modal-gallery';

//servicios





const appRoutes: Routes = [
    {path:'', component: Cotizador_personalComponent, pathMatch: 'full'},
    { path: 'proyecto/:id', component: Cotizador_personalComponent },
    { path: 'login', component: LoginComponent },
];

@NgModule({
  declarations: [
    AppComponent,
    Cotizador_personalComponent,
    LoginComponent
  ],
  imports: [
    BrowserModule,
    FormsModule,
    ReactiveFormsModule,
    NgbModule.forRoot(),
    RouterModule.forRoot(appRoutes, { useHash: true }) ,
    Ng4LoadingSpinnerModule.forRoot() ,
    ModalGalleryModule.forRoot(),
    NgxCurrencyModule,
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
