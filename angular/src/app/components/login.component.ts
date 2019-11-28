import {Component, OnInit} from '@angular/core';
import {Router, ActivatedRoute, Params} from '@angular/router';
import {UsuarioService} from '../services/usuario.service'

@Component({
	selector: 'login',
	templateUrl: '../views/login.html',
	providers: [UsuarioService]
})

export class LoginComponent implements OnInit
{
	public title: string;
	public usuario;
	public identity;
	public token;

	constructor(
		private _route: ActivatedRoute,
		private _router: Router,
		private _usuarioService: UsuarioService
	){
		this.title = 'Ingreso al Sistema';
		this.usuario = {
			"email":"",
			"password":"",
			"hash": "true" // para que no devuelva el hash debe ser null y no false
		};
	}

	ngOnInit()
	{
		//console.log('el componente de login ha sido cargado correctamente');
		//console.log(JSON.parse(localStorage.getItem('identity'))); //devuelve el usuario
		//console.log(this._usuarioService.getIdentity());
		//console.log(JSON.parse(localStorage.getItem('token'))); //devuelve le token
		//console.log(this._usuarioService.getToken());
		this.logout();
		this.redirectIfIdentify();
	}

	onSubmit()
	{
		//console.log(this.usuario);
		this._usuarioService.signup(this.usuario).subscribe(
			response => 
			{
				this.identity = response;
				if (this.identity.length <= 1)
				{
					console.log('error en el servicio de usuario');
				}else{
					if(!this.identity.status){  //si existe status es porque hubo error
						//en el local storage no se pueden guardar objetos
						//solo strings, por eso se usa la propiedad stringify
						localStorage.setItem('identity', JSON.stringify(this.identity));

						//get token
						this.usuario.hash = null;
						this._usuarioService.signup(this.usuario).subscribe(
							response => {	
								this.token = response;

								if(this.identity.length <= 1){
									console.log('error en el servidor');
								}else{
									if(!this.identity.status){
										localStorage.setItem('token', JSON.stringify(this.token));

										window.location.href = "/";
									}
								}
							},
							error =>{
								console.log(<any>error);
							}
						);
					}
				}

			},
			error => 
			{
				console.log(<any>error);
			}
		);
	}

	logout()
	{
		this._route.params.forEach((params: Params) =>{
			let logout = +params['id'];
			if (logout == 1)
			{
				localStorage.removeItem('identity');
				localStorage.removeItem('token');

				this.identity = null;
				this.token = null;

				window.location.href = '/login';
			}
		});
	}

	redirectIfIdentify() //restringir el acceso a la pagina login
	{
		let identity = this._usuarioService.getIdentity();
		if (identity != null && identity.sub)
		{
			this._router.navigate(["/"]);
		}
	}
}
