<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../vendor/autoload.php';
use \Firebase\JWT\JWT;

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
    $post = $this->input->post();
    $key = "giselle_key";
    if ($post['nik'] == '619008') {
      $token = array(
          "iss" => "http://example.org",
          "admin" => "admin",
          "nik" => '619008',
          "name" => 'viery darmawan'
      );

      $jwt = JWT::encode($token, $key);

      $response = [
        'msg' => 'Login successful',
        'token' => $jwt
      ];

      echo json_encode($response);
    }
    else {
      $response = [
        'msg' => 'Invalid Credential!'
      ];
      echo json_encode($response);
    }
  }
}
