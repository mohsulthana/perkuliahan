<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dosen extends MY_Controller {
	public function __construct()
	{
    parent::__construct();
    $this->session->userdata('token') ? true : redirect('login');
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

    // CEK APAKAH NAMA SUDAH ADA
    $this->db->where('nama',$nama);
    $query = $this->db->get('dosen');

    if ($query->num_rows() > 0){
      // JIKA NAMA SUDAH ADA, BERI FLASHMSG, GO BACK
      $this->flashmsg('Nama dosen sudah ada!','danger');
      redirect('dosen/create','refresh');
    }
    else{
      // JIKA NAMA TIDAK ADA, BERI FLASHMSG, GO TO INDEX
      $data = [
        'nama' => $nama,
        'nip'  => $nip,
      ];

      $this->db->insert('dosen', $data);
      $this->flashmsg('Sukses menambahkan data dosen','success');
      redirect('dosen/index','refresh');
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

    // CEK APAKAH NAMA SUDAH ADA
    $this->db->where('nama',$nama);
    $query = $this->db->get('dosen');

    if ($query->num_rows() > 0){
      // JIKA NAMA SUDAH ADA, BERI FLASHMSG, GO BACK
      $this->flashmsg('Nama dosen sudah ada!','danger');
      redirect('dosen/edit/'.$id,'refresh');
    }
    else{
      // JIKA NAMA TIDAK ADA, BERI FLASHMSG, GO TO INDEX
      $data = [
        'nama' => $nama,
        'nip'  => $nip,
      ];

      $this->db->set($data);
      $this->db->where('id', $id);
      $this->db->update('dosen');
      $this->flashmsg('Sukses edit data dosen','success');
      redirect('dosen','refresh');
    }

  }
  public function destroy($id){
    $this->db->delete('dosen', ['id' => $id]);
    $this->flashmsg('Sukses menghapus data dosen','success');
    redirect('dosen','refresh');
  }
}
