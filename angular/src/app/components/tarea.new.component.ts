import {Component, OnInit} from '@angular/core';
import {Router, ActivatedRoute, Params} from '@angular/router';
import {UsuarioService} from '../services/usuario.service';
import {TareaService} from '../services/tarea.service';
import {Tarea} from '../models/tarea';

@Component({
	selector:'tarea-new',
	templateUrl: '../views/tarea.new.html',
	providers: [UsuarioService, TareaService]
})

export class TareaNewComponent implements OnInit{
	public title: string;
	public identity;
	public token;
	public tarea: Tarea;
	public status;

	constructor(
		private _userService: UsuarioService,
		private _tareaService: TareaService,
		private _route: ActivatedRoute,
		private _router: Router
	){
		this.title = 'Crear nueva tarea';
		this.identity = this._userService.getIdentity();
		this.token = this._userService.getToken();
	}

	ngOnInit(){
		if(this.identity == null && !this.identity.sub){
			this._router.navigate(['/login']);
		}else{
			this.tarea = new Tarea(1, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '','','','','','','','');

		}
		//console.log(this._taskService.create());
	}
	onSubmit(){
		//console.log(this.tarea);

		this._tareaService.create(this.token, this.tarea).subscribe(
			response => {
				this.status = response.status;
				if(this.status != 'success'){
					this.status = 'error';
					console.log(response.msg);
				}else{
					this.tarea = response.data;

					this._router.navigate(['/', this.tarea.id]);//para poner en blanco los campos
				}
			},
			error => {
				console.log(<any>error);
			}
		);
	}
}