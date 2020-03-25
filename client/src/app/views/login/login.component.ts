import { Component } from '@angular/core';
import { AuthService } from '../../services/auth.service';
import { Router } from '@angular/router'

@Component({
  selector: 'app-dashboard',
  templateUrl: 'login.component.html'
})
export class LoginComponent { 
	
	userData = {};

	constructor(private _auth: AuthService, private _router: Router){}
	
	ngOnInit(){}

	login(){
		this._auth.loginUser(this.userData).subscribe(
			res => {
				localStorage.setItem('token', res.token);
				this._router.navigate(['/dashboard']);
			},
			err => console.log(err)
		);
	}
}
