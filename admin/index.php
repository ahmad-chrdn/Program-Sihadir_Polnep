<?php
session_start();
include '../config/db.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Login | Admin</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="../assets/img/logo1.png" />
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../assets/_login/vendor/bootstrap/css/bootstrap.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../assets/_login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../assets/_login/fonts/iconic/css/material-design-iconic-font.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../assets/_login/vendor/animate/animate.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../assets/_login/vendor/css-hamburgers/hamburgers.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../assets/_login/vendor/animsition/css/animsition.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../assets/_login/vendor/select2/select2.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../assets/_login/vendor/daterangepicker/daterangepicker.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../assets/_login/css/util.css">
	<link rel="stylesheet" type="text/css" href="../assets/_login/css/main.css">
	<!--===============================================================================================-->
</head>

<body>

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form method="post" action="" class="login100-form validate-form">
					<span class="login100-form-title p-b-48">
						<img src="../assets/img/Logo_Polnep.png" width="150">
					</span>
					<span class="login100-form-title p-b-26">
						Politeknik Negeri Pontianak
					</span>

					<div class="wrap-input100 validate-input">
						<input class="input100" type="text" name="username">
						<span class="focus-input100" data-placeholder="Username"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="password">
						<span class="btn-show-pass">
							<i class="zmdi zmdi-eye"></i>
						</span>
						<input class="input100" type="password" name="password">
						<span class="focus-input100" data-placeholder="Password"></span>
					</div>

					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button type="submit" class="login100-form-btn">
								Login
							</button>
						</div>
					</div>

				</form>

				<?php
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					$username = mysqli_real_escape_string($con, $_POST['username']);
					$enteredPassword = $_POST['password'];

					// Enkripsi password yang dimasukkan oleh pengguna
					$pass = password_hash($enteredPassword, PASSWORD_DEFAULT);

					// Periksa data pengguna di tabel admins
					$sqlCek = mysqli_query($con, "SELECT * FROM admins WHERE username='$username'");
					$ad = mysqli_fetch_assoc($sqlCek);

					if ($ad && password_verify($enteredPassword, $ad['password'])) {
						// Set session untuk pengguna yang berhasil login
						$_SESSION['admin'] = $ad['id_admin'];
						session_regenerate_id(true);
						echo "
						<script>											
							window.location.replace('./dashboard.php');
						</script>";
					} else {
						echo "
						<script type='text/javascript'>
						setTimeout(function () { 
							swal('Maaf!', 'Username / Password Salah', {
								icon : 'error',
								buttons: {                    
									confirm: {
										className : 'btn btn-danger'
									}
								},
							});    
						}, 100);  
						window.setTimeout(function(){ 
							window.location.replace('index.php');
						}, 3000);   
						</script>";
					}
				}
				?>
			</div>
		</div>
	</div>

	<div id="dropDownSelect1"></div>

	<!--===============================================================================================-->
	<script src="../assets/_login/vendor/jquery/jquery-3.2.1.min.js"></script>
	<!--===============================================================================================-->
	<script src="../assets/_login/vendor/animsition/js/animsition.min.js"></script>
	<!--===============================================================================================-->
	<script src="../assets/_login/vendor/bootstrap/js/popper.js"></script>
	<script src="../assets/_login/vendor/bootstrap/js/bootstrap.min.js"></script>
	<!--===============================================================================================-->
	<script src="../assets/_login/vendor/select2/select2.min.js"></script>
	<!--===============================================================================================-->
	<script src="../assets/_login/vendor/daterangepicker/moment.min.js"></script>
	<script src="../assets/_login/vendor/daterangepicker/daterangepicker.js"></script>
	<!--===============================================================================================-->
	<script src="../assets/_login/vendor/countdowntime/countdowntime.js"></script>
	<!--===============================================================================================-->

	<!-- Sweet Alert -->
	<script src="../assets/js/plugin/sweetalert/sweetalert.min.js"></script>
	<script src="../assets/_login/js/main.js"></script>

</body>

</html>