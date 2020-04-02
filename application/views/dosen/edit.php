  <!-- page title area start -->
  <div class="page-title-area">
    <div class="row align-items-center p-3">
      <div class="col-sm-6">
        <div class="breadcrumbs-area clearfix">
          <h4 class="page-title pull-left">Edit Dosen</h4>
          <ul class="breadcrumbs pull-left">
            <li><a href="<?= base_url() ?>">Home</a></li>
            <li><a href="<?= base_url('dosen') ?>">Dosen</a></li>
            <li><span>Edit</span></li>
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
            <form action="<?= base_url('dosen/update/'.$dosen->id) ?>" method="post" accept-charset="utf-8">
              <label for="nama">Nama Dosen</label>
              <input id="nama" type="text" name="nama" class="form-control form-group" required="" value="<?= $dosen->nama ?>">
              <label for="nip">NIP</label>
              <input id="nip" type="text" name="nip" class="form-control form-group" value="<?= $dosen->nip ?>">
              <input type="submit" class="btn btn-primary" value="Edit Dosen">
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>