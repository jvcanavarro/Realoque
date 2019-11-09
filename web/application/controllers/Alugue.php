<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Auth
 */

class Alugue extends CI_Controller
{


	function __construct()
	{

		parent::__construct();
		$this->load->helper('url');

	}

	private function render($view, $data){

		$this->load->view('partials/header', $data);
		$this->load->view($view, $data);
		$this->load->view('partials/footer', $data);
		
		

	}

	public function index(){

		$this->render('index', []);

	}

	public function sample(){

		$this->render('sample', []);

	}

}
