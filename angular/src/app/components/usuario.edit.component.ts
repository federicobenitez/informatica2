import {Component, OnInit} from '@angular/core';
import {Router, ActivatedRoute, Params} from '@angular/router';
import {UsuarioService} from '../services/usuario.service';
import {Usuario} from '../models/usuario';

@Component({ 
	selector: 'usuario-edit',
	templateUrl: '../views/usuario.edit.html',
	providers: [UsuarioService]
})

export class UsuarioEditComponent implements OnInit{
	public title: string;
	public usuario: Usuario;
	public status;
	public identity;
	public token;

	constructor(
		private _usuarioService: UsuarioService,
		private _route: ActivatedRoute,
		private _router: Router
	){
		this.title = 'Modificar Mis Datos';
		this.identity = this._usuarioService.getIdentity();
		this.token = this._usuarioService.getToken();
	}

	ngOnInit(){
		if(this.identity == null){
			this._router.navigate(['/login']);
		}else{
			this.usuario = new Usuario(
				this.identity.sub,
				this.identity.role,
				this.identity.nombre,
				this.identity.apellido,
				this.identity.email,
				this.identity.password
				);
		}
	}

	onSubmit(){
		//console.log(this.usuario);

		this._usuarioService.update_user(this.usuario).subscribe(
			response => {
				this.status = response.status;
				if(this.status != 'success'){
					this.status = 'error'
				}else{
					localStorage.setItem('identity', JSON.stringify(this.usuario));

					//this._router.navigate(['/login']);
				}
			},
			error => {
				console.log(<any>error);
			}
		);
	}
}