<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jadwal extends MY_Controller {
	
  public function __construct(){
		parent::__construct();
	}

	public function index(){
		$this->data['title']		= 'Buat Jadwal';
		$this->data['content']	= 'jadwal/index';
		$this->data['jadwal']	  = $this->db->get('jadwal')->result();
		$this->template($this->data);
	}
  public function create(){
    $this->data['title']    = 'Tambah Jadwal';
    $this->data['content']  = 'jadwal/create';
    $this->template($this->data);
  }
  public function store(){
    $tahun     = $this->input->post('tahun');
    $semester  = $this->input->post('semester');

    // CEK APAKAH NAMA SUDAH ADA
    $this->db->where('tahun',$tahun);
    $this->db->where('semester',$semester);
    $query = $this->db->get('jadwal');

    if ($query->num_rows() > 0){
      // JIKA NAMA SUDAH ADA, BERI FLASHMSG, GO BACK
      $this->flashmsg('Jadwal sudah ada!','danger');
      redirect('jadwal/create','refresh');
    }
    else{
      // JIKA NAMA TIDAK ADA, BERI FLASHMSG, GO TO INDEX
      $data = [
        'tahun' => $tahun,
        'semester'  => $semester,
      ];

      $this->db->insert('jadwal', $data);
      $this->flashmsg('Sukses menambahkan data jadwal','success');
      redirect('jadwal/index','refresh');
    }
  }
  public function edit($id){

    $this->db->where('id',$id);
    $this->data['jadwal'] = $this->db->get('jadwal')->result()[0];

    $this->data['title']    = 'Edit Dosen';
    $this->data['content']  = 'jadwal/edit';
    $this->template($this->data);
  }
  public function update($id){
    $tahun     = $this->input->post('tahun');
    $semester  = $this->input->post('semester');

    // CEK APAKAH NAMA SUDAH ADA
    $this->db->where('tahun',$tahun);
    $this->db->where('semester',$semester);
    $query = $this->db->get('jadwal');

    if ($query->num_rows() > 0){
      // JIKA NAMA SUDAH ADA, BERI FLASHMSG, GO BACK
      $this->flashmsg('Jadwal sudah ada!','danger');
      redirect('jadwal/edit/'.$id,'refresh');
    }
    else{
      // JIKA NAMA TIDAK ADA, BERI FLASHMSG, GO TO INDEX
      $data = [
        'tahun' => $tahun,
        'semester'  => $semester,
      ];

      $this->db->set($data);
      $this->db->where('id', $id);
      $this->db->update('jadwal');
      $this->flashmsg('Sukses edit data jadwal','success');
      redirect('jadwal','refresh');
    }
    
  }
  public function destroy($id){
    $this->db->delete('jadwal', ['id' => $id]);
    $this->flashmsg('Sukses menghapus data jadwal','success');
    redirect('jadwal','refresh');
  }
}
