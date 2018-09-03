import {Injectable} from "@angular/core";
import {CanActivate} from "@angular/router";
import { Router } from "@angular/router";
import {HttpClient,   HttpParams, HttpHeaders } from '@angular/common/http';
import {CONFIG } from "../config/config";

@Injectable()
export class Guardian implements CanActivate{

    loggedIn = false;
    tokenValido=true;

    constructor( private http: HttpClient,private router:Router){
      //console.log("guardian ");
      let var_token= sessionStorage.getItem(CONFIG.ss_token_val);
      if(var_token=="ok")this.tokenValido=true;
      else this.tokenValido=false;
 
      if(this.tokenValido ){
          this.loggedIn = true;
      }else{
          this.loggedIn = false;
          let uri = '#/' ;
          window.location.href = uri ;
      }

    }//constructor


    canActivate(){
        //console.log("guardian canActivate.");
        let var_token= sessionStorage.getItem(CONFIG.ss_token_val);
        if(var_token=="ok")this.tokenValido=true;
        else this.tokenValido=false;

        if(this.tokenValido ){
            this.loggedIn = true;
        }else{
            this.loggedIn = false;
            let uri = '#/' ;
            window.location.href = uri ;
        }
        return this.loggedIn;
    }//canActivate


    public validarToken(){

      let var_token=  JSON.parse(sessionStorage.getItem(CONFIG.ss_token));

      let httpOptions = {
        headers: new HttpHeaders({
          'Content-Type':  'application/json',
          'Authorization': 'Bearer '+var_token.token
        })
      };

      this.http.get(CONFIG.api_jwt_validate,httpOptions ).subscribe(data_token => {
          //console.log(data);//{"code":"jwt_auth_valid_token","data":{"status":200}}
          let data_token_t:any={};
          data_token_t=data_token;
          if(data_token_t.code=="jwt_auth_valid_token"){sessionStorage.setItem(CONFIG.ss_token_val, "ok");}
          else {sessionStorage.setItem(CONFIG.ss_token_val, "fail");}
        },error=>{   console.log('error validate:',error);sessionStorage.setItem(CONFIG.ss_token_val, "fail");  }
      );

    }//validarToken

}
