<?php
session_start();
require 'config.php';

$conn = sqlsrv_connect($namaServer, $connectInfo);

$user = $_POST['NIP'];
$password = $_POST['Pass_Char'];



if(empty($_POST['NIP']) || empty($_POST['Pass_Char'])){
    echo "<script type='text/javascript'>
            alert('Masukan Username dan Password..!!');
            window.location='index.php'
        </script>";
}else{

$query = "SELECT * FROM [dbmpmega].[dbo].[Karyawan] WHERE NIP='{$user}' AND "." Pass_Char='{$password}'";
$result = sqlsrv_query($conn, $query);

if($result === false){
     die( print_r( sqlsrv_errors(), true));
}

$cek = sqlsrv_has_rows($result);

if($cek > 0){
    $_SESSION['NIP'] = $user;
    // $_SESSION['golongan'] = $_POST['golongan'];
    $_SESSION['status'] = "login";
    $_SESSION['start'] = time();
    $_SESSION['expire'] = $_SESSION['start'] + (500*60);

    while($row = sqlsrv_fetch_array($result)){
        $_SESSION['golongan'] = $row['golongan'];
    
        if($_SESSION['golongan'] >= '6'){
            header("Location: admin/admin_page.php");
        } else if($_SESSION['golongan'] <= '5'){
            header("Location: user/user_page.php");
        } else {
            echo "<script>
                alert('Login Gagal..!!');
                </script>";
            header("Location: index.php?pesan=gagal");
        }
    }

} else {
    header("location:index.php?pesan=gagal");
}
}
// if(sqlsrv_has_rows($result) != 1){
//     echo "<script type='text/javascript'>
//             alert('Username atau Password Salah..!!');
//             window.location='index.php'
//         </script>";
// }else{

//     while($row = sqlsrv_fetch_array($result)){
//        $_SESSION['NIP'] = $_POST['NIP'];
//        $_SESSION['Nama'] = $row['Nama'];
//        $_SESSION['golongan'] = $row['golongan'];
//     }
//     if($_SESSION['golongan'] == '9'){
//         header("Location: admin/admin_page.php");
//     } else if($_SESSION['golongan'] <= 8){
//         header("Location: user/user_page.php");
//     }
//     // GOLONGAN ADA BANYAK AKSES
// }
// }
?>