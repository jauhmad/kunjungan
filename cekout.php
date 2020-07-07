<?php
if(empty($_POST['nik']) || empty($_POST['lokasi'])  ){
 exit(); 
}
include 'inc/inc_con_db.php';

setcookie('CekinCookie', '0' ,mktime (0, 0, 0, 12, 31, 2050)); 

    $nik=asi($_POST['nik']);
    $lokasi=asi($_POST['lokasi']);
    $nama=asi($_POST['nama']);
    $alamat=asi($_POST['alamat']);

    $result=mysqli_query($con,"insert into gp_checkinout set 
                userid='".$nik."',
                nama='".$nama."',
                alamat='".$alamat."',
                sensorid='".$lokasi."',
                checktype='0'
            ");
   

    if($result){
        echo 'Terima kasih atas kunjunga anda..';
    }else{
       echo 'Gagal';   
    }

?>