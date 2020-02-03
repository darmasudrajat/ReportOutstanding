        <?php
            include '../config.php';
            include 'header_admin.php';
          
            if(!isset($_SESSION['NIP'])){
                echo "<div class='alert'>Silahkan Login Kembalii.! <a style='color:black'; href='../index.php'>Klik</a></div>";
            } else {
                $now = time();
                if($now > $_SESSION['expire']){
                    session_destroy();
                    
                    echo "<div class='alert'>Session Expired.!<a style='color:black'; href='../index.php'>Klik</a></div>";
                }else {


        sqlsrv_query($conn, "DROP TABLE tb_chart");
        sqlsrv_query($conn,     "SELECT     
                                MONTH(SuratJalan_HD.tgl_SJ) AS bulan, 
                                SUM(SuratJalan_Dtl.QtyKirim) AS total, 
                                YEAR(SuratJalan_HD.tgl_SJ) AS Expr2
                                INTO tb_chart
                                FROM SuratJalan_HD
                                INNER JOIN SuratJalan_Dtl ON SuratJalan_HD.No_SJ = SuratJalan_Dtl.No_SJ
                                GROUP BY MONTH(SuratJalan_HD.tgl_SJ), YEAR(SuratJalan_HD.tgl_SJ)
                                HAVING (YEAR(SuratJalan_HD.tgl_SJ) = '2019')
                                ORDER BY MONTH(SuratJalan_HD.tgl_SJ)");
                                
        
        ?>


        <script type="text/javascript" src="../Chartjs/Chart.bundle.min.js"></script>
    

    <!-- <style type="text/css">
	/* body{
		font-family: roboto;
	} */
 
	
    
    </style> -->
<div class="content">
    <h3 style="margin: 6% auto; margin-bottom: -5%; background-color: #0030ff; width: 20%; color: white;">CHART QTY PENGIRIMAN</h3>
    <canvas id="myChart"></canvas>
       
    <!-- </div> -->
    <script language="JavaScript">
        var ctx = document.getElementById("myChart");
        var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["Januari", "Februari", "Maret", "April","Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
            // labels: ["1","2","3","4","5","6","7","8","9","10","11"],
            datasets: [{
                label: '',
                data: [
                    <?php
                        $jml1 = sqlsrv_query($conn, "SELECT     * from tb_chart where bulan='1'",  array(), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
                        $data = sqlsrv_fetch_array($jml1);
                        echo $data['total'];
                   
                    ?>,
                    <?php
                        $jml2 = sqlsrv_query($conn, "SELECT     * from tb_chart where bulan='2'",  array(), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
                        $data = sqlsrv_fetch_array($jml2);
                        echo $data['total'];
                   
                    ?>,
                    <?php
                        $jml3 = sqlsrv_query($conn, "SELECT     * from tb_chart where bulan='3'",  array(), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
                        $data = sqlsrv_fetch_array($jml3);
                        echo $data['total'];
                   
                    ?>,
                    <?php
                        $jml4 = sqlsrv_query($conn, "SELECT     * from tb_chart where bulan='4'");
                        $data = sqlsrv_fetch_array($jml4);
                        echo $data['total'];
                   
                    ?>,
                    <?php
                        $jml5 = sqlsrv_query($conn, "SELECT     * from tb_chart where bulan='5'");
                        $data = sqlsrv_fetch_array($jml5);
                        echo $data['total'];
                   
                    ?>,
                    <?php
                        $jml6 = sqlsrv_query($conn, "SELECT     * from tb_chart where bulan='6'");
                        $data = sqlsrv_fetch_array($jml6);
                        echo $data['total'];
                   
                    ?>,
                    <?php
                        $jml7 = sqlsrv_query($conn, "SELECT     * from tb_chart where bulan='7'");
                        $data = sqlsrv_fetch_array($jml7);
                        echo $data['total'];
                   
                    ?>,
                    <?php
                        $jml8 = sqlsrv_query($conn, "SELECT     * from tb_chart where bulan='8'");
                        $data = sqlsrv_fetch_array($jml8);
                        echo $data['total'];
                   
                    ?>,
                    <?php
                        $jml9 = sqlsrv_query($conn, "SELECT     * from tb_chart where bulan='9'");
                        $data = sqlsrv_fetch_array($jml9);
                        echo $data['total'];
                   
                    ?>,
                    <?php
                        $jml10 = sqlsrv_query($conn, "SELECT     * from tb_chart where bulan='10'");
                        $data = sqlsrv_fetch_array($jml10);
                        echo $data['total'];
                   
                    ?>,
                    <?php
                        $jml11 = sqlsrv_query($conn, "SELECT     * from tb_chart where bulan='11'");
                        $data = sqlsrv_fetch_array($jml11);
                        echo $data['total'];
                   
                    ?>,
                    <?php
                        $jml12 = sqlsrv_query($conn, "SELECT     * from tb_chart where bulan='12'");
                        $data = sqlsrv_fetch_array($jml12);
                        echo $data['total'];
                   
                    ?>,
                ],
                backgroundColor: [
                    'rgba(225, 99, 132, 0.9)',
                    'rgba(54, 162, 235, 0.9)',
                    'rgba(210, 28, 251, 0.9)',
                    'rgba(225, 206, 86, 0.9)',
                    'rgba(221, 19, 23, 0.9)',
                    'rgba(75, 192, 192, 0.9)',
                    'rgba(22, 90, 90, 0.9)',
                    'rgba(54, 12, 275, 0.9)',
                    'rgba(90, 68, 51, 0.9)',
                    'rgba(22, 206, 86, 0.9)',
                    'rgba(22, 90, 90, 0.9)',
                    'rgba(225, 206, 86, 0.9)'
                ],
                borderColor: [
                    'rgba(225, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(210, 28, 251, 1)',
                    'rgba(225, 206, 86, 1)',
                    'rgba(221, 19, 23, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(22, 90, 90, 0.9)',
                    'rgba(54, 12, 275, 0.9)',
                    'rgba(90, 68, 51, 0.9)',
                    'rgba(22, 206, 86, 0.9)',
                    'rgba(22, 90, 90, 0.9)',
                    'rgba(210, 28, 251, 1)'
                ],
                borderWidth: 1
            }]
        },
        option: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                    //     min: 100,
                    //     max: 100,
                    //     callback: function(value) {
                    //         return value + "%"
                    //     }
                    // },
                    // scaleLabel: {
                    //     display: true,
                    //     labelString: "Percentage"
                    }
                }]
            }
        }
    });
    </script>

</div>
<?php
                }
            }
        include '../footer.php';
?>