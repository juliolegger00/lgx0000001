import {ActivatedRoute} from "@angular/router";
import { Component, OnInit, Input } from '@angular/core';


@Component({
  selector: 'app-cotizador_formapago',
  templateUrl: './cotizador_formapago.component.html'
})
export class Cotizador_formapagoComponent {

 ngOnInit() {
   let cotizador_personal = localStorage.getItem("cotizador_personal");
   console.log(cotizador_personal);
 }




}
