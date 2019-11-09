<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Users extends CI_Model{

	function __construct(){

		parent::__construct();
        $this->load->database();

    }


    public function get_user($user, $password){

        $user = $this->db->query("SELECT u.id, u.firstName, u.password, c.name from User as u, Credential as c 
			WHERE u.loginName = '$user' and c.id = u.fk_idCredential")->result_array();

        if(count($user) && $user[0]['password'] == hash('sha256', $password)) return $user[0];

        return 0;

    }

    public function get(){
        return $this->db->query("select * from users")->result_array();
    }

}
