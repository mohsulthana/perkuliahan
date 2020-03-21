  <!-- page title area start -->
  <div class="page-title-area">
    <div class="row align-items-center p-3">
      <div class="col-sm-6">
        <div class="breadcrumbs-area clearfix">
          <h4 class="page-title pull-left">Dosen</h4>
          <ul class="breadcrumbs pull-left">
            <li><a href="index.html">Home</a></li>
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
        <div class="card">
          <div class="card-body">
            <h4 class="header-title">Data Table Default</h4>
            <div class="data-tables">
              <table id="dataTable" class="text-center">
                <thead class="bg-light text-capitalize">
                  <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>NIM</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no = 1; foreach($mahasiswa as $key => $value) {?>
                  <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $value->nama; ?></td>
                    <td><?= $value->nim; ?></td>
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