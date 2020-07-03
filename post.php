<?php

   /* $lokasi=decrypt(xss('t'));
    $cookie_name="NIKKunjunganCookie";

    if(isset($_COOKIE[$cookie_name]) ) {
        if(isset($_POST['submit_unset'])){
           setcookie($cookie_name, "", time() - 3600); 
         }

         echo 'NIK: '.$_COOKIE[$cookie_name];
         echo '<form method="post" action="">
        <input type="submit" name="submit_unset" value="Ganti">
         </form>';

        $nik=$_COOKIE[$cookie_name];

        $result=mysqli_query($con,"insert into gp_checkinout set 
                userid='".$nik."',
                sensorid='".$lokasi."',
                checktype='1'
            ");

    }else{
        if(isset($_POST['submit_nik'])){
           $nik=asi($_POST['nik']);
           setcookie($cookie_name,$nik,mktime (0, 0, 0, 12, 31, 2050));

            $result=mysqli_query($con,"insert into gp_checkinout set 
                userid='".$nik."',
                sensorid='".$lokasi."',
                checktype='1'
            ");
         }

        echo '<form method="post" action="">
         NIK <input type="nik" name="nik">
        <input type="submit" name="submit_nik" value="OK">
         </form>';
    }
*/
    

?>        
