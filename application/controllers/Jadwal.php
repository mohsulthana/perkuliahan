<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jadwal extends MY_Controller {

  public function __construct(){
		parent::__construct();
    $this->load->model('M_jadwal');
	}

	public function index(){
		$this->data['title']		= 'Buat Jadwal';
		$this->data['content']	= 'jadwal/index';
		$this->data['jadwal']   = $this->db->get('jadwal')->result();
    $this->data['mk']       = $this->db->get('mk')->result();

		$this->template($this->data);
  }

  public function jadwal_list($id)
  {
    $this->data['title']		= 'Daftar Jadwal';
    $this->data['content']	= 'jadwal/list';
    $this->data['bukit'] = $this->db->get_where('jadwal', ['kelas' => 'bukit', 'id_trx' => $id])->result_array();
    $this->data['layo'] = $this->db->get_where('jadwal', ['kelas' => 'layo', 'id_trx' => $id])->result_array();

		$this->template($this->data);
  }

  public function list_id()
  {
    $this->data['title']		= 'Daftar Jadwal';
    $this->data['content']	= 'jadwal/list_id';
    $this->data['data']     = $this->db->get('trx')->result_array();

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

    $this->data['jadwal'] = $this->db->join('dosen', 'dosen.id = jadwal.dosen1 OR dosen.id = jadwal.dosen2')->get_where('jadwal', ['jadwal.id' => $id])->result()[0];
    // $this->dump($this->data['jadwal']); exit;

    $this->data['title']    = 'Edit Jadwal';
    $this->data['content']  = 'jadwal/edit';
    $this->template($this->data);
  }

  public function storeUpdate()
  {
    $nama = $this->POST('nama');
    $kelas = $this->POST('kelas');
    $mk = $this->POST('mk');
    $sks = $this->POST('sks');
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
  public function optimasi(){
    $iterasi  = $this->input->post('iterasi');
    $mr       = $this->input->post('mr');
    $mk       = $this->input->post('mk');
    $ignore_bukit   = $this->input->post('ignore_bukit');
    $ignore_layo   = $this->input->post('ignore_layo');
    $total_mk = $this->db->get('mk')->result_array();
    $kelas_bukit  = ['R1','R2','R3','R4'];
    $kelas_layo   = ['L1','L2','L3','L4','L5'];
    $jam_bukit  = 17;
    $jam_layo   = 14;

    if(!isset($mk)){
      $this->flashmsg('Mata kuliah belum dipilih','danger');
      redirect('jadwal','refresh');
    }

    // KODE
    // 0 = BUKIT
    // 1 = INDERALAYA
    $jadwal_bukit = [];
    $jadwal_layo = [];

    foreach ($mk as $key => $value) {
      foreach ($total_mk as $key2 => $value2) {
        if($value === $value2['id'] && $value2['lokasi'] == 0)
          $jadwal_bukit[] = $value2;
        if($value === $value2['id'] && $value2['lokasi'] == 1)
          $jadwal_layo[] = $value2;
      }
    }

    $kosong_bukit = $jam_bukit*count($kelas_bukit) - count($jadwal_bukit);
    $kosong_layo  = $jam_layo*count($kelas_layo) - count($jadwal_layo);

    if(!isset($ignore_bukit))
      $ignore_bukit = [];
    if(!isset($ignore_layo))
      $ignore_layo = [];
    if(count($ignore_bukit)>$kosong_bukit || count($ignore_layo)>$kosong_layo){
      $this->flashmsg('Booking melebihi batas wajar','danger');
      redirect('jadwal','refresh');
    }

    if(isset($ignore_bukit)){
      foreach ($ignore_bukit as $key => $value)
        $ignore_bukit[$key] = explode(',', $value);

      foreach ($ignore_bukit as $key => $value)
        foreach ($value as $key2 => $value2)
          $ignore_bukit[$key][$key2] = (int) $value2;
    }

    if(isset($ignore_layo)){
      foreach ($ignore_layo as $key => $value)
        $ignore_layo[$key] = explode(',', $value);

      foreach ($ignore_layo as $key => $value)
        foreach ($value as $key2 => $value2)
          $ignore_layo[$key][$key2] = (int) $value2;
    }

    // BEGIN PARAMETER ALGEN
    $param        = (Object)[];
    $param->bukit = (Object)[];
    $param->layo  = (Object)[];

    $param->bukit->kelas  = $kelas_bukit;
    $param->layo->kelas   = $kelas_layo;

    $param->bukit->hari   = 2;//6;
    $param->layo->hari    = 2;//5;

    $param->bukit->total_jam  = $jam_bukit;
    $param->layo->total_jam   = $jam_layo;

    $param->bukit->jadwal   = $jadwal_bukit;
    $param->layo->jadwal    = $jadwal_layo;

    $param->jam = 3;

    $param->ignore_bukit  = $ignore_bukit;
    $param->ignore_layo   = $ignore_layo;

    $param->maxGen = $iterasi;
    $param->mr     = $mr;
    $available_bukit = count($param->bukit->kelas) * $param->bukit->total_jam;
    $available_layo = count($param->layo->kelas) * $param->layo->total_jam;

    // JIKA BERLEBIH, MAKA TIDAK BISA OPTIMASI
    if(count($jadwal_bukit)>$available_bukit || count($jadwal_layo) > $available_layo){
    $this->flashmsg('Optimasi gagal, jadwal melebihi batas hari!','danger');
    redirect('jadwal','refresh');

    // echo "JADWAL BERLEBIHAN, TIDAK BISA DILAKUKAN OPTIMASI!<br>";
    // echo "TOTAL JADWAL BUKIT: ".count($jadwal_bukit)."<br>";
    // echo "TOTAL AVAILABLE BUKIT: ".$available_bukit."<br>";

    // echo "TOTAL JADWAL INDERALAYA: ".count($jadwal_layo)."<br>";
    // echo "TOTAL AVAILABLE INDERALAYA: ".$available_layo."<br>";
  }
    // LAKUKAN OPTIMASI
    else{
      $algen = $this->M_jadwal->algen($param);

      $bukit = $algen->param->bukit;
      $layo = $algen->param->layo;

      // insert data trx ke Database
      $trx = [
        'tanggal' => date('d'),
        'th_ajaran' => date("Y")
      ];
      $this->db->insert('trx', $trx);
      $id_trx = $this->db->insert_id();
      $algen->id_trx = $id_trx;

      $data_bukit = [];
      for($i = 0; $i < count((array)$bukit->jadwal); $i++) {
        $data_bukit['dosen1'] = $bukit->jadwal[$i]['dosen1'];
        $data_bukit['dosen2'] = $bukit->jadwal[$i]['dosen2'];
        $data_bukit['mk'] = $bukit->jadwal[$i]['nama_mk'];
        $data_bukit['ruangan'] = $bukit->jadwal[$i]['kelas'];
        $data_bukit['sks'] = $bukit->jadwal[$i]['sks'];
        $data_bukit['hari'] = (string)$bukit->hari;
        $data_bukit['kode_mk'] = $bukit->jadwal[$i]['kode_mk'];
        $data_bukit['kelas']  = 'bukit';
        $data_bukit['id_trx'] = $id_trx;
        $this->db->insert('jadwal', $data_bukit);
      }

      $data_layo = [];
      for($i = 0; $i < count((array)$layo->jadwal); $i++) {
        $data_layo['dosen1'] = $layo->jadwal[$i]['dosen1'];
        $data_layo['dosen2'] = $layo->jadwal[$i]['dosen2'];
        $data_layo['mk'] = $layo->jadwal[$i]['nama_mk'];
        $data_layo['ruangan'] = $layo->jadwal[$i]['kelas'];
        $data_layo['sks'] = $layo->jadwal[$i]['sks'];
        $data_layo['hari'] = (string)$layo->hari;
        $data_layo['kode_mk'] = $layo->jadwal[$i]['kode_mk'];
        $data_layo['kelas']  = 'layo';
        $data_layo['id_trx'] = $id_trx;
        $this->db->insert('jadwal', $data_layo);
      }

      $this->data['algen'] = $algen;

      $this->data['title']    = 'Optimasi';
      $this->data['content']  = 'jadwal/output';

      if($algen->count == $iterasi)
        $this->flashmsg('Jadwal gagal dioptimasi, '.$algen->tabrakan_hari_jam.' tabrakan hari & jam, '.$algen->tabrakan_hari.' tabrakan hari, '.$algen->tabrakan_jam.' tabrakan jam','danger');
      else
        $this->flashmsg('Jadwal berhasil dioptimasi dengan '.$algen->count.' iterasi','success');
        $this->template($this->data);
    }
  }
}
