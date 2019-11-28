import {Component, OnInit} from '@angular/core';
import {Router, ActivatedRoute, Params} from '@angular/router';
import {UsuarioService} from '../services/usuario.service';
import {TareaService} from '../services/tarea.service';
import {Tarea} from '../models/tarea';
import * as jsPDF from 'jspdf';


@Component({
	selector: 'task-detail',
	templateUrl: '../views/tarea.detail.html',
	providers: [UsuarioService, TareaService]
})
export class TareaDetailComponent implements OnInit{
	public identity;
	public token;
	public tarea : Tarea;
	public loading;



	constructor(
		private _usuarioService: UsuarioService,
		private _tareaService: TareaService,
		private _route: ActivatedRoute,
		private _router: Router
	){
		this.identity = this._usuarioService.getIdentity();
		this.token = this._usuarioService.getToken();
	}

	ngOnInit(){
		if(this.identity && this.identity.sub){
			//llamada al servicio de tareas para sacar una tarea
			//llamada al metodo de este componente
			this.getTarea();
		}else{
			this._router.navigate(['/login']);
		}
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

	deleteTarea(id){
		console.log('tarea borrada');

		this._tareaService.deleteTarea(this.token, id).subscribe(
			response =>{
				if(response.status == 'success'){
					this._router.navigate(['/']);	
				}else{
					alert('No se ha podido borrar la tarea');
				}
			},
			error =>{
				console.log(<any>error);
			}
		);

	}
	
	pdf(){
	    const doc = new jsPDF();

	    this.loading = 'show';
		this._route.params.forEach((params : Params) => {
			let id = +params['id'];

			this._tareaService.getTarea(this.token, id).subscribe(
				response => {
					if(response.status == 'success'){
						console.log('idresponse:'+response.msg.usuario.id);
						console.log('id:'+this.identity.sub);
						
						//if (response.data.user.id == this.identity.sub){
						if (response.msg.usuario.id == this.identity.sub){
							//podemos ver la tarea
							this.tarea = response.msg;
							this.loading = 'hide';

							//Prueba PDF
							
							var logo = new Image();
							logo.src = './assets/img/icono.png';

							//doc.addimage(nombre,formato,columna,fila,tamaño)
							doc.addImage(logo, 'png', 150, 10,10,10);
							

							//doc.text(mensaje, columna, fila);
							//doc.addFont('ComicSansMS', 'Comic Sans', 'normal');
							//doc.setFont('ComicSansMs');
							doc.setFontSize(16);
							doc.setFontType('bold');
							doc.text('SOLICITUD DE SERVICIO TÉCNICO',20,20);

							//doc.setFont('Comic Sans');
							doc.setFontSize(8);
							doc.text('Agente Encargado: '+response.msg.usuario.nombre+' '+response.msg.usuario.apellido,20,30)
							doc.text('Numero de Registro: '+response.msg.nRegistro,100, 30);
							doc.text('Solicitante: '+response.msg.solicitante,20,35);

							doc.setFontSize(10);
							doc.text('TIPO DE SERVICIO',20, 50);

							doc.setFontSize(8);
							doc.text('Reparación: '+response.msg.sReparacion,20, 55);
							doc.text('Mantenimiento de Redes e Internet: '+response.msg.sRedes,20, 60);
							doc.text('Servicio Telefónico: '+response.msg.sTelefonico,20, 65);

							var asesoramiento = doc.splitTextToSize('Asesoramiento Técnico: '+response.msg.sAsesoramiento,150);
							doc.text(asesoramiento, 20,70);
							//doc.text('Asesoramiento Técnico: '+response.msg.sAsesoramiento,20, 70);

							doc.setFontSize(10);
							doc.text('DATOS IDENTIFICATORIOS DEL EQUIPO A REVISAR',20, 90);

							doc.setFontSize(8);
							doc.text('Marca: '+response.msg.marca,20, 95);
							doc.text('Modelo: '+response.msg.modelo,100, 95);
							doc.text('Nº de Inventario: '+response.msg.nInventario,20, 100);

							var revision  = doc.splitTextToSize('Revisión Técnica: '+response.msg.rrevTecnica,150);
							doc.text(revision, 20,150);
							//doc.text('Revisión Técnica: '+response.msg.rrevTecnica,20, 105);

							doc.text('Falla de Hardware: '+response.msg.fallaHard,20, 115);
							doc.text('Falla de Software: '+response.msg.fallaSoft,20, 120);

							var recomendaciones = doc.splitTextToSize('Recomendaciones: '+response.msg.recomendaciones,150);
							doc.text(recomendaciones, 20,125);
							//doc.text('Recomendaciones: '+response.msg.recomendaciones,20, 125);

							doc.text('Destino del Bien Informático: '+response.msg.destino,20, 135);

							var motivo = doc.splitTextToSize('Motivo: '+response.msg.fallasDet,150);
							doc.text(motivo, 20,140);
							//doc.text('Motivo: '+response.msg.fallaHard,20, 140);

							doc.text('FIRMA Y SELLO ',100, 180);
							doc.text('_____________',101,180);
							doc.text('-------------------------------------------------------------------------------------------------------------',20, 190);
							doc.text('TROQUEL PARA EL SOLICITANTE',20, 193);

							doc.text('Agente Encargado: '+response.msg.usuario.nombre+' '+response.msg.usuario.apellido,20,200)
							doc.text('Numero de Registro: '+response.msg.nRegistro,100, 200);
							doc.text('Solicitante: '+response.msg.solicitante,20,205);

							doc.setFontSize(10);
							doc.text('DATOS IDENTIFICATORIOS DEL EQUIPO A REVISAR',20, 215);

							doc.setFontSize(8);
							doc.text('Marca: '+response.msg.marca,20, 220);
							doc.text('Modelo: '+response.msg.modelo,100, 220);
							doc.text('Nº de Inventario: '+response.msg.nInventario,20, 225);

							doc.text('FIRMA Y SELLO ',100, 245);
							doc.text('_____________',101,245);

							doc.addPage();
							doc.setFontSize(10);
							doc.setFontType('bold');

							doc.text('FALLAS DETECTADAS:',20,20);
							var fallas = doc.splitTextToSize(response.msg.fallasDet,150);
							doc.setFontSize(8);
							doc.text(fallas, 20,25);
							//doc.text('FALLAS DETECTADAS:'+response.msg.fallasDet,20,20);
							//doc.text('__________________',21,20);

							doc.setFontSize(10);
							doc.text('MEDIDAS TOMADAS',20,35);
							doc.setFontSize(8);
							var medidas = doc.splitTextToSize(response.msg.medidasTom,150);
							doc.text(medidas, 20,40);
							//doc.text('MEDIDAS TOMADAS:'+response.msg.medidasTom,20,35);
							//doc.text('__________________',21,35);

							doc.text('DESTINO DEL BIEN INFORMÁTICO: '+response.msg.destino,20, 75);
							doc.text('Fecha: '+response.msg.fechaDest,20,80);
							doc.text('Hora: '+response.msg.horaDest,80,80);

							var motivo2 = doc.splitTextToSize('Motivo: '+response.msg.motivo,150);
							doc.text(motivo2, 20,90);
							//doc.text('Motivo: '+response.msg.motivo,20, 90);

							doc.text('RECIBIDO EN CONFORMIDAD POR:',20,130);
							doc.setFontSize(8);
							doc.text('FIRMA',30,150);
							doc.text('CARGO QUE OCUPA EN LA DEPENDENCIA',80,150);
							/*
							doc.text('ticket:'+response.msg.ticket_num, 10, 55); 
							//doc.text('Dni/Cuil:'+response.msg.dniCuil, 55, 20);
							//doc.text('Domicilio:'+response.msg.domicilio, 55, 40);
							//doc.text('Teléfono:'+response.msg.telefono, 55, 60);
							//doc.text('Localidad:'+response.msg.localidad, 55, 80);

							doc.addPage();

							doc.text('ticket:'+response.msg.ticket_num, 5, 5);
							doc.text('Dni/Cuil:'+response.msg.dniCuil, 5, 20);
							doc.text('Domicilio:'+response.msg.domicilio, 5, 40);
							doc.text('Teléfono:'+response.msg.telefono, 5, 60);
							doc.text('Localidad:'+response.msg.localidad, 5, 80);
							*/
	    					doc.save('reporte.pdf');
						
						
						}else{
							this._router.navigate(['/']);
						}
						
						console.log(response.status);
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