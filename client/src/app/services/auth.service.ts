import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class AuthService {

	private _authUrl = 'http://localhost/research/mcap/server/auth/login';

	constructor(private http: HttpClient) { }

	loginUser(user){
		return this.http.post<any>(this._authUrl, user);
	}

	isLoggedIn(){
		return !!localStorage.getItem('token');
	}

	getToken(){
		return localStorage.getItem('token');
	}
}
