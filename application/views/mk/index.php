  <!-- page title area start -->
  <div class="page-title-area">
    <div class="row align-items-center p-3">
      <div class="col-sm-6">
        <div class="breadcrumbs-area clearfix">
          <h4 class="page-title pull-left">Mata Kuliah</h4>
          <ul class="breadcrumbs pull-left">
            <li><a href="index.html">Home</a></li>
            <li><span>Mata Kuliah</span></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <!-- page title area end -->

  <div class="main-content-inner">
    <div class="row">
      <div class="col-12 mt-5">
        <div class="card">
          <div class="card-body">
            <a href="<?= base_url('mk/create') ?>" class="btn btn-primary btn-sm">Tambah MK</a>
            <h4 class="header-title"></h4>

            <div class="data-tables">
              <table id="dataTable" class="text-center">
                <thead class="bg-light text-capitalize">
                  <tr>
                    <th>#</th>
                    <th>Dosen 1</th>
                    <th>Dosen 2</th>
                    <th>Nama MK</th>
                    <th>SKS</th>
                    <th>Kelas</th>
                    <th>Kode MK</th>
                    <th>Lokasi</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  $no = 1; 
                  $tempat = ['BILINGUAL','INDERALAYA'];
                  foreach($mk as $key => $value) {
                  $dosen1 = $this->db->get_where('dosen', array('id' => $value->dosen1))->result()[0]->nama;
                  $dosen2 = $this->db->get_where('dosen', array('id' => $value->dosen2))->result()[0]->nama;
                  $kelas = $this->db->get_where('kelas', array('id' => $value->kelas))->result()[0]->nama_kelas;

                  ?>
                  <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $dosen1 ?></td>
                    <td><?= $dosen2 ?></td>
                    <td><?= $value->nama_mk ?></td>
                    <td><?= $value->sks ?></td>
                    <td><?= $kelas ?></td>
                    <td><?= $value->kode_mk ?></td>
                    <td><?= $tempat[$value->lokasi] ?></td>
                    <td>
                      <a href="<?= base_url('mk/edit/'.$value->id) ?>" class="btn btn-primary btn-sm">Edit</a>
                      <a href="<?= base_url('mk/destroy/'.$value->id) ?>" class="btn btn-danger btn-sm">Delete</a>
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