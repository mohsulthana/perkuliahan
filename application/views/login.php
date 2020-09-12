<!doctype html>
<html class="no-js" lang="en">

	<head>
		<meta charset="utf-8">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<title>Login</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" type="image/png" href="<?= asset_url() ?>images/icon/favicon.ico">
		<link rel="stylesheet" href="<?= asset_url();?>css/bootstrap.min.css">

		<link rel="stylesheet" href="<?= asset_url() ?>css/font-awesome.min.css">
		<link rel="stylesheet" href="<?= asset_url() ?>css/themify-icons.css">
		<link rel="stylesheet" href="<?= asset_url() ?>css/metisMenu.css">
		<link rel="stylesheet" href="<?= asset_url() ?>css/owl.carousel.min.css">
		<link rel="stylesheet" href="<?= asset_url() ?>css/slicknav.min.css">
		<!-- others css -->
		<link rel="stylesheet" href="<?= asset_url() ?>css/typography.css">
		<link rel="stylesheet" href="<?= asset_url() ?>css/default-css.css">
		<link rel="stylesheet" href="<?= asset_url() ?>css/styles.css">
		<link rel="stylesheet" href="<?= asset_url() ?>css/responsive.css">
		<!-- modernizr css -->
		<script src="<?= asset_url() ?>js/vendor/modernizr-2.8.3.min.js"></script>
	</head>

	<body>
	<!--[if lt IE 8]>
	<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
	<![endif]-->
	<!-- preloader area start -->
	<div id="preloader">
		<div class="loader"></div>
	</div>
	<!-- preloader area end -->
	<!-- login area start -->
	<div class="login-area">
		<div class="container">
				<?= $this->session->flashdata('msg') ?>
			<div class="login-box ptb--100">
				<form action="<?= base_url('login/auth') ?>" method="post">
					<div class="login-form-head">
						<h4>Log In</h4>
					</div>
					<div class="login-form-body">
						<div class="form-gp">
							<label for="username">Username</label>
							<input type="text" id="username" name="username">
							<i class="ti-user"></i>
							<div class="text-danger"></div>
						</div>
						<div class="form-gp">
							<label for="exampleInputPassword1">Password</label>
							<input type="password" id="exampleInputPassword1" name="password">
							<i class="ti-lock"></i>
							<div class="text-danger"></div>
						</div>
						<div class="submit-btn-area">
							<button id="form_submit" type="submit">Submit <i class="ti-arrow-right"></i></button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- login area end -->

		<!-- jquery latest version -->
		<script src="<?= asset_url() ?>js/vendor/jquery-2.2.4.min.js"></script>
		<!-- bootstrap 4 js -->
		<script src="<?= asset_url() ?>js/popper.min.js"></script>
		<script src="<?= asset_url() ?>js/bootstrap.min.js"></script>
		<script src="<?= asset_url() ?>js/owl.carousel.min.js"></script>
		<script src="<?= asset_url() ?>js/metisMenu.min.js"></script>
		<script src="<?= asset_url() ?>js/jquery.slimscroll.min.js"></script>
		<script src="<?= asset_url() ?>js/jquery.slicknav.min.js"></script>

		<!-- others plugins -->
		<script src="<?= asset_url() ?>js/plugins.js"></script>
		<script src="<?= asset_url() ?>js/scripts.js"></script>
	</body>

</html>