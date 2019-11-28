import {Injectable} from '@angular/core';
import {Http, Response, Headers, RequestOptions} from '@angular/http';
import 'rxjs/add/operator/map';
import {Observable} from 'rxjs/Observable';
import {GLOBAL} from './global';

@Injectable()
export class TareaService{
	public url: string;

	constructor(
		private _http: Http	
	){
		this.url = GLOBAL.url;
	}

	create(token, tarea){
		//console.log("hola desde el servicio de tareas");
		let json = JSON.stringify(tarea);
		let params = "json="+json+"&authorization="+token;
		let headers = new Headers({'Content-Type':'application/x-www-form-urlencoded'});

		return this._http.post(this.url+'/tarea/new', params, {headers: headers})
			.map(res => res.json());
	}

	getTareas(token, page = null){
		let params = "authorization="+token;
		let headers = new Headers({'Content-Type':'application/x-www-form-urlencoded'});

		if(page == null){
			page = 1;
		}

		return this._http.post(this.url+'/tarea/list?page='+page, params, {headers:headers})
			.map(res => res.json());
	}
	getTarea(token, id){
		let params = "authorization="+token;
		let headers = new Headers({'Content-Type':'application/x-www-form-urlencoded'});

		return this._http.post(this.url+'/tarea/detail/'+id, params, {headers:headers})
			.map(res => res.json());
	}
	update(token,tarea, id){
		let json = JSON.stringify(tarea);
		let params = "json="+json+"&authorization="+token;
		let headers = new Headers({'Content-Type':'application/x-www-form-urlencoded'});

		return this._http.post(this.url+'/tarea/edit/'+id, params, {headers: headers})
			.map(res => res.json());
	}

	search(token, search = null, filter = null, order = null){
		let params = "authorization="+token+"&filter="+filter+"&order="+order;
		let headers = new Headers({'Content-Type':'application/x-www-form-urlencoded'});

		let url : string;
		if(search == null){
			url = this.url + '/tarea/search';
		}else{
			url = this.url + '/tarea/search/' + search;
		}

		return this._http.post(url, params, {headers: headers})
			.map(res => res.json()); //se convierte la respuesta en un
									 //utilizable por javascript
	}

	deleteTarea(token, id){
		let params = "authorization="+token;
		let headers = new Headers({'Content-Type':'application/x-www-form-urlencoded'});

		//se usa remove porque así está definido en symfony
		return this._http.post(this.url+"/tarea/remove/"+id, params, {headers:headers})
			.map(res => res.json());
	}
}