import { Component } from '@angular/core';
import {HttpClient,   HttpParams, HttpHeaders } from '@angular/common/http';
import {delay } from 'rxjs/internal/operators/delay';
import { Ng4LoadingSpinnerService } from 'ng4-loading-spinner';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import {CONFIG } from "../config/config";


@Component({
  selector: 'app-login',
  templateUrl: './login.component.html'
})

export class LoginComponent {

    infoLogin:any={};

    constructor (
        private http: HttpClient,
        private spinnerService: Ng4LoadingSpinnerService,
        private router: Router,
        private routeActive: ActivatedRoute) {}


        public realizarLogin(){


          this.spinnerService.show();

          this.http.post(CONFIG.api_jwt_auth,{
                                              username: this.infoLogin.email,
                                              password: this.infoLogin.password
                                            }).toPromise()
                                            .then(data_token => {

                            //console.log(data);

                            if(sessionStorage.getItem(CONFIG.ss_token)){
                              sessionStorage.removeItem(CONFIG.ss_token);
                              sessionStorage.removeItem(CONFIG.ss_token_val);
                            }

                            sessionStorage.setItem(CONFIG.ss_token, JSON.stringify(data_token));
                            sessionStorage.setItem(CONFIG.ss_token_val, "ok");
                            let data_token_t:any={};
                            data_token_t=data_token;
                            this.spinnerService.hide();


                            //console.log( data_token_t);
                            //console.log("aca ok");
                            let uri = '/cotizador' ;
                            window.location.href = uri ;



                          },error=>{   console.log('error login: ',error);  this.spinnerService.hide(); }
                        );



        }//fin realizar loggedIn



        public validarToken(){

          this.spinnerService.show();
          let var_token=  JSON.parse(sessionStorage.getItem(CONFIG.ss_token));

          let httpOptions = {
            headers: new HttpHeaders({
              'Content-Type':  'application/json',
              'Authorization': 'Bearer '+var_token.token
            })
          };


          this.http.post(CONFIG.api_jwt_validate,{},httpOptions ).subscribe(data_token => {
                      //console.log(data);//{"code":"jwt_auth_valid_token","data":{"status":200}}
                      this.spinnerService.hide();
                    },error=>{   console.log('error validate:',error);  this.spinnerService.hide(); }
                  );



        }


    }
