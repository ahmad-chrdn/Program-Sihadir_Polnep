<?php
// Set error reporting level
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

// Establish database connection
// $con = new mysqli("localhost", "id21614013_root", "@Sihadir2023", "id21614013_sihadir");
$con = new mysqli("localhost", "root", "", "sihadir");

// Handle database connection error
if ($con->connect_error) {
	die("Koneksi Gagal: " . $con->connect_error);
}

// Function to get month name
if (!function_exists('namaBulan')) {
	function namaBulan($angka)
	{
		switch ($angka) {
			case '1':
				$bulan = "Januari";
				break;
			case '2':
				$bulan = "Februari";
				break;
			case '3':
				$bulan = "Maret";
				break;
			case '4':
				$bulan = "April";
				break;
			case '5':
				$bulan = "Mei";
				break;
			case '6':
				$bulan = "Juni";
				break;
			case '7':
				$bulan = "Juli";
				break;
			case '8':
				$bulan = "Agustus";
				break;
			case '9':
				$bulan = "September";
				break;
			case '10':
				$bulan = "Oktober";
				break;
			case '11':
				$bulan = "November";
				break;
			case '12':
				$bulan = "Desember";
				break;
			default:
				$bulan = "Tidak ada bulan yang dipilih...";
				break;
		}

		return $bulan;
	}
}

// Function to format date in Indonesian
if (!function_exists('tglIndonesia')) {
	function tglIndonesia($tgl)
	{
		$tanggal = substr($tgl, 8, 2);
		$bulan = namaBulan(substr($tgl, 5, 2));
		$tahun = substr($tgl, 0, 4);
		return $tanggal . ' ' . $bulan . ' ' . $tahun;
	}
}

// function untuk menampilkan nama hari ini dalam bahasa Indonesia
if (!function_exists('hari_ini')) {
	function hari_ini()
	{
		// Set zona waktu ke Indonesia/Jakarta
		date_default_timezone_set('Asia/Pontianak');

		// Tentukan hari ini dalam bahasa Indonesia
		$hari_ini = date("l"); // Format "l" akan memberikan nama hari dalam bahasa Indonesia
		$hari_ini_indonesia = "";

		switch ($hari_ini) {
			case "Monday":
				$hari_ini_indonesia = "Senin";
				break;
			case "Tuesday":
				$hari_ini_indonesia = "Selasa";
				break;
			case "Wednesday":
				$hari_ini_indonesia = "Rabu";
				break;
			case "Thursday":
				$hari_ini_indonesia = "Kamis";
				break;
			case "Friday":
				$hari_ini_indonesia = "Jumat";
				break;
			case "Saturday":
				$hari_ini_indonesia = "Sabtu";
				break;
			case "Sunday":
				$hari_ini_indonesia = "Minggu";
				break;
		}

		// Kembalikan ke zona waktu default jika diperlukan
		date_default_timezone_set('UTC');

		return $hari_ini_indonesia;
	}
}
