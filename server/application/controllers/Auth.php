<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
	
    public function __construct()
	{
	    parent::__construct();
	    header('Access-Control-Allow-Origin: *'); 
		header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS'); 
		header('Access-Control-Allow-Headers: X-Requested-With, content-type, X-Token, x-token');

		$this->load->library('implementJwt');
	    $this->load->model('Auth_model');
	}   
	public function login()
	{
		$postdata = file_get_contents("php://input");
		
		if(isset($postdata) && !empty($postdata)){

			$arrUserData 	= json_decode($postdata, true);
			$jwtToken		= '';
			$arrUserInfo 	= $this->Auth_model->checkIfValidUser($arrUserData);
			
			if(is_array($arrUserInfo) && count($arrUserInfo)>0){
				$objJwt 	= new implementJwt();
				$jwtToken 	= $objJwt->generateToken($arrUserInfo);
			}
			
			echo json_encode(array('token' => $jwtToken));	
		}
		
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