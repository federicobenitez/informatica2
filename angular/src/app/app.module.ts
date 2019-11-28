import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';

import { AppComponent } from './app.component';
import {LoginComponent} from './components/login.component';
import {RegisterComponent} from './components/register.component';
import {DefaultComponent} from './components/default.component';
import {UsuarioEditComponent} from './components/usuario.edit.component';
import {TareaNewComponent} from './components/tarea.new.component';
import {TareaDetailComponent} from './components/tarea.detail.component';
import {TareaEditComponent} from './components/tarea.edit.component';

import{GenerateDatePipe} from './pipes/generate.date.pipe'; //pipe para formatear fechas


import { FormsModule }   from '@angular/forms';// no olvidar para los formularios

import{routing, appRoutingProviders} from './app.routing'

import { Http, HttpModule } from '@angular/http';
import { HttpClientModule } from '@angular/common/http';

@NgModule({
  declarations: [
    AppComponent,
    LoginComponent,
    RegisterComponent,
    DefaultComponent,
    UsuarioEditComponent,
    TareaNewComponent,
    TareaDetailComponent,
    TareaEditComponent,
    GenerateDatePipe
  ],
  imports: [
    BrowserModule,
    FormsModule,
    routing,
    HttpModule,
    HttpClientModule
  ],
  providers: [
  	appRoutingProviders
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
