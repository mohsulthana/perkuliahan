<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dosen extends MY_Controller {
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->data['title']		= 'Daftar Dosen';
		$this->data['content']	= 'list_dosen';
		$this->data['dosen']			= $this->db->get('dosen')->result();
		$this->template($this->data);
	}
}
