<body>
  <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
  <!-- preloader area start -->
  <div id="preloader">
    <div class="loader"></div>
  </div>
  <!-- preloader area end -->
  <!-- page container area start -->
  <div class="page-container">
    <!-- sidebar menu area start -->
    <div class="sidebar-menu">
      <!-- <div class="sidebar-header">
        <div class="logo">
          <a href="index.html"><img src="<?= asset_url();?>images/icon/logo.png" alt="logo"></a>
        </div>
      </div> -->
      <div class="main-menu">
        <div class="menu-inner">
          <nav>
            <ul class="metismenu" id="menu">
              <li class="<?= $title == 'Daftar Dosen' ? 'active' : ''; ?>">
                <a href="<?= base_url('Dosen');?>"> <i class="ti-user"></i><span>Dosen </span></a>
              </li>
              <li class="<?= $title == 'Daftar Kelas' ? 'active' : ''; ?>">
                <a href="<?= base_url('Kelas');?>"> <i class="ti-layout"></i><span>Kelas </span></a>
              </li>
              <li class="<?= $title == 'Daftar Mata Kuliah' ? 'active' : ''; ?>">
                <a href="<?= base_url('mk');?>"> <i class="ti-bookmark-alt"></i><span>Daftar Mata Kuliah </span></a>
              </li>
              <li class="<?= $title == 'Buat Jadwal' ? 'active' : ''; ?>">
                <a href="<?= base_url('jadwal');?>"> <i class="ti-pencil"></i><span>Buat Jadwal</span></a>
              </li>
              <li class="<?= $title == 'Daftar Jadwal' ? 'active' : ''; ?>">
                <a href="<?= base_url('jadwal/list_id');?>"> <i class="ti-eye"></i><span>Kelola Jadwal</span></a>
              </li>
            </ul>
          </nav>
        </div>
      </div>
    </div>