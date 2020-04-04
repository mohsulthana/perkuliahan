<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mk extends MY_Controller {
  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    $this->data['title']    = 'Daftar Mata Kuliah';
    $this->data['content']  = 'mk/index';
    $this->data['mk']       = $this->db->get('mk')->result();

    $this->template($this->data);
  }
  public function create(){
    $this->data['title']    = 'Tambah MK';
    $this->data['content']  = 'mk/create';
    $this->data['dosen']    = $this->db->get('dosen')->result();
    $this->data['kelas']    = $this->db->get('kelas')->result();
    $this->template($this->data);
  }
  public function store(){
    // KASIH VALIDASI
    $dosen1   = $this->POST('dosen1');
    $dosen2   = $this->POST('dosen2');
    $kelas    = $this->POST('kelas');
    $nama_mk  = strtoupper($this->POST('nama_mk'));
    $sks      = $this->POST('sks');
    $kode_mk  = strtoupper($this->POST('kode_mk'));
    $lokasi   = $this->POST('lokasi');

    if ($dosen2 === '') {
      $dosen2 = NULL;
    }
    // CEK JIKA KODE MK PADA KELAS TERSEBUT SUDAH ADA
    $this->db->where('kode_mk',$kode_mk);
    $this->db->where('kelas',$kelas);
    $query = $this->db->get('mk');
    if ($query->num_rows() > 0){
      // JIKA SUDAH ADA, BERI FLASHMSG, BACK
      $this->flashmsg('Kode MK untuk kelas tersebut sudah ada!','danger');
      redirect('mk/create','refresh');
    }
    else{
      // JIKA TIDAK ADA, BERI FLASHMSG, INDEX
      $data = [
        'dosen1'  => $dosen1,
        'dosen2'  => $dosen2,
        'kelas'   => $kelas,
        'nama_mk' => $nama_mk,
        'sks'     => $sks,
        'kode_mk' => $kode_mk,
        'lokasi'  => $lokasi,
      ];

      $this->db->insert('mk', $data);
      $this->flashmsg('Sukses menambahkan data MK','success');
      redirect('mk','refresh');
    }
  }
  public function edit($id){

    $this->data['title']    = 'Edit Dosen';
    $this->data['content']  = 'mk/edit';
    $this->data['dosen']    = $this->db->get('dosen')->result();
    $this->data['kelas']    = $this->db->get('kelas')->result();

    $this->db->where('id',$id);
    $this->data['mk'] = $this->db->get('mk')->result()[0];
    // echo "<pre>";
    // print_r ($this->data['mk']);
    // echo "</pre>";exit;
    $this->template($this->data);
  }
  public function update($id){
    $dosen1   = $this->POST('dosen1');
    $dosen2   = $this->POST('dosen2');
    $kelas    = $this->POST('kelas');
    $nama_mk  = strtoupper($this->POST('nama_mk'));
    $sks      = $this->POST('sks');
    $kode_mk  = strtoupper($this->POST('kode_mk'));
    $lokasi   = $this->POST('lokasi');

    if ($dosen2 === '') {
      $dosen2 = NULL;
    }
    // CEK JIKA KODE MK PADA KELAS TERSEBUT SUDAH ADA
    $this->db->where('kode_mk',$kode_mk);
    $this->db->where('kelas',$kelas);
    $query = $this->db->get('mk');
    if ($query->num_rows() > 0){
      // JIKA SUDAH ADA, BERI FLASHMSG, BACK
      $this->flashmsg('Kode MK untuk kelas tersebut sudah ada!','danger');
      redirect('mk/edit/'.$id,'refresh');
    }
    else{
      // JIKA TIDAK ADA, BERI FLASHMSG, INDEX
      $data = [
        'dosen1'  => $dosen1,
        'dosen2'  => $dosen2,
        'kelas'   => $kelas,
        'nama_mk' => $nama_mk,
        'sks'     => $sks,
        'kode_mk' => $kode_mk,
        'lokasi'  => $lokasi,
      ];

      $this->db->set($data);
      $this->db->where('id', $id);
      $this->db->update('mk');
      $this->flashmsg('Sukses edit data MK','success');
      redirect('mk','refresh');
    }
  }
  public function destroy($id){
    $this->db->delete('mk', ['id' => $id]);
    $this->flashmsg('Sukses hapus data MK','success');
    redirect('mk','refresh');
  }
}