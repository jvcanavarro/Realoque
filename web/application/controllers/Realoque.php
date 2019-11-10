<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Auth
 */

class Realoque extends CI_Controller
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

		$data["index"] = $this->uri->segment(2);
		

		$this->render('sample', $data);

	}

	public function lista(){

		$data['bairro'] = $this->uri->segment(2);

		$data = str_replace("%20", " ", $data);

		$this->render('lista', $data);
		

	}

	public function metricas(){

		$this->render('metricas', []);

	}


}
