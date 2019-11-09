<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Measure_Requests extends CI_Model{
    
    function __construct(){

		parent::__construct();
        $this->load->database();

    }

    /**
     * Realiza a requisição dos dados mais recentes
     * 
     * @param string $column Coluna a ser buscada
     * 
     * @return string[]
     */

    public function real_time(){

        $sql = "SELECT * FROM Measurement WHERE id = (SELECT MAX(id) FROM Measurement)";

        return $this->db->query($sql)->result_array()[0];

    }

	/**
	 * Realiza a requisição de dados de um período específico
	 *
	 * @param string $start_time
	 * @param string $end_time
	 * @param string $column
	 *
	 * @return string[][]
	 */

    public function offline(string $start_time, string $end_time, string $columns){

        
        $sql = "SELECT time,$columns
		FROM Measurement
		WHERE time
		BETWEEN '$start_time' AND '$end_time' order by time";

        return $this->db->query($sql)->result_array();

    }


}
