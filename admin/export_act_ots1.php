<?php
    include '../config.php';
    session_start();
    
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
                    

	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan.xls");
?>
<table border="1" style="width: 90%; text-align: center; font-size: 11px;">
            
            <tr style="font-weight: bold; background-color: yellow; font-size: 15px;">
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
            <?php
                
                // $pilihan = $_POST['pilihan'];
                // $cari_no = $_GET['cari_no'];

                $conn = sqlsrv_connect($namaServer, $connectInfo);
                $query_sql = sqlsrv_query($conn, "SELECT     Kode_Cust, no_PO, No_SPK, ISNULL(Tgl_SPK,0) Tgl_SPK, Kode_Item, Item, Jumlah_Order, ISNULL(tgl_PO,0) tgl_PO, ISNULL(Tgl_kirim,0) Tgl_kirim, ISNULL
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
                    <= 0 THEN 'CLOSE' WHEN Status = '0' THEN 'OPEN' WHEN status = '1' THEN 'OPEN' WHEN status = '88' THEN 

'BATAL' WHEN status = '-2' THEN 'CLOSE' WHEN status
                    = '-1' THEN 'CLOSE' ELSE 'OPEN' END AS StatusSPK
FROM         SPK
WHERE     (Jumlah_Order - ISNULL
                        ((SELECT     SUM(isnull(Qtykirim, 0)) AS Expr1
                            FROM         SuratJalan_Dtl
                            GROUP BY No_SPK
                            HAVING      (No_SPK = SPK.NO_SPK)), 0)) > 10 AND STATUS >= 0 AND STATUS < 10
ORDER BY No_SPK");

                $no = 1;
                while($data = sqlsrv_fetch_array($query_sql)){
            ?>
            <tr>
                <td style="background-color: yellow; font-weight: bold;"><?php echo $no++; ?></td>
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
            }
        }
            ?>
</table>