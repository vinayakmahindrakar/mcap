<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
	
    public function __construct()
	{
	    parent::__construct();
	    $this->load->library('implementJwt');
	}   
	public function login()
	{
		$objJwt = new implementJwt();

		$tokenData['name'] = 'vinayak';
		$jwtToken = $objJwt->generateToken($tokenData);
		echo json_encode(array('token' => $jwtToken));
	}
	public function getTokenData()
	{
		$objJwt = new implementJwt();
		$receivedToken = $this->input->request_headers('Authorization');
		try{
			$jwtData = $objJwt->decodeToken($receivedToken['token']);
			echo json_encode($jwtData);
		}
		catch(Exception $e){
			http_response_code('401');
			echo json_encode(array('status'=> false, 'message'=> $e->getMessage()));
			die;
		}
	}
}