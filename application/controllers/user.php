<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

  public function __construct()
  {
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    parent::__construct();

    $this->load->model("M_component");
    $this->load->model("M_format");
    $this->load->model("M_data_format");
  }

	public function index()
	{

	}

  public function login(){
    // API Configuration
    $this->_apiConfig([
        'methods' => ['POST'],
        'requireAuthorization' => true,
    ]);
  }
}
