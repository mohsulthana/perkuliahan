<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelas extends MY_Controller {
  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    $this->data['title']    = 'Daftar Kelas';
    $this->data['content']  = 'kelas/index';
    $this->data['kelas']= $this->db->get('kelas')->result();
    $this->template($this->data); 
  }
  public function create(){
    $this->data['title']    = 'Tambah Kelas';
    $this->data['content']  = 'kelas/create';
    $this->template($this->data);
  }
  public function store(){
    $nama_kelas = strtoupper($this->input->post('nama_kelas'));

    $this->db->where('nama_kelas',$nama_kelas);
    $query = $this->db->get('kelas');
    if ($query->num_rows() > 0){
      // JIKA NAMA SUDAH ADA, BERI FLASHMSG, BACK
      redirect('kelas/create','refresh');
    }
    else{
      // JIKA NAMA TIDAK ADA, BERI FLASHMSG, INDEX
      $data = [
        'nama_kelas' => $nama_kelas,
      ];

      $this->db->insert('kelas', $data);
      redirect('kelas','refresh');
    }
  }
  public function edit($id){

    $this->db->where('id',$id);
    $this->data['kelas'] = $this->db->get('kelas')->result()[0];

    $this->data['title']    = 'Edit Kelas';
    $this->data['content']  = 'kelas/edit';
    $this->template($this->data);
  }
  public function update($id){
    $nama_kelas = strtoupper($this->input->post('nama_kelas'));

    $data = [
        'nama_kelas' => $nama_kelas,
      ];

    $this->db->set($data);
    $this->db->where('id', $id);
    $this->db->update('kelas');
    redirect('kelas','refresh');
  }
  public function destroy($id){
    $this->db->delete('kelas', ['id' => $id]);
    redirect('kelas','refresh');
  }
}