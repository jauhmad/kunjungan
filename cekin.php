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

   
       echo '<input type="hidden" id="nik" name="nik" value="'.$nik.'">';
       echo '<input type="hidden" id="lokasi" name="lokasi" value="'.$lokasi.'">';
       setcookie('NIKKunjunganCookie',$nik,mktime (0, 0, 0, 12, 31, 2050)); 
       setcookie('CekinCookie', $last_id ,mktime (0, 0, 0, 12, 31, 2050)); 

       $result2=mysqli_query($con,"select  
                                         gp_checkinout.userid,
                                         gp_checkinout.sensorid,
                                         lokasi.nama,
                                         gp_checkinout.checktime 
                                  from 
                                    gp_checkinout,
                                    lokasi
                                  where
                                    gp_checkinout.sensorid=lokasi.sensorid and
                                    gp_checkinout.id ='".$last_id."'");
       $data=mysqli_fetch_array($result2);

       buat_qr($data['nama']);
       include 'tampil_qr.php';
     
?>
<script type="text/javascript">
    function close_window() {
 /* if (confirm("Terima kasih atas kunjungan anda..")) {*/
    $(location).attr('href', 'index');

  /*}*/
}
</script>
  <script type="text/javascript">
         /*$(function () {*/
          $('#cekout').click(function (result) {   
            var lokasi= $("#lokasi").val();
            var nik =   $("#nik").val();    
            $.post(
              'cekout', { 
                lokasi: lokasi, 
                nik:   nik
              }, function () {
                // alert("The request has been submitted.");
                //$('.success_msg').append("Vote Successfully Recorded").fadeOut();
               // $("#toptitle").html(result);
                //delay(3000);
                close_window();
                return false;
              }
            );
            /*event.preventDefault();*/
          });
       /* });*/
        </script>

