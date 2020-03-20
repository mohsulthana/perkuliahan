<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dosen extends MY_Controller {
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->data['title']		= 'List Dosen';
		$this->data['content']	= 'list_dosen';
		$this->template($this->data);
	}
}
