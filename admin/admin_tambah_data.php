<?php
    include 'header_admin.php';

            
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
            <center>
                <fieldset id="aa">
                    <legend>Tambah Data Karyawan</legend>
                    <form action="tambah_data_karyawan_act.php" method="post">
                        <table border="0">
                            <tr>
                                <td>NIP</td>
                                <td>:</td>
                                <div class="form-group col-3">
                                    <input placeholder="test"type="text" name="NIP" class="form_control">
                                </div>
                                <td>Status</td>
                                <td>:</td>
                                <td>
                                <input type="text" name="status" class="add_form">

                                </td>
                            </tr>
                            <tr>
                                <td>Nama</td>
                                <td>:</td>
                                <td>
                                    <input type="text" name="Nama" class="add_form">
                                </td>
                                <!--  -->
                                <td>Alamat</td>
                                <td>:</td>
                                <td>
                                    <input type="text" name="ALamat" class="add_form">
                                </td>
                            </tr>
                            <tr>
                                <td>Kota</td>
                                <td>:</td>
                                <td>
                                    <input type="text" name="Kota" class="add_form">
                                </td>
                                <!--  -->
                                <td>Tgl. Lahir</td>
                                <td>:</td>
                                <td>
                                    <input type="text" name="Tgl_Lahir" class="add_form">
                                </td>
                            </tr>
                            <tr>
                                <td>Kota Lahir</td>
                                <td>:</td>
                                <td>
                                    <input type="text" name="Kota_Lahir" class="add_form">
                                </td>
                                <td>Divisi</td>
                                <td>:</td>
                                <td>
                                <input type="text" name="divisi" class="add_form">

                                </td>   
                            </tr>
                            <tr>
                                <td>Jabatan</td>
                                <td>:</td>
                                <td>
                                <input type="text" name="Jabatan" class="add_form">

                                </td>
                                <td>Password</td>
                                <td>:</td>
                                <td>
                                    <input type="password" name="Pass_Char" class="add_form">
                                </td>
                            </tr>
                            <tr>
                                
                                <td>Golongan</td>
                                <td>:</td>
                                <td>
                                    <input type="text" name="golongan" placeholder="1-9" class="add_form">
                                </td>
                                <td>Email</td>
                                <td>:</td>
                                <td>
                                    <input type="text" name="email" class="add_form">
                                </td>
                            </tr>
                
                            <tr>
                                <td>Level App</td>
                                <td>:</td>
                                <td>
                                    <input type="text" name="level_app" class="add_form">
                                </td>
                                <td>Counter</td>
                                <td>:</td>
                                <td>
                                    <input type="text" name="counter" class="add_form">
                                </td>
                            </tr>
                            <tr>
                                <td>Dashboard</td>
                                <td>:</td>
                                <td>
                                    <input type="text" name="dashboard" class="add_form">
                                </td>
                                <td>Last Login</td>
                                <td>:</td>
                                <td>
                                    <input type="text" name="last_login" class="add_form">
                                </td>
                            </tr>
                        </table>
                        <br/>
                        <br/>
                        <input type="submit" name="submit" class="submit" value="TAMBAH" style="font-size: 16px; font-weight: bold; ">
                    </form>
                </fieldset>
            </center>
        </div>
<?php
                }
            }
    include '../footer.php';
?>