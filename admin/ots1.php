
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
        <form id="form-ots1" action="ots1.php" method="POST">
            <div class="fieldsets-table" style="margin-top: 2%;">
                  <h2>Laporan OTS 1</h2>
                  <table class="mytableclass table table-bordered table-secondary " cellspacing="0" width="100%" style="font-size: 12px;">
                  <thead class="black">
                        <tr>
                              <th>No</th>
                              <th>Kode Cust</th>
                              <th>No. PO</th>
                              <th>No. SPK</th>
                              <th>Tgl. SPK</th>   
                              <th>Kode Item</th>   
                              <th>Nama Item</th>   
                              <th>Jumlah Order</th>   
                              <th>Tgl. PO</th>   
                              <th>Tgl. Kirim</th>   
                              <th>Proses QC</th>   
                              <th>Terkirim</th>   
                              <th>Retur</th>   
                              <th>OS</th>   
                              <th>Status SPK</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php 
                            // QUERY LAPORAN OTS 1, ke SQL SERVER
                            include '../config.php';
                            $conn = sqlsrv_connect($namaServer, $connectInfo);
                            $queryLaporan = sqlsrv_query($conn, "SELECT     ISNULL(Kode_Cust, 0) Kode_Cust, ISNULL(no_PO, 0) no_PO, ISNULL(no_SPK, 0) No_SPK, ISNULL(Tgl_SPK, 0) Tgl_SPK, ISNULL(Kode_Item, 0) Kode_Item, 
                            ISNULL(Item, 0) Item, ISNULL(Jumlah_Order, 0) Jumlah_Order, ISNULL(tgl_PO, 0) tgl_PO, ISNULL(Tgl_kirim, 0) Tgl_kirim, ISNULL
                                ((SELECT     SUM(QtyGood) AS Expr1
                                    FROM         hasilProduksi
                                    WHERE     (Kode_Proses = 'QC')
                                    GROUP BY no_SPK
                                    HAVING      (no_SPK = SPK.NO_SPK)), 0) AS ProsesQC, ISNULL
                                ((SELECT     SUM(isnull(Qtykirim, 0)) AS Expr1
                                    FROM         SuratJalan_Dtl
                                    GROUP BY No_SPK
                                    HAVING      (No_SPK = SPK.NO_SPK)), 0) AS TERKIRIM, isnull
                                ((SELECT     SUM(Retur_Surat_Jalan_Dtl.Qty_Retur) AS Expr2
                                    FROM         Retur_Surat_Jalan_Dtl INNER JOIN
                                                        Retur_Surat_Jalan_HD ON Retur_Surat_Jalan_Dtl.No_rtr = Retur_Surat_Jalan_HD.No_rtr
                                    GROUP BY Retur_Surat_Jalan_Dtl.No_SPK, Retur_Surat_Jalan_HD.Out
                                    HAVING      (Retur_Surat_Jalan_HD.Out = 1) AND (Retur_Surat_Jalan_Dtl.No_SPK = SPK.No_SPK)), 0) AS RETUR, Jumlah_Order - ISNULL
                                ((SELECT     SUM(isnull(Qtykirim, 0)) AS Expr1
                                    FROM         SuratJalan_Dtl
                                    GROUP BY No_SPK
                                    HAVING      (No_SPK = SPK.NO_SPK)), 0) + (isnull
                                ((SELECT     SUM(Retur_Surat_Jalan_Dtl.Qty_Retur) AS Expr2
                                    FROM         Retur_Surat_Jalan_Dtl INNER JOIN
                                                        Retur_Surat_Jalan_HD ON Retur_Surat_Jalan_Dtl.No_rtr = Retur_Surat_Jalan_HD.No_rtr
                                    GROUP BY Retur_Surat_Jalan_Dtl.No_SPK, Retur_Surat_Jalan_HD.Out
                                    HAVING      (Retur_Surat_Jalan_HD.Out = 1) AND (Retur_Surat_Jalan_Dtl.No_SPK = SPK.No_SPK)), 0)) AS OS, CASE WHEN (Jumlah_Order - ISNULL
                                ((SELECT     SUM(isnull(Qtykirim, 0)) AS Expr1
                                    FROM         SuratJalan_Dtl
                                    GROUP BY No_SPK
                                    HAVING      (No_SPK = SPK.NO_SPK)), 0)) 
                            <= 0 THEN 'CLOSE' WHEN Status = '0' THEN 'OPEN' WHEN status = '1' THEN 'OPEN' WHEN status = '88' THEN 'BATAL' WHEN status = '-2' THEN 'CLOSE' WHEN status
                            = '-1' THEN 'CLOSE' ELSE 'OPEN' END AS StatusSPK
                            FROM         SPK
                            WHERE     (Jumlah_Order - ISNULL
                            ((SELECT     SUM(isnull(Qtykirim, 0)) AS Expr1
                            FROM         SuratJalan_Dtl
                            GROUP BY No_SPK
                            HAVING      (No_SPK = SPK.NO_SPK)), 0)) > 10 AND STATUS >= 0 AND STATUS < 10 AND LEFT(no_SPK, 1) <> 'R' AND RIGHT(no_SPK, 1) <> 'B' AND RIGHT(no_SPK,  1) <> 'C' AND RIGHT(no_SPK, 1) <> 'D'
                            ORDER BY No_SPK");
                        
                            // LOOPING TAMPIL HASIL QUERY
                                $no = 1;
                                while($dataCari = sqlsrv_fetch_array($queryLaporan)){
                                    echo "
                                        <tr class='table-light'>
                                            <td>".$no++."</td>
                                            <td>".$dataCari['Kode_Cust']."</td>
                                            <td>".$dataCari['no_PO']."</td>
                                            <td>".$dataCari['No_SPK']."</td>                 
                                            <td>".$dataCari['Tgl_SPK']->format('d/m/Y')."</td>                 
                                            <td>".$dataCari['Kode_Item']."</td>                 
                                            <td>".$dataCari['Item']."</td>                 
                                            <td>".$dataCari['Jumlah_Order']."</td>        
                                            <td>".$dataCari['tgl_PO']->format('d/m/Y')."</td>                                                     
                                            <td>".$dataCari['Tgl_kirim']->format('d/m/Y')."</td>                 
                                            <td>".$dataCari['ProsesQC']."</td>                 
                                            <td>".$dataCari['TERKIRIM']."</td>                 
                                            <td>".$dataCari['RETUR']."</td>                 
                                            <td>".$dataCari['OS']."</td>                 
                                            <td>".$dataCari['StatusSPK']."</td>                 
                                        </tr>
                                    ";
                                }
                  
                        ?>
                        </tbody>
                  </table>
                  <a type="button" class="tombol_export btn btn-info" href="export_act_ots1.php" target="_blank">Export Ke Excel</a>
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