<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mahasiswa extends MY_Controller {
  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    $this->data['title']    = 'Daftar Mahasiswa';
    $this->data['content']  = 'list_mahasiswa';
    $this->data['mahasiswa']= $this->db->get('mahasiswa')->result();
    $this->template($this->data); 
  }
}