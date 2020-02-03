
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

            <!-- <?php
                // include '../config.php';
            ?> -->
            <br/>
            <center>
            <form action="report_admin.php" method="post">
                <fieldset class="fieldset-report">
                    <table border="0">
                        <tr>
                            <td>Pilih Laporan</td>
                            <td>:</td>
                            <td>
                                <select name="pilihan" onselect="lap_pilihan()">
                                    <option value="ots1">OTS 1</option>
                                    <option value="ots2">OTS 2</option>
                                    <option value="ots3">OTS 3</option>
                                </select>
                            </td>
                            <td></td>
                            <!-- <td>Cari Kode</td>
                            <td>:</td>
                            <td><input type="text" name="cari_no" placeholder="Masukan No.."></td> -->
                            <td></td>
                            <td><input type="submit" name="cari" value="Cari"></td>
                        </tr>
                    </table>
                    
                </fieldset>
            

                <br/>
            </form>
            <div class="fieldset-table">
                
                    
                    <?php
                        include_once '../config.php';
                        error_reporting(0);
                        $conn = sqlsrv_connect($namaServer, $connectInfo);
                        if(isset($_POST['cari'])){
                            $cari_no = $_POST['cari_no'];
                            $pilihan = $_POST['pilihan'];
                            if($pilihan == 'ots1') {
                                echo "<a class='tombol_export' href='export_act_ots1.php' target='_blank'>Export to Excel</a>";
                                echo "<h3>OUTS 1</h3>
                                <table class='mytableclass table table-bordered table-secondary' cellspacing='0' width='100%'>
                                    <thead>
                                        <tr style='background-color: #91aff4; font-size: 10px;'>
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
                                ";
                                
                                    $query_sql = sqlsrv_query($conn, "SELECT     ISNULL(Kode_Cust, 0) Kode_Cust, ISNULL(no_PO, 0) no_PO, ISNULL(no_SPK, 0) No_SPK, ISNULL(Tgl_SPK, 0) Tgl_SPK, ISNULL(Kode_Item, 0) Kode_Item, 
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
                                    // END QUERY SQL =======
                        
                                $no = 1;
                                while($data = sqlsrv_fetch_array($query_sql)){        
                    ?>
                    
                                    <tr style="font-size: 9px;">
                                        <td style="background-color: #91aff4; font-size:13px; font-weight: bold;"><?php echo $no++; ?></td>
                                        <td><?php echo $data['Kode_Cust']; ?></td>
                                        <td><?php echo $data['no_PO']; ?></td>
                                        <td><?php echo $data['No_SPK']; ?></td>
                                        <td><?php echo $data['Tgl_SPK']->format('d/m/Y'); ?></td>
                                        <td><?php echo $data['Kode_Item']; ?></td>
                                        <td><?php echo $data['Item']; ?></td>
                                        <td><?php echo $data['Jumlah_Order']; ?></td>
                                        <td><?php echo $data['tgl_PO']->format('d/m/Y'); ?></td>
                                        <td><?php echo $data['Tgl_kirim']->format('d/m/Y'); ?></td>
                                        <td><?php echo $data['ProsesQC']; ?></td>
                                        <td><?php echo $data['TERKIRIM']; ?></td>
                                        <td><?php echo $data['RETUR']; ?></td>
                                        <td><?php echo $data['OS']; ?></td>
                                        <td><?php echo $data['StatusSPK']; ?></td>
                                    </tr>
                
                    
                    <?php
                            }
                            echo " </tbody>
                        </table>";
                        }if($pilihan == 'ots2') {
                            echo "<a class='tombol_export' href='export_act_fpm.php' target='_blank'>Export to Excel</a>";
                            echo " <h3>OUTS 2</h3>
                            <table class='mytableclass table table-bordered table-secondary' cellspacing='0' width='100%'>
                            <thead>
                                <tr style='background-color: #91aff4; font-size: 10px;'>
                                        <th>No</th>
                                        <th>No. Order</th>
                                        <th>Tgl. SO</th>
                                        <th>Kode Cust</th>
                                        <th>Nama Cust</th>
                                        <th>No. PO</th>
                                        <th>Jumlah Order SO</th>
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
                            ";
                        
                            $query_sql = sqlsrv_query($conn, "SELECT ApproveMKT.NO_Order, (ISNULL(ApproveMKT.Tgl_MP,0)) AS Tgl_SO, ApproveMKT.Kode_Cust, ApproveMKT.Nama_Cust, ApproveMKT.no_PO, ApproveMKT.jumlah_order_SO, 
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
                                        HAVING      (No_SPK = SPK.NO_SPK)), 0) IS NULL) and ApproveMKT.NO_Order like '%".$cari_no."%'
                                        ORDER BY SPK.No_SPK, ApproveMKT.NO_Order");
                            // END QUERY SQL =======
                            $no = 1;
                            while($data = sqlsrv_fetch_array($query_sql)){       
                            
                    ?>
                    
                    <tr style="font-size: 9px;">
                        <td style="background-color: #91aff4; font-weight: bold; font-size: 13px;"><?php echo $no++; ?></td>
                        <td><?php echo $data['NO_Order']; ?></td>
                        <td><?php echo $data['Tgl_SO']->format('d/m/Y'); ?></td>
                        <td><?php echo $data['Kode_Cust']; ?></td>
                        <td><?php echo $data['Nama_Cust']; ?></td>
                        <td><?php echo $data['no_PO']; ?></td>
                        <td><?php echo $data['jumlah_order_SO']; ?></td>
                        <td><?php echo $data['Jumlah_Order']; ?></td>
                        <td><?php echo $data['Kode_Item']; ?></td>
                        <td><?php echo $data['No_SPK']; ?></td>
                        <td><?php echo $data['Item']; ?></td>
                        <td><?php echo $data['tgl_PO']->format('d/m/Y'); ?></td>
                        <td><?php echo $data['Tgl_kirim']->format('d/m/Y'); ?></td>
                        <td><?php echo $data['TERKIRIM']; ?></td>
                        <td><?php echo $data['RETUR']; ?></td>
                        <td><?php echo $data['OS']; ?></td>
                        <td><?php echo $data['Harga_SO']; ?></td>
                        <td><?php echo $data['Harga_SPK']; ?></td>
                        <td><?php echo $data['STATUS']; ?></td>
                    </tr>

                    <?php
                            }
                            echo " </tbody>
                        </table>";
                        } if($pilihan == 'ots3') {
                            echo "<a class='tombol_export' href='export_act_fpm2.php' target='_blank'>Export to Excel</a>";
                            
                            
                            echo "<h3>OUTS 3</h3>
                            <table class='mytableclass table table-bordered table-secondary' cellspacing='0' width='100%'>
                            <thead>
                                <tr style='background-color: #91aff4; font-size: 10px;'>
                                        <th>No</th>
                                        <th>No. Order</th>
                                        <th>Tgl. SO</th>
                                        <th>Kode Cust</th>
                                        <th>Nama Cust</th>
                                        <th>No. PO</th>
                                        <th>Jumlah Order SO</th>
                                        <th>Jumlah Order</th>
                                        <th>Kode Item</th>
                                        <th>No. SPK</th>
                                        <th>Item</th>
                                        <th>Tgl. PO</th>
                                        <th>Tgl. Kirim</th>
                                        <th>Terkirim</th>
                                        <th>Retur</th>
                                        <th>OS</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                            <tbody>

                            ";
                        
                            $query_sql = sqlsrv_query($conn, "SELECT
                                                ApproveMKT.NO_Order, 
                                                (isnull(ApproveMKT.Tgl_MP, 0)) AS Tgl_SO, 
                                                ApproveMKT.Kode_Cust, 
                                                ApproveMKT.Nama_Cust, 
                                                ApproveMKT.no_PO, 
                                                ApproveMKT.jumlah_order_SO,  
                                                ApproveMKT.Jumlah_Order, 
                                                ApproveMKT.Kode_Item, 
                                                SPK.No_SPK, 
                                                ApproveMKT.Item, 
                                                ISNULL(ApproveMKT.tgl_PO, 0) tgl_PO,
                                                ISNULL(ApproveMKT.Tgl_kirim, 0) Tgl_kirim,
                                                ISNULL  
                                                (
                                                    (
                                                        SELECT 
                                                        SUM(isnull(Qtykirim, 0)) AS Expr1   
                                                        FROM         
                                                        SuratJalan_Dtl   
                                                        GROUP BY 
                                                        No_SPK   
                                                        HAVING(No_SPK = SPK.NO_SPK)
                                                    ), 0
                                                ) AS TERKIRIM, 
                                                ISNULL  
                                                (
                                                    (
                                                        SELECT
                                                        SUM(Retur_Surat_Jalan_Dtl.Qty_Retur) AS Expr2  
                                                        FROM         
                                                        Retur_Surat_Jalan_Dtl 
                                                        INNER JOIN    
                                                        Retur_Surat_Jalan_HD 
                                                        ON 
                                                        Retur_Surat_Jalan_Dtl.No_rtr = Retur_Surat_Jalan_HD.No_rtr      
                                                        GROUP BY 
                                                        Retur_Surat_Jalan_Dtl.No_SPK, 
                                                        Retur_Surat_Jalan_HD.Out     
                                                        HAVING(Retur_Surat_Jalan_HD.Out = 1) 
                                                        AND 
                                                        (Retur_Surat_Jalan_Dtl.No_SPK = SPK.No_SPK)
                                                    ), 0
                                                ) AS RETUR, 
                                                SPK.Jumlah_Order - ISNULL  
                                                ((SELECT SUM(isnull(Qtykirim, 0)) AS Expr1   
                                                FROM SuratJalan_Dtl GROUP BY 
                                                No_SPK      
                                                HAVING(No_SPK = SPK.NO_SPK)), 0) + ISNULL   
                                                ((SELECT SUM(Retur_Surat_Jalan_Dtl.Qty_Retur) AS Expr2    
                                                FROM Retur_Surat_Jalan_Dtl 
                                                INNER JOIN     
                                                Retur_Surat_Jalan_HD ON Retur_Surat_Jalan_Dtl.No_rtr = Retur_Surat_Jalan_HD.No_rtr   
                                                GROUP BY 
                                                Retur_Surat_Jalan_Dtl.No_SPK, Retur_Surat_Jalan_HD.Out      
                                                HAVING (Retur_Surat_Jalan_HD.Out = 1) 
                                                AND
                                                (Retur_Surat_Jalan_Dtl.No_SPK = SPK.No_SPK)), 0) AS OS, 
                                                STATUS = CASE WHEN SPK.Status = 0 
                                                OR 
                                                SPK.Status = 1 THEN 'OPEN' ELSE 'CLOSE' END 
                                                FROM         
                                                SPK 
                                                FULL OUTER JOIN
                                                ApproveMKT ON SPK.NO_Order = ApproveMKT.NO_Order 
                                                WHERE     
                                                (SPK.Status >= 0) 
                                                AND
                                                (SPK.Jumlah_Order - ISNULL  ((SELECT     SUM(isnull(Qtykirim, 0)) AS Expr1    
                                                FROM         
                                                SuratJalan_Dtl    
                                                GROUP BY No_SPK    
                                                HAVING (No_SPK = SPK.NO_SPK)), 0) > 0) 
                                                OR
                                                (SPK.Status IS NULL) 
                                                AND
                                                (SPK.Jumlah_Order - ISNULL  
                                                ((SELECT     SUM(isnull(Qtykirim, 0)) AS Expr1    
                                                FROM         
                                                SuratJalan_Dtl
                                                GROUP BY No_SPK
                                                HAVING(No_SPK = SPK.NO_SPK)), 0) IS NULL) 
                                                ORDER BY 
                                                SPK.No_SPK, 
                                                ApproveMKT.NO_Order");
                            $no = 1;
                            while($data = sqlsrv_fetch_array($query_sql)){
                                
                        ?>

                                <tr style="font-size: 9px;">
                                    <td style="background-color: #91aff4; font-weight: bold; font-size: 13px;"><?php echo $no++; ?></td>
                                    <td><?php echo $data['NO_Order']; ?></td>
                                    <td><?php echo $data['Tgl_SO']->format('d/m/Y'); ?></td>
                                    <td><?php echo $data['Kode_Cust']; ?></td>
                                    <td><?php echo $data['Nama_Cust']; ?></td>
                                    <td><?php echo $data['no_PO']; ?></td>
                                    <td><?php echo $data['jumlah_order_SO']; ?></td>
                                    <td><?php echo $data['Jumlah_Order']; ?></td>
                                    <td><?php echo $data['Kode_Item']; ?></td>
                                    <td><?php echo $data['No_SPK']; ?></td>
                                    <td><?php echo $data['Item']; ?></td>
                                    <td><?php echo $data['tgl_PO']->format('d/m/Y'); ?></td>
                                    <td><?php echo $data['Tgl_kirim']->format('d/m/Y'); ?></td>
                                    <td><?php echo $data['TERKIRIM']; ?></td>
                                    <td><?php echo $data['RETUR']; ?></td>
                                    <td><?php echo $data['OS']; ?></td>
                                    <td><?php echo $data['STATUS']; ?></td>
                                </tr>

                <?php
                            }
                            
                            echo " </tbody>
                        </table>";
                        }
                    }
                ?>

        <script type="text/javascript">
            $(document).ready(function(){
            
                $('.mytableclass').dataTable({

                });
            })
            00
        </script>
                <br/>
                </form>
            </center>
        </div>
        
<?php
                }
            }
               
    include '../footer.php';
?>