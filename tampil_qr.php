<?php
      $checktime=date_create($data['checktime']);
      $checktime=date_format($checktime, 'd-m-Y H:i:s');
	  echo '<h1 class="text-info">Bukti Kunjungan</h1>
             
            <p>Tunjukkan pada petugas jika diminta</p>
            <p><img src="images/qrwithlogo.png" width="100%"></p>
            <h3>'.$data['userid'].'</h3>
            <h2 class="text-success">'.$data['nm_lokasi'].'</h2>
            <h3>'.$checktime.' WIB</h3>
       ';
   
    echo '<button id="cekout" type="button" class="btn btn-round btn-warning btn-lg">Keluar dari Lokasi Kunjungan</button>';
?>