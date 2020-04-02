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
		$this->data['content']	= 'dosen/index';
		$this->data['dosen']			= $this->db->get('dosen')->result();
		$this->template($this->data);
	}
  public function create(){
    $this->data['title']    = 'Tambah Dosen';
    $this->data['content']  = 'dosen/create';
    $this->template($this->data);
  }
  public function store(){
    $nama = strtoupper($this->input->post('nama'));
    $nip  = $this->input->post('nip');

    $this->db->where('nama',$nama);
    $query = $this->db->get('dosen');
    $flag = "";
    if ($query->num_rows() > 0){
      // JIKA NAMA SUDAH ADA, BERI FLASHMSG, BACK
      redirect('dosen/create','refresh');
    }
    else{
      // JIKA NAMA TIDAK ADA, BERI FLASHMSG, INDEX
      $data = [
        'nama' => $nama,
        'nip'  => $nip,
      ];

      $this->db->insert('dosen', $data);
      redirect('dosen','refresh');
    }
  }
  public function edit($id){

    $this->db->where('id',$id);
    $this->data['dosen'] = $this->db->get('dosen')->result()[0];

    $this->data['title']    = 'Edit Dosen';
    $this->data['content']  = 'dosen/edit';
    $this->template($this->data);
  }
  public function update($id){
    $nama = strtoupper($this->input->post('nama'));
    $nip  = $this->input->post('nip');

    $data = [
        'nama' => $nama,
        'nip'  => $nip,
      ];

    $this->db->set($data);
    $this->db->where('id', $id);
    $this->db->update('dosen');
    redirect('dosen','refresh');
  }
  public function destroy($id){
    $this->db->delete('dosen', ['id' => $id]);
    redirect('dosen','refresh');
  }
}
