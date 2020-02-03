<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0 shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" type="text/css" href="../css/style.css">
        <link rel="shortcut icon" type="image/png" href="../image/logo.ico">
        <title>Admin</title>

        <!-- LINK Ke JS dan CSS, include -->
        <link rel="stylesheet" href="../vendor/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="../vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css">
        <link href="../css/addons/datatables.min.css" rel="stylesheet">
        <script src="../vendor/jquery/jquery.min.js"></script>
        <script src="../js/addons/datatables.min.js" rel="stylesheet"></script>
        
    </head>

    <body>
        
        <script type="javascript"></script>
        <?php
            session_start();
            if(!isset($_SESSION['NIP'])){
                echo "<div class='alert'>Silahkan Login Kembalii.! <a style='color:black'; href='../index.php'>Klik</a></div>";
            } else {
                $now = time();
                if($now > $_SESSION['expire']){
                    session_destroy();
                    
                    echo "<div class='alert'>Session Expired.!<a style='color:black'; href='../index.php'>Klik</a></div>";
                }else {
                    
        ?>
        <div class="wrapper">

            <div class="header">
                <!-- Bagian untuk header -->
                <img id="logo" src="../image/logo.ico" />
            </div>
            
            <div class="nav-bar">
                <!-- Bagian untuk navigasi / menu-->
                <label for="drop" class="toogle">Menu</label>
                <input type="checkbox" id="drop" />
                <ul class="menu">
                    <li><a href="admin_page.php">Home</a></li>
                    <li>
                        <label for="drop-1" class="toogle">Laporan +</label>
                        <a href="">Laporan</a>

                        <input type="checkbox" id="drop-1" />
                        <ul>
                            <!-- <li><a href="report_admin.php">Lihat dan Export</a></li> -->
                            <li><a href="ots1.php">OTS 1</a></li>
                            <li><a href="ots2.php">OTS 2</a></li>
                        </ul>
                    </li>

                    <!-- <li>
                        <label for="drop-2" class="toogle">Karyawan +</label>
                        <a href="#">Karyawan</a>

                        <input type="checkbox" id="drop-2" />
                        <ul>
                            <li><a href="admin_tambah_data.php">Tambah Data</a></li>
                            <li><a href="#">-</a></li>
                            <li><a href="#">-</a></li>
                        </ul>
                    </li> -->
                    <!-- Tambah untuk menu lain-lain -->
                    <li>
                        <label for="drop-3" class="toogle">Chart +</label>
                        <a href="chart_admin.php">Chart</a>

                        <input type="checkbox" id="drop-3" />
                        <ul>
                            <li><a href="chart_admin.php">Chart 1</a></li>
                            <li><a href="chart_2.php">Chart 2</a></li>
                            <li><a href="#">-</a></li>
                        </ul>
                    </li>
                    <li>
                        <label for="drop-3" class="toogle">Menu 2 +</label>
                        <a href="#">Menu 2</a>

                        <input type="checkbox" id="drop-3" />
                        <ul>
                            <li><a href="#">-</a></li>
                            <li><a href="#">-</a></li>
                            <li><a href="#">-</a></li>
                        </ul>
                    </li>
                    <li><a href="../logout.php">Logout</a></li>
                </ul>
                
               
            </div>
            
        <?php
                }
            }
        ?>