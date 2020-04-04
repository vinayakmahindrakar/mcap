<?php
class Auth_model extends CI_Model 
{
	function __construct() 
    {
    	parent::__construct();		
    }
	function checkIfValidUser($userDetails){

		$arrResult= array();
		$username = $userDetails['username'];
		$password = md5($userDetails['password']);

		$this->db->select('cu.user_id,
							  cu.user_name,
							  cu.user_email,
							  cu.role_id,
							  cu.type_id,
							  str.id AS store_id,
							  str.store_code,
							  str.product_status,
							  str.name,
							  str.hub_id,
							  str.store_prefix,
							  ur.name,
							  ur.source');
		$this->db->from('cms_users as cu');
		$this->db->join('stores AS str', 'str.id = cu.type_id', 'LEFT');
		$this->db->join('user_roles AS ur', 'ur.id = cu.role_id', 'LEFT');
		$this->db->where('cu.status', 1);
		$this->db->where('cu.user_email', $username);
		$this->db->where('cu.user_password', $password);

		$query = $this->db->get();
			
		if($query->num_rows())
		{
			$arrResult = $query->row_array();
		}
		return $arrResult;

	}
}