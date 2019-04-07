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
    $this->load->model("M_user");
  }

	public function index()
	{
    $data = $this->M_user->getAll();

    for ($i=0; $i < count($data); $i++) {
      if ($data[$i]['access'] != 'all') {
        $data[$i]['access'] = json_decode($data[$i]['access']);
        for ($j=0; $j < count($data[$i]['access']); $j++) {
          $temp = $this->M_format->getName($data[$i]['access'][$j]);
          $data[$i]['access'][$j] = $temp->name;
        }
      }
    }
    echo json_encode($data);

	}

  public function configUser(){
    $user_exist = $this->M_user->getAll();
    $data = DATA_USER;

    for ($i=0; $i < count($data); $i++) {
      foreach ($user_exist as $key => $value) {
        if ($data[$i]['nik'] == $value['nik']) {
          unset($data[$i]);
          $data = array_values($data);
        }
      }
    }

    for ($i=0; $i < count($data); $i++) {
      $data[$i]['label'] = $data[$i]['nik'] . ' - '. $data[$i]['nama'];
    }

    // echo json_encode($data);

  }

  public function create(){
    $post = $this->input->post();

    $input['nik'] = $post['nik'];
    $input['name'] = $post['name'];
    $input['role'] = $post['role'];
    if ($post['access'] == '') {
      $input['access'] = 'all';
    }
    else {
      $input['access'] = json_encode($post['access']);
    }

    $this->M_user->save($input);

  }

  public function delete($id){
    $this->M_user->delete($id);
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
