  <!-- page title area start -->
  <div class="page-title-area">
    <div class="row align-items-center p-3">
      <div class="col-sm-6">
        <div class="breadcrumbs-area clearfix">
          <h4 class="page-title pull-left">Jadwal</h4>
          <ul class="breadcrumbs pull-left">
            <li><a href="<?= base_url() ?>">Home</a></li>
            <li><a href="<?= base_url('jadwal') ?>">Jadwal</a></li>
            <li><span>Optimasi</span></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <!-- page title area end -->
  <?php  
    // $days_bukit = 
    // ['SENIN','SENIN','SENIN','SELASA','SELASA','SELASA','RABU','RABU','RABU','KAMIS','KAMIS','KAMIS','SABTU','SABTU','SABTU','JUMAT','JUMAT'];
    $days_bukit = 
['SENIN','SENIN','SENIN','SELASA','SELASA','SELASA','RABU','RABU','RABU','KAMIS','KAMIS','KAMIS','JUMAT','JUMAT','SABTU','SABTU','SABTU'];
    $days_layo = 
['SENIN','SENIN','SENIN','SELASA','SELASA','SELASA','RABU','RABU','RABU','KAMIS','KAMIS','KAMIS','JUMAT','JUMAT'];
  ?>
  <div class="main-content-inner">
    <div class="row">
      <div class="col-12 mt-5">
        <?= $this->session->flashdata('msg') ?>
        <div class="card">
          <div class="card-header">
            <h4>Jadwal Bilingual</h4>
          </div>
          <div class="card-body">
            <div class="data-tables">
              <table id="dataTable" class="text-center">
                <thead class="bg-light text-capitalize">
                  <tr>
                    <th>#</th>
                    <th>Hari</th>
                    <!-- <th>Waktu</th> -->
                    <th>Ruangan</th>
                    <th>Kode MK</th>
                    <th>Mata Kuliah</th>
                    <th>Kelas</th>
                    <th>SKS</th>
                    <th>Dosen 1</th>
                    <th>Dosen 2</th>
                    <!-- <th>Durasi</th> -->
                  </tr>
                </thead>
                <tbody>
                  <?php $no = 1; foreach($algen->pop_bukit as $key => $jam) {
                    foreach ($jam as $key2 => $data) {
                      // echo isset($data['kromosom']['id']) ;
                      if(!isset($data['kromosom']['id'])){
                        $dosen1   =  "-";
                        $dosen2   =  "-";
                        $nama_mk  =  "-";
                        $sks      =  "-";
                        $kelas    =  "-";
                        $kode_mk  =  "-";
                      }
                      else{
                        $dosen1 = $this->db->get_where('dosen', array('id' => $data['kromosom']['dosen1']))
                          ->result()[0]->nama;
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
                      $color = "";
                      if($data['fitness'] == 0)
                        $color = '#ff6961';
                      else if($data['fitness'] == 0.25)
                        $color = '#aec6cf ';
                      else if($data['fitness'] == 0.5)
                        $color = '#77dd77 ';
                  ?>
                  <!-- class="<?= $title == 'Daftar Mata Kuliah' ? 'active' : ''; ?>" -->
                  <tr>
                    <td bgcolor="<?= $color ?>"><?= $no++ ?></td>
                    <td bgcolor="<?= $color ?>"><?= $days_bukit[$key] ?></td>
                    <td bgcolor="<?= $color ?>"><?= $algen->param->bukit->kelas[$key2] ?></td>
                    <td bgcolor="<?= $color ?>"><?= $kode_mk ?></td>
                    <td bgcolor="<?= $color ?>"><?= $nama_mk ?></td>
                    <td bgcolor="<?= $color ?>"><?= $kelas ?></td>
                    <td bgcolor="<?= $color ?>"><?= $sks ?></td>
                    <td bgcolor="<?= $color ?>"><?= $dosen1 ?></td>
                    <td bgcolor="<?= $color ?>"><?= $dosen2 ?></td>
                  </tr>
                  <?php }} ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12 mt-5">
        <?= $this->session->flashdata('msg') ?>
        <div class="card">
          <div class="card-header">
            <h4>Jadwal Reguler</h4>
          </div>
          <div class="card-body">
            <div class="data-tables">
              <table id="dataTable2" class="text-center">
                <thead class="bg-light text-capitalize">
                  <tr>
                    <th>#</th>
                    <th>Hari</th>
                    <!-- <th>Waktu</th> -->
                    <th>Ruangan</th>
                    <th>Kode MK</th>
                    <th>Mata Kuliah</th>
                    <th>Kelas</th>
                    <th>SKS</th>
                    <th>Dosen 1</th>
                    <th>Dosen 2</th>
                    <!-- <th>Durasi</th> -->
                  </tr>
                </thead>
                <tbody>
                  <?php $no = 1; foreach($algen->pop_layo as $key => $jam) {
                    foreach ($jam as $key2 => $data) {
                      // echo isset($data['kromosom']['id']) ;
                      if(!isset($data['kromosom']['id'])){
                        $dosen1   =  "-";
                        $dosen2   =  "-";
                        $nama_mk  =  "-";
                        $sks      =  "-";
                        $kelas    =  "-";
                        $kode_mk  =  "-";
                      }
                      else{
                        $dosen1 = $this->db->get_where('dosen', array('id' => $data['kromosom']['dosen1']))
                          ->result()[0]->nama;
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
                      $color = "";
                      if($data['fitness'] == 0)
                        $color = '#ff6961';
                      else if($data['fitness'] == 0.25)
                        $color = '#aec6cf ';
                      else if($data['fitness'] == 0.5)
                        $color = '#77dd77 ';
                  ?>
                  <tr>
                    <td bgcolor="<?= $color ?>"><?= $no++ ?></td>
                    <td bgcolor="<?= $color ?>"><?= $days_layo[$key] ?></td>
                    <td bgcolor="<?= $color ?>"><?= $algen->param->layo->kelas[$key2] ?></td>
                    <td bgcolor="<?= $color ?>"><?= $kode_mk ?></td>
                    <td bgcolor="<?= $color ?>"><?= $nama_mk ?></td>
                    <td bgcolor="<?= $color ?>"><?= $kelas ?></td>
                    <td bgcolor="<?= $color ?>"><?= $sks ?></td>
                    <td bgcolor="<?= $color ?>"><?= $dosen1 ?></td>
                    <td bgcolor="<?= $color ?>"><?= $dosen2 ?></td>
                  </tr>
                  <?php }} ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>