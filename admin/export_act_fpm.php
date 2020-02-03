<?php
    include '../config.php';
    session_start();
    
            if(!isset($_SESSION['NIP'])){
                echo "<div class='alert'>Silahkan Login Kembalii.! <a style='color:black'; href='../index.php'>Klik</a></div>";
                session_destroy();
            } else {
                $now = time();
                if($now > $_SESSION['expire']){
                    session_destroy();
                    
                    echo "<div class='alert'>Session Expired.!<a style='color:black'; href='../index.php'>Klik</a></div>";
                }else {
 
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan.xls");
?>
<table border="1" style="width: 90%; text-align: center; font-size: 11px;">
            
    <tr style="font-weight: bold; background-color: yellow; font-size: 15px; ">
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
            <?php
                // $pilihan = $_POST['pilihan'];
                $conn = sqlsrv_connect($namaServer, $connectInfo);
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
                HAVING      (No_SPK = SPK.NO_SPK)), 0) IS NULL)
                ORDER BY SPK.No_SPK, ApproveMKT.NO_Order");

                $no = 1;
                while($data = sqlsrv_fetch_array($query_sql)){
            ?>
            <tr>
                <td style="background-color: yellow; foont-weight: bold;"><?php echo $no++; ?></td>
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
            }
        }
            ?>
        </table>