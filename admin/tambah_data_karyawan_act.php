<?php
    require '../config.php';
    if(!isset($_SESSION['NIP'])){
        // $_GET['pesan'] == 'belum_login'; 
        echo "<div class='alert'>Silahkan Login Kembalii.! <a style='color:black'; href='../index.php'>Klik</a></div>";
        // header('location: ../index.php');
    } else {
        $now = time();
        if($now > $_SESSION['expire']){
            session_destroy();
            
            echo "<div class='alert'>Session Expired.!<a style='color:black'; href='../index.php'>Klik</a></div>";
        }else {
    

    if(isset($_POST['submit'])){
        $nip = $_POST['NIP'];
        $nama = $_POST['Nama'];
        $alamat = $_POST['ALamat'];
        $kota = $_POST['Kota'];
        $tanggalLahir = $_POST['Tgl_Lahir'];
        $kotaLahir = $_POST['Kota_Lahir'];
        $jabatan = $_POST['Jabatan'];
        $passChar = $_POST['Pass_Char'];
        $divisi = $_POST['divisi'];
        $golongan = $_POST['golongan'];
        $email = $_POST['email'];
        $levelApp = $_POST['level_app'];
        $dashboard = $_POST['dashboard'];
        $status = $_POST['status'];
        $counter = $_POST['counter'];
        $lastLogin = $_POST['last_login'];

        $conn = sqlsrv_connect($namaServer, $connectInfo);
        $add_query = "insert into [dbmpmega].[dbo].[Karyawan]
        (NIP, Nama, ALamat, Kota, Tgl_Lahir, Kota_Lahir,
        Jabatan, Pass_Char, divisi, golongan, email, level_app, dashboard, status, counter, last_login)
         values ('$nip', '$nama', '$alamat', '$kota',
         '$tanggalLahir', '$kotaLahir', '$jabatan', '$passChar', 
         '$divisi', '$golongan', '$email', '$levelApp', '$dashboard', '$status', '$counter', '$lastLogin')";
    
        $simpan = sqlsrv_query($conn, $add_query);

        if($simpan == false){
            echo "Gagal";
            die( print_r( sqlsrv_errors(), true));
        } else {
            echo "<script type='text/javascript'>
                    alert('Data Berhasil Ditambahkan..!!');
                    window.location='admin_tambah_data.php'
                </script>";
        }
    }
}
    }
?>