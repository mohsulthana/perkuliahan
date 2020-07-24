  <!-- page title area start -->
  <div class="page-title-area">
    <div class="row align-items-center p-3">
      <div class="col-sm-6">
        <div class="breadcrumbs-area clearfix">
          <h4 class="page-title pull-left">Dosen</h4>
          <ul class="breadcrumbs pull-left">
            <li><a href="<?= base_url() ?>">Home</a></li>
            <li><span>Dosen</span></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <!-- page title area end -->
  <div class="main-content-inner">
    <div class="row">
      <div class="col-12 mt-5">
        <?= $this->session->flashdata('msg') ?>
        <div class="card">
          <div class="card-body">
            <a href="<?= base_url('dosen/create') ?>" class="btn btn-primary btn-sm">Tambah Dosen</a>
            <h4 class="header-title"></h4>

            <div class="data-tables">
              <table id="tableClass" class="text-center">
                <thead class="bg-light text-capitalize">
                  <tr>
                    <th>No</th>
                    <th>ID Jadwal</th>
                    <th>Tanggal</th>
                    <th>Tahun Ajaran</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no = 1; foreach($data as $key => $value) {?>
                  <tr>
                    <td><?= $no++; ?></td>
                    <td><a href="<?= base_url('jadwal/jadwal_list/' . $value['id']);?>">Nomor ID <?= $value['id']; ?></a></td>
                    <td><?= $value['tanggal']; ?></td>
                    <td><?= $value['th_ajaran']; ?></td>
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