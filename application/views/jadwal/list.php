  <!-- page title area start -->
  <div class="page-title-area">
    <div class="row align-items-center p-3">
      <div class="col-sm-6">
        <div class="breadcrumbs-area clearfix">
          <h4 class="page-title pull-left">Jadwal</h4>
          <ul class="breadcrumbs pull-left">
            <li><a href="<?= base_url() ?>">Home</a></li>
            <li><a href="<?= base_url('jadwal') ?>">Jadwal</a></li>
            <li><span>Hasil Optimasi</span></li>
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
              <table id="tableClass" class="text-center">
                <thead class="bg-light text-capitalize">
                    <tr>
                      <th>#</th>
                      <th>Hari</th>
                      <th>Waktu</th>
                      <th>Ruangan</th>
                      <th>Kode MK</th>
                      <th>Mata Kuliah</th>
                      <th>Kelas</th>
                      <th>SKS</th>
                      <th>Dosen 1</th>
                      <th>Dosen 2</th>
                      <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                  <?php $no = 1; foreach($bukit as $key => $value) {?>
                    <tr>
                      <td><?= $no++; ?></td>
                      <td><?= is_null($value['hari']) ? '-' : $value['hari']; ?></td>
                      <td><?= is_null($value['jam']) ? '-' : $value['jam']; ?> </td>
                      <td><?= is_null($value['ruangan']) ? '-' : $value['ruangan']; ?></td>
                      <td><?= is_null($value['kode_mk']) ? '-' : $value['kode_mk']; ?></td>
                      <td><?= is_null($value['mk']) ? '-' : $value['mk']; ?></td>
                      <td><?= is_null($value['kelas']) ? '-' : $value['kelas']; ?></td>
                      <td><?= is_null($value['sks']) ? '-' : $value['sks']; ?></td>
                      <td><?= is_null($value['dosen1']) ? '-' : $value['dosen1']; ?></td>
                      <td><?= is_null($value['dosen2']) ? '-' : $value['dosen2']; ?></td>
                      <td>
                        <a href="<?= base_url('jadwal/edit/' . $value['id'] . '/' . $this->uri->segment(3));?>" class="btn btn-primary btn-sm">Edit</a>
                        <a href="<?= base_url('jadwal/destroy/' . $value['id']);?>" class="btn btn-danger btn-sm">Delete</a>
                      </td>
                    </tr>
                  <?php }; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12 mt-5">
        <div class="card">
          <div class="card-header">
            <h4>Jadwal Reguler</h4>
          </div>
          <div class="card-body">
            <div class="data-tables">
              <table id="tableClass2" class="text-center">
                <thead class="bg-light text-capitalize">
                    <tr>
                      <th>#</th>
                      <th>Hari</th>
                      <th>Waktu</th>
                      <th>Ruangan</th>
                      <th>Kode MK</th>
                      <th>Mata Kuliah</th>
                      <th>Kelas</th>
                      <th>SKS</th>
                      <th>Dosen 1</th>
                      <th>Dosen 2</th>
                      <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                  <?php $no = 1; foreach($layo as $key => $value) {?>
                    <tr>
                      <td><?= $no++; ?></td>
                      <td><?= is_null($value['hari']) ? '-' : $value['hari']; ?></td>
                      <td><?= is_null($value['jam']) ? '-' : $value['jam']; ?></td>
                      <td><?= is_null($value['ruangan']) ? '-' : $value['ruangan']; ?></td>
                      <td><?= is_null($value['kode_mk']) ? '-' : $value['kode_mk']; ?></td>
                      <td><?= is_null($value['mk']) ? '-' : $value['mk']; ?></td>
                      <td><?= is_null($value['kelas']) ? '-' : $value['kelas']; ?></td>
                      <td><?= is_null($value['sks']) ? '-' : $value['sks']; ?></td>
                      <td><?= is_null($value['dosen1']) ? '-' : $value['dosen1']; ?></td>
                      <td><?= is_null($value['dosen2']) ? '-' : $value['dosen2']; ?></td>
                      <td>
                        <a href="<?= base_url('jadwal/edit/' . $value['id'] . '/' . $this->uri->segment(3));?>" class="btn btn-primary btn-sm">Edit</a>
                        <a href="<?= base_url('jadwal/destroy/' . $value['id']);?>" class="btn btn-danger btn-sm">Delete</a>
                      </td>
                    </tr>
                  <?php }; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="confirm_delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Hapus Jadwal
            </div>
            <div class="modal-body">
                    <input type="text" name="jadwalId" id="jadwalId" value="">
                <p>Apa Anda yakin ingin menghapus jadwal ini?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok">Delete</a>
            </div>
        </div>
    </div>
</div>