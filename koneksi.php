<?php
	$hostname	= "localhost"; //bawaan
	$username	= "root"; //bawaan
	$password	= ""; //kosong
	$database	= "dikpora_sma"; //nama database yang akan dikoneksikan

	$connect	= new mysqli($hostname, $username, $password, $database); //query koneksi

	if($connect->connect_error) { //cek error
		die("Error : ".$connect->connect_error);
	}
?>