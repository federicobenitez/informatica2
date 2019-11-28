import {Component, OnInit} from '@angular/core';
import {Router, ActivatedRoute, Params} from '@angular/router';
import {Usuario} from '../models/usuario';
import {UsuarioService} from '../services/usuario.service';

@Component({
	selector: 'register',
	templateUrl: '../views/register.html',
	providers: [UsuarioService]
})

export class RegisterComponent implements OnInit
{
	public title: string;
	public usuario: Usuario;
	public status;

	constructor(
		private _route: ActivatedRoute,
		private _router: Router,
		private _usuarioService: UsuarioService,

	){ 
		this.title = 'REGISTRO';
		this.usuario = new Usuario(1,"","","","","");
	}
	
	ngOnInit()
	{
		//console.log('el componente register ha sido cargado correctamente');
	}

	onSubmit(){
		//console.log(this.usuario);
		this._usuarioService.register(this.usuario).subscribe(
			response => {
				this.status = response.status;
				if( response.status != 'success'){
					this.status = 'error';
				}else{
					this.usuario = new Usuario(1,"","","","","");
				}

			},
			error => {
				console.log(<any>error);
			}
		);
	}
}
