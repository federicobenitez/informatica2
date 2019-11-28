//se importa en tarea.new.component.ts
export class Tarea{
	constructor( 
	public id: number,
	public fecha,
	public nRegistro: string,
	public solicitante: string,
	public sReparacion: string,
	public sRedes: string,
	public sTelefonico: string,
	public sAsesoramiento: string,
	public marca: string,
	public modelo: string,
	public nInventario: string,
	public rrevTecnica: string,
	public fallaHard: string,
	public fallaSoft: string,
	public recomendaciones: string,
	public destino: string,
	public fechaDest: string,
	public horaDest: string,
	public motivo: string,
	public fallasDet: string,
	public medidasTom: string,
	public createdAt,
	public updatedAt
){}
}