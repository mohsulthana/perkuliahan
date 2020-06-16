  <!-- page title area start -->
  <div class="page-title-area">
    <div class="row align-items-center p-3">
      <div class="col-sm-6">
        <div class="breadcrumbs-area clearfix">
          <h4 class="page-title pull-left">Jadwal</h4>
          <ul class="breadcrumbs pull-left">
            <li><a href="<?= base_url() ?>">Home</a></li>
            <li><span>Jadwal</span></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <!-- page title area end -->
  <!-- <div class="main-content-inner">
    <div class="row">
      <div class="col-12 mt-5">
        <?= $this->session->flashdata('msg') ?>
        <div class="card">
          <div class="card-body">
            <a href="<?= base_url('jadwal/create') ?>" class="btn btn-primary btn-sm">Tambah Jadwal</a>
            <h4 class="header-title"></h4>

            <div class="data-tables">
              <table id="dataTable" class="text-center">
                <thead class="bg-light text-capitalize">
                  <tr>
                    <th>#</th>
                    <th>Tahun</th>
                    <th>Semester</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no = 1; foreach($jadwal as $key => $value) {?>
                  <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $value->tahun; ?></td>
                    <td><?= $value->semester; ?></td>
                    <td>
                      <a href="<?= base_url('jadwal/edit/'.$value->id) ?>" class="btn btn-primary btn-sm">Edit</a>
                      <a href="<?= base_url('jadwal/destroy/'.$value->id) ?>" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
 -->
 <?php  
  // $days_bukit = 
  //   ['SENIN','SENIN','SENIN','SELASA','SELASA','SELASA','RABU','RABU','RABU','KAMIS','KAMIS','KAMIS','SABTU','SABTU','SABTU','JUMAT','JUMAT'];
  $days_bukit = 
  ['SENIN','SENIN','SENIN','SELASA','SELASA','SELASA','RABU','RABU','RABU','KAMIS','KAMIS','KAMIS','JUMAT','JUMAT','SABTU','SABTU','SABTU'];
  $days_layo = 
  ['SENIN','SENIN','SENIN','SELASA','SELASA','SELASA','RABU','RABU','RABU','KAMIS','KAMIS','KAMIS','JUMAT','JUMAT'];
  $ignore_jam = ['JAM 8', 'JAM 10.30', 'JAM 13.30'];
  $kelas_bukit  = ['R1','R2','R3','R4'];
  $kelas_layo   = ['L1','L2','L3','L4','L5'];
 ?>
  <div class="main-content-inner">
    <div class="row">
      <div class="col-12 mt-5">
        <?= $this->session->flashdata('msg') ?>
        <div class="card">
          <div class="card-body">
            <form action="<?= base_url('jadwal/optimasi') ?>" method="post" accept-charset="utf-8">
            <div class="row">
              <div class="col-4">
                <label for="iterasi">Iterasi</label>
                <input id="iterasi" type="text" name="iterasi" class="form-control form-group" required="" value="100">
                <label for="mr">Mutation Rate</label>
                <input id="mr" type="text" name="mr" class="form-control form-group" required="" value="0.01">
                <input type="submit" class="btn btn-primary" value="Optimasi Jadwal">
                <br><br>

                <h4 class="header-title">Booking Jadwal Bilingual</h4>
                <?php
                foreach ($days_bukit as $key => $value) {
                  foreach ($kelas_bukit as $key2 => $value2) {
                ?>
                <div class="custom-control custom-checkbox">
                  <input name="ignore_bukit[]" type="checkbox" class="custom-control-input" id="<?= 'bil'.$key,$key2 ?>" 
                    value="<?= $key.','.$key2 ?>">
                  <label class="custom-control-label" for="<?= 'bil'.$key,$key2 ?>">
                    BIL <?= $value ?> | RUANG <?= $value2 ?> | <?= $ignore_jam[$key%3] ?>
                  </label>
                </div>  
                <?php }} ?>
                <br><br>
                <h4 class="header-title">Booking Jadwal Reguler</h4>
                <?php
                foreach ($days_layo as $key => $value) {
                  foreach ($kelas_layo as $key2 => $value2) {
                ?>
                <div class="custom-control custom-checkbox">
                  <input name="ignore_layo[]" type="checkbox" class="custom-control-input" id="<?= 'reg'.$key,$key2 ?>" 
                    value="<?= $key.','.$key2 ?>">
                  <label class="custom-control-label" for="<?= 'reg'.$key,$key2 ?>">
                    BIL <?= $value ?> | RUANG <?= $value2 ?> | <?= $ignore_jam[$key%3] ?>
                  </label>
                </div>  
                <?php }} ?>
                
              </div>
              <div class="col-8">
                <h4 class="header-title">List Jadwal</h4>
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" name="select-all" class="custom-control-input" id="select-all" />
                  <label class="custom-control-label" for="select-all">Select All</label>
                </div>  
                
                <?php foreach ($mk as $key => $value){ 
                  $dosen1 = $this->db->get_where('dosen', array('id' => $value->dosen1))->result()[0]->nama;
                  $kelas = $this->db->get_where('kelas', array('id' => $value->kelas))->result()[0]->nama_kelas;
                  if(is_null($value->dosen2)){
                    $dosen2 = '-';
                  }
                  else{
                    $dosen2 = $this->db->get_where('dosen', array('id' => $value->dosen2))->result()[0]->nama;
                  }
                ?>

                <div class="custom-control custom-checkbox">
                  <input name="mk[]" type="checkbox" class="custom-control-input" id="mk<?= $value->id ?>" value="<?= $value->id ?>">
                  <label class="custom-control-label" for="mk<?= $value->id ?>">
                    <?= $value->nama_mk ?> | <?= $kelas ?> | <?= $dosen1 ?> | <?= $dosen2 ?>
                  </label>
                </div>  
                <?php } ?>
                
              </div>  
              </div>
              
            </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

<script type="text/javascript" charset="utf-8" defer>
  window.onload = function() {
    if (window.jQuery) {  
        // jQuery is loaded
        $('#select-all').click(function(event) {   
          if(this.checked) {
              // Iterate each checkbox
              $('[name ="mk[]"]').each(function() {
                  this.checked = true;                        
              });
          } else {
              $('[name ="mk[]"]').each(function() {
                  this.checked = false;                       
              });
          }
      });
    } else {
        // jQuery is not loaded
        alert("Doesn't Work");
    }
  }
</script>