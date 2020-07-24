  <!-- page title area start -->
  <div class="page-title-area">
    <div class="row align-items-center p-3">
      <div class="col-sm-6">
        <div class="breadcrumbs-area clearfix">
          <h4 class="page-title pull-left">Tambah Jadwal</h4>
          <ul class="breadcrumbs pull-left">
            <li><a href="<?= base_url() ?>">Home</a></li>
            <li><a href="<?= base_url('jadwal') ?>">Jadwal</a></li>
            <li><span>Edit</span></li>
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
            <form action="<?= base_url('jadwal/update/'.$jadwal->id) ?>" method="post" accept-charset="utf-8">
              <label for="nama">Nama Dosen</label>
              <input id="nama" type="text" name="nama" class="form-control form-group" required="" value="<?= $jadwal->nama ?>">
              <label for="kelas">Kelas</label>
              <input id="kelas" type="text" name="kelas" class="form-control form-group" required="" value="<?= $jadwal->kelas ?>">
              <label for="mk">Mata Kuliah</label>
              <input id="mk" type="text" name="mk" class="form-control form-group" required="" value="<?= $jadwal->mk ?>">
              <label for="sks">SKS</label>
              <input id="sks" type="text" name="sks" class="form-control form-group" required="" value="<?= $jadwal->sks ?>">
              <label for="hari">Hari</label>
              <input id="hari" type="text" name="hari" class="form-control form-group" required="" value="<?= $jadwal->hari ?>">
              <input type="submit" class="btn btn-primary" value="Update Jadwal">
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
        $("#semester option[value='<?= $jadwal->semester ?>']").attr('selected', 'selected');
    } else {
        // jQuery is not loaded
        alert("Doesn't Work");
    }
  }
</script>