  <!-- page title area start -->
  <div class="page-title-area">
    <div class="row align-items-center p-3">
      <div class="col-sm-6">
        <div class="breadcrumbs-area clearfix">
          <h4 class="page-title pull-left">Edit Jadwal</h4>
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
            <form action="<?= base_url('jadwal/storeUpdate/'.$jadwal->id . '/' . $this->uri->segment(4)) ?>" method="post" accept-charset="utf-8">
              <label for="dosen1">Dosen 1</label>
              <select name="dosen1" id="dosen1" class="form-control">
                <option value="<?= $jadwal->dosen1; ?>"><?= $jadwal->dosen1 ?></option>
                <?php foreach($dosen as $key => $value) { ?>
                  <option value="<?= $value->nama; ?>"><?= $value->nama; ?></option>
                <?php } ?>
              </select>
              <label for="dosen2">Dosen 2</label>
              <select name="dosen2" id="dosen2" class="form-control">
                <option value="<?= $jadwal->dosen2; ?>"><?= $jadwal->dosen2 ?></option>
                <?php foreach($dosen as $key => $value) { ?>
                  <option value="<?= $value->nama; ?>"><?= $value->nama; ?></option>
                <?php } ?>
              </select>
              <label for="kelas">Kelas</label>
              <select name="kelas" id="kelas" class="form-control">
                <option value="<?= $jadwal->kelas; ?>"><?= $jadwal->kelas ?></option>
                <?php foreach($kelas as $key => $value) { ?>
                  <option value="<?= $value->nama_kelas; ?>"><?= $value->nama_kelas; ?></option>
                <?php } ?>
              </select>
              <label for="kode_mk">Kode MK</label>
              <input id="kode_mk" type="text" name="kode_mk" class="form-control form-group" value="<?= $jadwal->kode_mk ?>">
              <label for="ruangan">Ruangan</label>
              <input id="ruangan" type="text" name="ruangan" class="form-control form-group" value="<?= $jadwal->ruangan ?>">
              <label for="mk">Mata Kuliah</label>
              <input id="mk" type="text" name="mk" class="form-control form-group" value="<?= $jadwal->mk ?>">
              <label for="sks">SKS</label>
              <input id="sks" type="text" name="sks" class="form-control form-group" value="<?= $jadwal->sks ?>">
              <label for="hari">Hari</label>
              <input id="hari" type="text" name="hari" class="form-control form-group" value="<?= $jadwal->hari ?>">
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