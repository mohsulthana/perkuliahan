<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelas extends MY_Controller {
  public function __construct()
  {
    parent::__construct();
    $this->session->userdata('token') ? true : redirect('login');
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

    // CEK JIKA NAMA KELAS SUDAH ADA
    $this->db->where('nama_kelas',$nama_kelas);
    $query = $this->db->get('kelas');
    if ($query->num_rows() > 0){
      // JIKA NAMA KELAS SUDAH ADA, BERI FLASHMSG, BACK
      $this->flashmsg('Nama kelas sudah ada!','danger');
      redirect('kelas/create','refresh');
    }
    else{
      // JIKA NAMA KELAS TIDAK ADA, BERI FLASHMSG, INDEX
      $data = [
        'nama_kelas' => $nama_kelas,
      ];

      $this->db->insert('kelas', $data);
      $this->flashmsg('Sukses menambahkan data kelas','success');
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

    // CEK JIKA NAMA KELAS SUDAH ADA
    $this->db->where('nama_kelas',$nama_kelas);
    $query = $this->db->get('kelas');
    if ($query->num_rows() > 0){
      // JIKA NAMA KELAS SUDAH ADA, BERI FLASHMSG, BACK
      $this->flashmsg('Nama kelas sudah ada!','danger');
      redirect('kelas/edit/'.$id,'refresh');
    }
    else{
      // JIKA NAMA KELAS TIDAK ADA, BERI FLASHMSG, INDEX
      $data = [
        'nama_kelas' => $nama_kelas,
      ];

      $this->db->set($data);
      $this->db->where('id', $id);
      $this->db->update('kelas');
      $this->flashmsg('Sukses edit data kelas','success');
      redirect('kelas','refresh');
    }
  }
  public function destroy($id){
    $this->db->delete('kelas', ['id' => $id]);
    $this->flashmsg('Sukses hapus data kelas','success');
    redirect('kelas','refresh');
  }
}