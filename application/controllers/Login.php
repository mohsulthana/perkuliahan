<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_CONTROLLER {
  public function __construct(){
    parent::__construct();
  }

  public function index(){
    $this->load->view('login');
  }
}

/* End of file Login.php */
/* Location: ./application/controllers/Login.php */