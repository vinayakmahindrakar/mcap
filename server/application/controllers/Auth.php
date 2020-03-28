<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
	
    public function __construct()
	{
	    parent::__construct();

	    
		header('Access-Control-Allow-Origin: *'); 
		header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS'); 
		header('Access-Control-Allow-Headers: append,delete,entries,foreach,get,has,keys,set,values,X-Requested-With, Authorization, content-type, X-Token, x-tokenAccept,Accept-Language,Content-Language');

		$this->load->library('implementJwt');
	    $this->load->model('Auth_model');
	}   
	public function json_output($statusHeader, $response)
	{
		$this->output->set_content_type('application/json');
		//$this->output->set_status_header($statusHeader);
		$this->output->set_output(json_encode($response));
	}
	public function login()
	{
		$postdata = file_get_contents("php://input");

		if(isset($postdata))
		{
			$arrUserData 	= json_decode($postdata, true);
			$jwtToken		= '';
			$arrUserInfo 	= $this->Auth_model->checkIfValidUser($arrUserData);
			
			if(is_array($arrUserInfo) && (count($arrUserInfo)>0))
			{
				$arrUserInfo['expiresAt'] = date("Y-m-d H:i:s", strtotime("+12 hours"));
				$objJwt 	= new implementJwt();
				$jwtToken 	= $objJwt->generateToken($arrUserInfo);
						
				$this->json_output(200, array('token' => $jwtToken, 'msg' => 'success'));
			}
			else
			{
				$res = $this->sendAccessDenied();
			}	
		}
		else
		{
			$this->sendAccessDenied();
		}
	}
	
	public function sendAccessDenied()
	{
		$this->json_output(401, array('msg' => 'fail'));
	}
	public function getTokenData($token)
	{
		$objJwt = new implementJwt();
		try{
			$jwtData 	= $objJwt->decodeToken($token);
			echo json_encode($jwtData);
		}
		catch(Exception $e){
			$this->output->set_status_header(401);
			echo json_encode(array('status'=> false, 'msg'=> $e->getMessage()));
			die;
		}
	}
}