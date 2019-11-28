import { Component, OnInit } from '@angular/core';
import {UsuarioService} from './services/usuario.service';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css'],
  providers: [UsuarioService]
})
export class AppComponent {
  public title = 'app works!!';
  public token;
  public identity;

  constructor
  (
  	public _usuarioService: UsuarioService,
  ){
    this.identity = this._usuarioService.getIdentity();
    this.token = this._usuarioService.getToken();
  }

  ngOnInit()
  {
  	console.log('app component cargado');
  	//console.log(this._usuarioService.getIdentity());
  	//console.log(this._usuarioService.getToken());
  }
}
