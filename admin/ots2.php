
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

<div class = "content">
    <center>
        <form id="form-ots1" action="ots2.php" method="POST">
            <div class="fieldsets-table" style="margin-top: 2%;">
                <h2>Laporan OTS 2</h2>
                <table class="mytableclass table table-bordered table-secondary " cellspacing="0" width="100%" style="font-size: 12px;">
                    <thead class="black">
                        <tr>
                              <th>No</th>
                              <th>No. Order</th>
                              <th>Tgl. SO</th>
                              <th>Kode Cust</th>
                              <th>Nama Cust</th>   
                              <th>No. PO</th>   
                              <th>Jumlah SO</th>   
                              <th>Jumlah Order</th>   
                              <th>Kode Item</th>   
                              <th>No. SPK</th>   
                              <th>Item</th>   
                              <th>Tgl. PO</th>   
                              <th>Tgl. Kirim</th>   
                              <th>Terkirim</th>   
                              <th>Retur</th>
                              <th>OS</th>
                              <th>Harga SO</th>
                              <th>Harga SPK</th>
                              <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            // QUERY LAPORAN OTS 2, ke SQL SERVER
                            include '../config.php';
                            $conn = sqlsrv_connect($namaServer, $connectInfo);
                            $queryLaporan = sqlsrv_query($conn, "SELECT ApproveMKT.NO_Order, (ISNULL(ApproveMKT.Tgl_MP,0)) AS Tgl_SO, ApproveMKT.Kode_Cust, ApproveMKT.Nama_Cust, ApproveMKT.no_PO, ApproveMKT.jumlah_order_SO, 
                                            ApproveMKT.Jumlah_Order, ApproveMKT.Kode_Item, SPK.No_SPK, ApproveMKT.Item, (ISNULL(ApproveMKT.tgl_PO,0)) AS tgl_PO, (ISNULL(ApproveMKT.Tgl_kirim, 0)) AS Tgl_kirim, ISNULL
                                            ((SELECT     SUM(isnull(Qtykirim, 0)) AS Expr1
                                            FROM         SuratJalan_Dtl
                                            GROUP BY No_SPK
                                            HAVING      (No_SPK = SPK.NO_SPK)), 0) AS TERKIRIM, ISNULL
                                            ((SELECT     SUM(Retur_Surat_Jalan_Dtl.Qty_Retur) AS Expr2
                                            FROM         Retur_Surat_Jalan_Dtl INNER JOIN
                                                        Retur_Surat_Jalan_HD ON Retur_Surat_Jalan_Dtl.No_rtr = Retur_Surat_Jalan_HD.No_rtr
                                            GROUP BY Retur_Surat_Jalan_Dtl.No_SPK, Retur_Surat_Jalan_HD.Out
                                            HAVING      (Retur_Surat_Jalan_HD.Out = 1) AND (Retur_Surat_Jalan_Dtl.No_SPK = SPK.No_SPK)), 0) AS RETUR, SPK.Jumlah_Order - ISNULL
                                            ((SELECT     SUM(isnull(Qtykirim, 0)) AS Expr1
                                            FROM         SuratJalan_Dtl
                                            GROUP BY No_SPK
                                            HAVING      (No_SPK = SPK.NO_SPK)), 0) + ISNULL
                                            ((SELECT     SUM(Retur_Surat_Jalan_Dtl.Qty_Retur) AS Expr2
                                            FROM         Retur_Surat_Jalan_Dtl INNER JOIN
                                                                Retur_Surat_Jalan_HD ON Retur_Surat_Jalan_Dtl.No_rtr = Retur_Surat_Jalan_HD.No_rtr
                                            GROUP BY Retur_Surat_Jalan_Dtl.No_SPK, Retur_Surat_Jalan_HD.Out
                                            HAVING      (Retur_Surat_Jalan_HD.Out = 1) AND (Retur_Surat_Jalan_Dtl.No_SPK = SPK.No_SPK)), 0) AS OS, ApproveMKT.HargaPerPcs AS Harga_SO,
                                            (SELECT     HARGA
                                            FROM          SPK_Harga
                                            WHERE      ([NO SPK] = spk.no_spk)) + ISNULL
                                            ((SELECT     SUM(Retur_Surat_Jalan_Dtl.Qty_Retur) AS Expr2
                                            FROM         Retur_Surat_Jalan_Dtl INNER JOIN
                                                                Retur_Surat_Jalan_HD ON Retur_Surat_Jalan_Dtl.No_rtr = Retur_Surat_Jalan_HD.No_rtr
                                            GROUP BY Retur_Surat_Jalan_Dtl.No_SPK, Retur_Surat_Jalan_HD.Out
                                            HAVING      (Retur_Surat_Jalan_HD.Out = 1) AND (Retur_Surat_Jalan_Dtl.No_SPK = SPK.No_SPK)), 0) AS Harga_SPK, STATUS = CASE WHEN SPK.Status = 0 OR
                                            SPK.Status = 1 THEN 'OPEN' ELSE 'CLOSE' END
                                            FROM         SPK FULL OUTER JOIN 
                                            ApproveMKT ON SPK.NO_Order = ApproveMKT.NO_Order
                                            WHERE    (SPK.Status >= 0) AND (SPK.Jumlah_Order - ISNULL
                                            ((SELECT     SUM(isnull(Qtykirim, 0)) AS Expr1
                                            FROM         SuratJalan_Dtl  
                                            GROUP BY No_SPK
                                            HAVING      (No_SPK = SPK.NO_SPK)), 0) > 0) OR
                                            (SPK.Status IS NULL) AND (SPK.Jumlah_Order - ISNULL
                                            ((SELECT     SUM(isnull(Qtykirim, 0)) AS Expr1
                                            FROM         SuratJalan_Dtl
                                            GROUP BY No_SPK
                                            HAVING      (No_SPK = SPK.NO_SPK)), 0) IS NULL)
                                            ORDER BY SPK.No_SPK, ApproveMKT.NO_Order");
                        
                            // LOOPING TAMPIL HASIL QUERY
                                $no = 1;
                                while($dataCari = sqlsrv_fetch_array($queryLaporan)){
                                    echo "
                                        <tr class='table-light'>
                                            <td>".$no++."</td>
                                            <td>".$dataCari['NO_Order']."</td>
                                            <td>".$dataCari['Tgl_SO']->format('d/m/Y')."</td>                 
                                            <td>".$dataCari['Kode_Cust']."</td>
                                            <td>".$dataCari['Nama_Cust']."</td>                 
                                            <td>".$dataCari['no_PO']."</td>                 
                                            <td>".$dataCari['jumlah_order_SO']."</td>                 
                                            <td>".$dataCari['Jumlah_Order']."</td>                 
                                            <td>".$dataCari['Kode_Item']."</td>                 
                                            <td>".$dataCari['No_SPK']."</td>                 
                                            <td>".$dataCari['Item']."</td>   
                                            <td>".$dataCari['tgl_PO']->format('d/m/Y')."</td>                                                     
                                            <td>".$dataCari['Tgl_kirim']->format('d/m/Y')."</td>                 
                                            <td>".$dataCari['TERKIRIM']."</td>                 
                                            <td>".$dataCari['RETUR']."</td>                 
                                            <td>".$dataCari['OS']."</td>                 
                                            <td>".$dataCari['Harga_SO']."</td>                 
                                            <td>".$dataCari['Harga_SPK']."</td>                 
                                            <td>".$dataCari['STATUS']."</td>                 
                                        </tr>
                                    ";
                                }
                  
                        ?>
                        </tbody>
                  </table>
                  <a type="button" class="tombol_export btn btn-info" href="export_act_fpm.php" target="_blank">Export Ke Excel</a>
            </div>
            <script type="text/javascript">
                $(document).ready(function(){
                    // var aa = 
                    $('.mytableclass').dataTable({

                    });
                });
            </script>
        </form>
    </center>         
</div>
        
<?php
                }
            }
               
    include '../footer.php';
?>