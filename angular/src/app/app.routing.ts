import {ModuleWithProviders} from '@angular/core';
import {Routes,RouterModule} from '@angular/router';

import {LoginComponent} from './components/login.component';
import {RegisterComponent} from './components/register.component';
import {DefaultComponent} from './components/default.component';
import {UsuarioEditComponent} from './components/usuario.edit.component'
import {TareaNewComponent} from './components/tarea.new.component';
import {TareaDetailComponent} from './components/tarea.detail.component';
import {TareaEditComponent} from './components/tarea.edit.component';



const appRoutes: Routes = [
	{path: '', component: DefaultComponent},
	{path: 'index', component: DefaultComponent},
	{path: 'index/:page', component: DefaultComponent},
	{path: 'login', component: LoginComponent},
	{path: 'login/:id', component: LoginComponent}, //para hacer el logout
	{path: 'register', component: RegisterComponent},
	{path: 'usuario-edit', component: UsuarioEditComponent},
	{path: 'tarea-new', component: TareaNewComponent},
	{path: 'tarea/:id', component: TareaDetailComponent},
	{path: 'tarea-edit/:id', component: TareaEditComponent},
	{path: '**', component: LoginComponent}, //cuando la ruta no existe
];

export const appRoutingProviders: any[] = [];//permite cargar el servicio a nivel global del router
export const routing: ModuleWithProviders = RouterModule.forRoot(appRoutes); //se cargan todas las rutas