import {Component, OnInit} from '@angular/core';
import {Router, ActivatedRoute, Params} from '@angular/router';
import {UsuarioService} from '../services/usuario.service';
import {TareaService} from '../services/tarea.service';
import {Tarea} from '../models/tarea';

@Component({
	selector:'tarea-edit',
	templateUrl: '../views/tarea.new.html',
	providers: [UsuarioService, TareaService]
})

export class TareaEditComponent implements OnInit{
	public title: string;
	public identity;
	public token;
	public tarea: Tarea;
	public status;
	public loading;

	constructor(
		private _usuarioService: UsuarioService,
		private _tareaService: TareaService,
		private _route: ActivatedRoute,
		private _router: Router
	){
		this.title = 'Modificar tarea';
		this.identity = this._usuarioService.getIdentity();
		this.token = this._usuarioService.getToken();
	}

	ngOnInit(){
		//console.log('prueba'+this.tarea);
		if(this.identity == null && !this.identity.sub){
			this._router.navigate(['/login']);
		}else{
			//this.task = new Task(1, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
			this.getTarea();
		}
		//console.log(this._taskService.create());
	}
	onSubmit(){
		//console.log(this.tarea);
		this._route.params.forEach((params : Params) => {
			let id = +params['id'];

			this._tareaService.update(this.token, this.tarea, id).subscribe(
				response => {
					this.status = response.status;
					if(this.status != 'success'){
						this.status = 'error';
						//console.log(response.msg);
					}else{
						this.tarea = response.data;

						this._router.navigate(['/', this.tarea.id]);//para poner en blanco los campos
					}
				},
				error => {
					console.log(<any>error);
				}
			);
		});
	}

	getTarea(){
		this.loading = 'show';
		this._route.params.forEach((params : Params) => {
			let id = +params['id'];

			this._tareaService.getTarea(this.token, id).subscribe(
				response => {
					if(response.status == 'success'){
						//console.log('idresponse:'+response.msg.usuario.id);
						//console.log('id:'+this.identity.sub);
						
						//if (response.data.user.id == this.identity.sub){
						if (response.msg.usuario.id == this.identity.sub){
							//podemos ver la tarea
							this.tarea = response.msg;
							this.loading = 'hide';
						}else{
							this._router.navigate(['/']);
						}
						
						//console.log(response.status);
					}else{
						this._router.navigate(['/login']);
						//console.log(response.status+response.msg);
						//console.log(id);
					}
				},
				error => {
					console.log(<any>error);
				},
			);
		});
	}
}