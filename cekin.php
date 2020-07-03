<?php
include 'inc/inc_con_db.php';

    $nik=asi($_POST['nik']);
    $lokasi=decrypt(asi($_POST['lokasi']));

    $result=mysqli_query($con,"insert into gp_checkinout set 
                userid='".$nik."',
                sensorid='".$lokasi."',
                checktype='1'
            ");
     $last_id = mysqli_insert_id($con);

    if($result){
       echo '<input type="hidden" id="nik" name="nik" value="'.$nik.'">';
       echo '<input type="hidden" id="lokasi" name="lokasi" value="'.$lokasi.'">';
       setcookie($cookie_name,$nik,mktime (0, 0, 0, 12, 31, 2050)); 

       $result2=mysqli_query($con,"select lokasi.nama,
                                         gp_checkinout.checktime 
                                  from 
                                    gp_checkinout,
                                    lokasi
                                  where
                                    gp_checkinout.sensorid=lokasi.sensorid and
                                    gp_checkinout.id ='".$last_id."'");
       $data=mysqli_fetch_array($result2);

       include "phpqrcode/qrlib.php"; 
       $tempdir = "images/"; 
       if (!file_exists($tempdir)) mkdir($tempdir);
       $logopath="images/logo.png";
       $codeContents = $data['nama']; 

       QRcode::png($codeContents, $tempdir.'qrwithlogo.png', QR_ECLEVEL_H, 10,4);
       $QR = imagecreatefrompng($tempdir.'qrwithlogo.png');
      
        $logo = imagecreatefromstring(file_get_contents($logopath));
 
         imagecolortransparent($logo , imagecolorallocatealpha($logo , 0, 0, 0, 127));
         imagealphablending($logo , false);
         imagesavealpha($logo , true);

         $QR_width = imagesx($QR);
         $QR_height = imagesy($QR);

         $logo_width = imagesx($logo);
         $logo_height = imagesy($logo);

         $logo_qr_width = $QR_width/8;
 $scale = $logo_width/$logo_qr_width;
 $logo_qr_height = $logo_height/$scale;

 imagecopyresampled($QR, $logo, $QR_width/2.3, $QR_height/2.3, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);

 // Simpan kode QR lagi, dengan logo di atasnya
 imagepng($QR,$tempdir.'qrwithlogo.png');

       echo 'Bukti Kunjungan Anda<br>
             '.date('d-m-Y H:i:s').'   
            Tunjukkan pada petugas jika diminta<br>
            <img src="images/qrwithlogo.png"><br>
            '.$data['nama'].'<br>
            '.$data['checktime'].'
       ';
    }else{
       echo 'Gagal';   
    }

    echo '<br><button id="cekout">Keluar Lokasi</button>';
?>

<script type="text/javascript">
    $(function () {
  $('#cekout').click(function (result) {   
    var lokasi= $("#lokasi").val();
    var nik =   $("#nik").val();    
    $.post(
      'cekout', { 
        lokasi: lokasi, 
        nik:   nik
      }, function () {
        //$('.success_msg').append("Vote Successfully Recorded").fadeOut();
        $("#toptitle").html(result);
        //delay(3000);
        //window.close();
      }
    );
    event.preventDefault();
  });
});
</script>