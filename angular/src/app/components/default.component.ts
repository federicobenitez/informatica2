	import {Component, OnInit} from '@angular/core';
import {Router, ActivatedRoute, Params} from '@angular/router';
import {UsuarioService} from '../services/usuario.service';
import {TareaService} from '../services/tarea.service';
import {Tarea} from '../models/tarea';

@Component({
	selector: 'default',
	templateUrl: '../views/default.html',
	providers:[UsuarioService, TareaService]
})

export class DefaultComponent implements OnInit
{
	public title: string;
	public identity;
	public token;
	public tareas :Array<Tarea>;
	public pages;
	public pagePrev;
	public pageNext;
	public loading;

	constructor(
		private _route: ActivatedRoute,
		private _router: Router,
		private _tareaService: TareaService,
		private _userService: UsuarioService,
	){ 
		this.title = 'Homepage';
		this.identity = this._userService.getIdentity();
		this.token = this._userService.getToken();
	}
	
	ngOnInit()
	{
		//console.log('el componente default ha sido cargado correctamente');
		this.getAllTareas();
	}

	getAllTareas()
	{

		this._route.params.forEach((params: Params) => {
			let page = +params['page'];

			if(!page){
				page = 1;
			}

			this.loading = 'show';

			this._tareaService.getTareas(this.token, page).subscribe(
				response => {
					if(response.status == 'success'){
						this.tareas = response.data;
						this.loading = 'hide';
						//console.log(response);	

						//total de páginas
						this.pages =[];
						for(let i=0; i<response.total_de_paginas; i++){
							this.pages.push(i);
						}

						//página anterior
						if(page >= 2){
							this.pagePrev = (page - 1);
						}else{
							this.pagePrev = page;
						}

						//pagina siguiente
						if(page < response.total_de_paginas){
							this.pageNext = (page+1);
						}else{
							this.pageNext = page;
						}
					}
				},
				error => {
					console.log(<any>error);
				}
			);
		});
	}

	//PROPIEDADES Y METODOS PARA EL BUSCADOR
	public filter = 0;
	public order = 0;
	public searchString;

	search(){
		//console.log(this.filter);
		//console.log(this.order);
		//console.log(this.searchString);

		//this.loading = 'show';

		if(!this.searchString ){
			this.searchString = null;
		}
		//|| this.searchString.trim().length == 0

		//el método subscribe recoje los datos que nos devuelve el servicio y posee
		//dos metodos de callback: response(recoje los datos) y error
		this._tareaService.search(this.token, this.searchString, this.filter, this.order).subscribe(
				response =>{
					if(response.status == 'success'){
						this.tareas = response.data;
						//this.loading = 'hide';	
					}else{
						this._router.navigate(['/index']);
					}

				},
				error =>{
					console.log(<any>error);
				}
			);
	}
}
