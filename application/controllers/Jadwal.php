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
    $this->data['bukit'] = $this->db->where('kampus', 'bukit')->where('id_trx', $id)->get('jadwal')->result_array();
    $this->data['layo'] = $this->db->where('kampus', 'layo')->where('id_trx', $id)->get('jadwal')->result_array();
    // $this->dump($this->data['layo']); exit;

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

    $this->data['jadwal'] = $this->db->get_where('jadwal', ['jadwal.id' => $id])->result()[0];
    // $this->dump($this->data['jadwal']); exit;

    $this->data['title']    = 'Edit Jadwal';
    $this->data['content']  = 'jadwal/edit';
    $this->template($this->data);
  }

  public function storeUpdate($id, $id_trx)
  {
    $kelas = $this->POST('kelas');
    $mk = $this->POST('mk');
    $sks = $this->POST('sks');
    $dosen1   = $this->POST('dosen1');
    $dosen2   = $this->POST('dosen2');
    $kode_mk   = $this->POST('kode_mk');
    $hari   = $this->POST('hari');

    $data = [
      'kelas' => $kelas,
      'mk'	=> $mk,
      'sks'	=> $sks,
      'dosen2'	=> $dosen2,
      'dosen1'  => $dosen1,
      'hari'  => $hari,
      'kode_mk' => $kode_mk
    ];

    $query = $this->db->where('id',$id)->update('jadwal', $data);

    if ($this->db->affected_rows() > 0) {
      $this->flashmsg('Jadwal ' . $mk . ' berhasil diperbaharui', 'success');
      redirect('jadwal/jadwal_list/' . $id_trx, 'refresh');
    } else {
      $this->flashmsg('Jadwal ' . $mk . ' gagal diperbaharui', 'danger');
      redirect('jadwal/jadwal_list/' . $id_trx, 'refresh');
    }
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
    else {
      $algen = $this->M_jadwal->algen($param);


      $this->data['algen'] = $algen;

      $data_layo = [];
      $data_bukit = [];
      $days_bukit =
['SENIN','SENIN','SENIN','SELASA','SELASA','SELASA','RABU','RABU','RABU','KAMIS','KAMIS','KAMIS','JUMAT','JUMAT','SABTU','SABTU','SABTU'];
    $days_layo =
['SENIN','SENIN','SENIN','SELASA','SELASA','SELASA','RABU','RABU','RABU','KAMIS','KAMIS','KAMIS','JUMAT','JUMAT'];
      // SAVE BUKIT
      $trx = [
        'tanggal' => Date('Y-m-d'),
        'th_ajaran' => Date('Y')
      ];
      $this->db->insert('trx', $trx);
      $id_trx = $this->db->insert_id();
      $this->data['id_trx']    = $id_trx;

      foreach($algen->pop_bukit as $key => $jam) {
        foreach ($jam as $key2 => $data) {
          if(!isset($data['kromosom']['id'])){
            $dosen1   =  null;
            $dosen2   =  null;
            $nama_mk  =  null;
            $kampus =  null;
            $sks      =  null;
            $kelas    =  null;
            $kode_mk  =  null;
          }
          else{
            $dosen1 = $this->db->get_where('dosen', array('id' => $data['kromosom']['dosen1']))
              ->result()[0]->nama;
            $nama_mk  = $data['kromosom']['nama_mk'];
            $sks      = $data['kromosom']['sks'];
            $kelas = $this->db->get_where('kelas', array('id' => $data['kromosom']['kelas']))
              ->result()[0]->nama_kelas;
            $kode_mk  = $data['kromosom']['kode_mk'];
            $kampus      = 'bukit';
            if(is_null($data['kromosom']['dosen2']))
              $dosen2 = '-';
            else
              $dosen2 = $this->db->get_where('dosen', array('id' => $data['kromosom']['dosen2']))
                ->result()[0]->nama;
          }
          $data_bukit[] = [
            'dosen1'  => $dosen1,
            'dosen2'  => $dosen2,
            'mk'      => $nama_mk,
            'kode_mk' => $kode_mk,
            'kelas'   => $kelas,
            'sks'     => $sks,
            'kampus'  => 'bukit',
            'hari'    => $days_bukit[$key],
            'ruangan' => $algen->param->bukit->kelas[$key2],
            'id_trx'  => $id_trx,
          ];
        }
      }

      // SAVE LAYO
      foreach($algen->pop_layo as $key => $jam) {
        foreach ($jam as $key2 => $data) {
          if(!isset($data['kromosom']['id'])){
            $dosen1   =  null;
            $dosen2   =  null;
            $nama_mk  =  null;
            $sks      =  null;
            $kelas    =  null;
            $kampus =  null;
            $kode_mk  =  null;
          }
          else{
            $dosen1 = $this->db->get_where('dosen', array('id' => $data['kromosom']['dosen1']))
              ->result()[0]->nama;
            $kampus = 'layo';
            $nama_mk  = $data['kromosom']['nama_mk'];
            $sks      = $data['kromosom']['sks'];
            $kelas = $this->db->get_where('kelas', array('id' => $data['kromosom']['kelas']))
              ->result()[0]->nama_kelas;
            $kode_mk  = $data['kromosom']['kode_mk'];

            if(is_null($data['kromosom']['dosen2']))
              $dosen2 = '-';
            else
              $dosen2 = $this->db->get_where('dosen', array('id' => $data['kromosom']['dosen2']))
                ->result()[0]->nama;
          }
          $data_layo[] = [
            'dosen1'  => $dosen1,
            'dosen2'  => $dosen2,
            'mk'      => $nama_mk,
            'kode_mk' => $kode_mk,
            'kelas'   => $kelas,
            'kampus'  => 'layo',
            'sks'     => $sks,
            'hari'    => $days_layo[$key],
            'ruangan' => $algen->param->layo->kelas[$key2],
            'id_trx'  => $id_trx,
          ];
        }
      }
      // $this->dump($data_layo); exit;

      for ($i = 0; $i < count($data_layo); $i++) {
        $this->db->insert('jadwal', $data_layo[$i]);
      }
      for ($i = 0; $i < count($data_bukit); $i++) {
        $this->db->insert('jadwal', $data_bukit[$i]);
      }

      $this->data['title']    = 'Optimasi';
      $this->data['content']  = 'jadwal/output';

      if($algen->count == $iterasi) {
        $this->flashmsg('Jadwal gagal dioptimasi, '.$algen->tabrakan_hari_jam.' tabrakan hari & jam, '.$algen->tabrakan_hari.' tabrakan hari, '.$algen->tabrakan_jam.' tabrakan jam','danger');
      } else {
        $this->flashmsg('Jadwal berhasil dioptimasi dengan '.$algen->count.' iterasi','success');
        $this->template($this->data);
      }
    }
  }
}
