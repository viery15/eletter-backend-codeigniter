<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model("M_component");
    }

    public function index()
    {
      $this->load->view('admin/index');
    }

    public function component()
    {
      $this->load->view('admin/component');
    }

    public function format()
    {
      $this->load->view('admin/format');
    }
}
