//se importa en register.component.ts
export class Usuario{
	constructor(
		public id: number,
		public role: string,
		public nombre: string,
		public apellido: string,
		public email: string,
		public password: string
	){

	}
}