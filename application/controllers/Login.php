<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_CONTROLLER {
  public function __construct(){
    parent::__construct();
    $this->session->userdata('token') ? redirect('dosen') : true;
  }

  public function index(){
    $this->load->view('login');
  }

  public function auth()
  {
    $username = $this->POST('username');
    $password = $this->POST('password');

    $check = $this->db->get_where('user', ['username' => $username, 'password' => $password])->result();

    if ($check) {
      $data = [
        'username' => $username,
        'password'  => $password,
        'logged'  => TRUE
      ];
      $this->session->set_userdata('token', $data);
      $this->flashmsg('Sukses');
      redirect('dosen');
    } else {
      $this->flashmsg('Info yang diberikan tidak sesuai', 'danger');
      redirect('login');
    }
  }
}

/* End of file Login.php */
/* Location: ./application/controllers/Login.php */