<?php
include 'inc/inc_con_db.php';

    $nik=asi($_POST['nik']);
    $lokasi=decrypt(asi($_POST['lokasi']));

    $result=mysqli_query($con,"insert into gp_checkinout set 
                userid='".$nik."',
                sensorid='".$lokasi."',
                checktype='0'
            ");
   

    if($result){
        echo 'Terima kasih atas kunjunga anda..';
    }else{
       echo 'Gagal';   
    }

?>