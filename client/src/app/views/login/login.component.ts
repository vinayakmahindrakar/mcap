import { Component } from '@angular/core';
import { AuthService } from '../../services/auth.service';
import { Router } from '@angular/router'

@Component({
  selector: 'app-dashboard',
  templateUrl: 'login.component.html'
})
export class LoginComponent { 
	
	userData = {username:"", password:""};
	error = '';
	
	constructor(private _auth: AuthService, private _router: Router){

	}
	
	ngOnInit(){}

	login(){
		if(this.userData.username=='' || this.userData.password=='')
		{
			return this.error = 'Enter Username and Password';
		}else{
			this._auth.loginUser(this.userData).subscribe(
				res => {
					
					if(res.msg=='success'){
						localStorage.setItem('token', res.token);
						this._router.navigate(['/dashboard']);
					}else{
						this.error = 'Invalid Username or Password';
					}
				},
				err => console.log(err)
			);
		}
		
	}
}
