  <!-- page title area start -->
  <div class="page-title-area">
    <div class="row align-items-center p-3">
      <div class="col-sm-6">
        <div class="breadcrumbs-area clearfix">
          <h4 class="page-title pull-left">Tambah Jadwal</h4>
          <ul class="breadcrumbs pull-left">
            <li><a href="<?= base_url() ?>">Home</a></li>
            <li><a href="<?= base_url('jadwal') ?>">Jadwal</a></li>
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
        <?= $this->session->flashdata('msg') ?>
        <div class="card">
          <div class="card-body">
            <form action="<?= base_url('jadwal/update/'.$jadwal->id) ?>" method="post" accept-charset="utf-8">
              <label for="tahun">Tahun</label>
              <input id="tahun" type="text" name="tahun" class="form-control form-group" required="" value="<?= $jadwal->tahun ?>">
              <label for="semester">Semester</label>
              <select id="semester" name="semester" class="form-control form-group" required="">
                <option value=""></option>
                <option value="GANJIL">GANJIL</option>
                <option value="GENAP">GENAP</option>
              </select>
              <input type="submit" class="btn btn-primary" value="Tambah Jadwal">
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