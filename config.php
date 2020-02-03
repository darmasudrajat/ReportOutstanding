<?php
    // Koneksi ke local xampp
    // $connect_on = mssql_connect("", "dbmp", "dbmp123456", "dbmp");

    // if(mysqli_connect_errno()){
    //     echo "Koneksi Gagal...! :" .mysqli_connect_error();
    // }

    // Koneksi ke server
    $namaServer = "192.168.2.100";
    $id = "sa";
    $pass = "dsoft";
    $db = "dbmpmega";



    $connectInfo = array(
        "UID" => "$id",
        "PWD" => "$pass",
        "Database" => "dbmpmega"

        
    );

    $conn = sqlsrv_connect($namaServer, $connectInfo);

    // if($conn){
    //     echo "koneksi berhasil";
    // } else {
    //     echo "gagal";
    // }

    
?>