import {Injectable} from '@angular/core';
import {Http,Response,Headers} from '@angular/http';
import "rxjs/add/operator/map"; //para capturar peticiones ajax
import {Observable} from 'rxjs/Observable';	
import {GLOBAL} from './global';

@Injectable()
export class UsuarioService
{
	public url: string;
	public identity;
	public token;
	public status;

	constructor(private _http: Http)
	{
		this.url = GLOBAL.url;
	}

	signup(user_to_login){
		let json = JSON.stringify(user_to_login);
		let params = "json="+json;
		let headers = new Headers({'Content-Type':'application/x-www-form-urlencoded'});

		return this._http.post(this.url+'/login', params, {headers:headers})
			.map(res => res.json());
	}

	getIdentity(){
		let identity = JSON.parse(localStorage.getItem('identity'));

		if(identity != 'undefined'){
			this.identity = identity;
		}else{
			this.identity = null;
		}

		return this.identity;
	}

	getToken(){
		let token = JSON.parse(localStorage.getItem('token'));

		if(token != 'undefined'){
			this.token = token;
		}else{
			this.token = null;
		}

		return this.token;
	}

	register(user_to_register){
		let json = JSON.stringify(user_to_register);
		let params = "json="+json;
		let headers = new Headers({'Content-Type':'application/x-www-form-urlencoded'});

		return this._http.post(this.url+'/usuario/new', params,{headers: headers})
			.map(res => res.json());
	}

	update_user(user_to_update){
		let json = JSON.stringify(user_to_update);
		let params = "json="+json+"&authorization="+this.getToken();
		let headers = new Headers({'Content-type':'application/x-www-form-urlencoded'});

		return this._http.post(this.url+'/usuario/edit', params, {headers: headers})
			.map(res => res.json());
	}

}