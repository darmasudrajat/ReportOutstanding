<?php
    include 'header_user.php';
    // include 'session.php';
?>    

<?php
            
            if(!isset($_SESSION['NIP'])){
                echo "<div class='alert'>Silahkan Login Kembalii.! <a style='color:black'; href='../index.php'>Klik</a></div>";
            } else {
                $now = time();
                if($now > $_SESSION['expire']){
                    session_destroy();
                    
                    echo "<div class='alert'>Session Expired.!<a style='color:black'; href='../index.php'>Klik</a></div>";
                }else {
                    
?>
<div class="content">
    <!-- Konten untuk tampil di halaman awal admin -->
</div>

<?php
                }
            }
        
    include '../footer.php';
?>