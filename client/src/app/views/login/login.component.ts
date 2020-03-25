import { Component } from '@angular/core';

@Component({
  selector: 'app-dashboard',
  templateUrl: 'login.component.html'
})
export class LoginComponent { 
	public username:string; 
	public password:string;

	constructor(){}
	
	ngOnInit(){}

	login(username, password){
		this.username = username.value;
		this.password = password.value;
	}
}
