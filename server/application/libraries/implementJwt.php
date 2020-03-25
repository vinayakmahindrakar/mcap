<?php
require ('jwt.php');

class implementJwt
{
	PRIVATE $key = 'asdsadafcdsc5464123sdcf@@#3';

	public function generateToken($data){
		
		$jwt = JWT::encode($data, $this->key);
		return $jwt;
	}	

	public function decodeToken($token){
		
		$decoded = JWT::decode($token, $this->key, array('HS256'));
		$decodedData = (array) $decoded;
		return $decodedData;
	}
}
?>