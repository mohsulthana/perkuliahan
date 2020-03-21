<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mata_kuliah extends MY_Controller {
  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    $this->data['title']        = "Daftar Mata Kuliah";
    $this->data['content']      = 'list_mata_kuliah';
    $this->data['mata_kuliah']  = $this->db->get('mata_kuliah')->result();
    $this->template($this->data);
  }
}