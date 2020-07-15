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
            <h4 class="header-title">Data Table Default</h4>
            <div class="data-tables">
              <table id="tableClass" class="text-center">
                <thead class="bg-light text-capitalize">
                  <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Subjek</th>
                    <th>Jam Mulai</th>
                    <th>Jam Berakhir</th>
                    <th>Ruangan</th>
                    <th>Dosen</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no = 1; foreach($mata_kuliah as $key => $value) {?>
                  <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $value->kode; ?></td>
                    <td><?= $value->subjek; ?></td>
                    <td><?= $value->jam_mulai; ?></td>
                    <td><?= $value->jam_berakhir; ?></td>
                    <td><?= $value->ruangan; ?></td>
                    <td><?= $value->id_dosen; ?></td>
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