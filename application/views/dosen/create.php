  <!-- page title area start -->
  <div class="page-title-area">
    <div class="row align-items-center p-3">
      <div class="col-sm-6">
        <div class="breadcrumbs-area clearfix">
          <h4 class="page-title pull-left">Tambah Dosen</h4>
          <ul class="breadcrumbs pull-left">
            <li><a href="<?= base_url() ?>">Home</a></li>
            <li><a href="<?= base_url('dosen') ?>">Dosen</a></li>
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
            <form action="<?= base_url('dosen/store') ?>" method="post" accept-charset="utf-8">
              <label for="nama">Nama Dosen</label>
              <input id="nama" type="text" name="nama" class="form-control form-group" required="">
              <label for="nip">NIP</label>
              <input id="nip" type="text" name="nip" class="form-control form-group">
              <input type="submit" class="btn btn-primary" value="Tambah Dosen">
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>