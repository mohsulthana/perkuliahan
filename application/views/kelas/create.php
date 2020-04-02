  <!-- page title area start -->
  <div class="page-title-area">
    <div class="row align-items-center p-3">
      <div class="col-sm-6">
        <div class="breadcrumbs-area clearfix">
          <h4 class="page-title pull-left">Tambah Kelas</h4>
          <ul class="breadcrumbs pull-left">
            <li><a href="<?= base_url() ?>">Home</a></li>
            <li><a href="<?= base_url('kelas') ?>">Kelas</a></li>
            <li><span>Create</span></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <!-- page title area end -->

  <div class="main-content-inner">
    <div class="row">
      <div class="col-6 mt-5">
        <div class="card">
          <div class="card-body">
            <form action="<?= base_url('kelas/store') ?>" method="post" accept-charset="utf-8">
              <label for="nama_kelas">Nama Kelas</label>
              <input id="nama_kelas" type="text" name="nama_kelas" class="form-control form-group" required="">

              <input type="submit" class="btn btn-primary" value="Tambah Kelas">
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>