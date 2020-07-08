<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Tracing Kunjungan</title>

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">
  </head>
    <body class="login">
    	<div>
        <div class="login_wrapper">
            <div class="animate form login_form">
                <section class="login_content"> 
                    <form>
<?php
include 'inc/inc_con_db.php';

         $result2=mysqli_query($con,"select 
         	                             gp_checkinout.userid,
         	                             gp_checkinout.lokasi,
         	                             lokasi.nama as nm_lokasi,
                                       gp_checkinout.nama,
                                       gp_checkinout.alamat,
                                       gp_checkinout.checktime 
                                  from 
                                    gp_checkinout,
                                    lokasi
                                  where
                                    gp_checkinout.lokasi=lokasi.id and
                                    gp_checkinout.id ='".decrypt(xss('id'))."'");
       $data=mysqli_fetch_array($result2);

       echo '<input type="hidden" id="nik" name="nik" value="'.$data['userid'].'">';
       echo '<input type="hidden" id="lokasi" name="lokasi" value="'.$data['lokasi'].'">';
       echo '<input type="hidden" id="nama" name="nama" value="'.$data['nama'].'">';
       echo '<input type="hidden" id="alamat" name="alamat" value="'.$data['alamat'].'">';

       if($data){
	       buat_qr($data['nm_lokasi']);
	       include 'tampil_qr.php';
	   }else{
	   	   echo '<h1>Data tidak ada</h1>';
      	   echo '<a href="index"><button type="button" class="btn btn-round btn-warning btn-lg">OK</button></a>';	
	   }    
     
?>

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/mainjquery.js"></script>
<script type="text/javascript">
    function close_window() {
 /* if (confirm("Terima kasih atas kunjungan anda..")) {*/
    $(location).attr('href', 'index');

 /* }*/
}
</script>
 <script type="text/javascript">
      
          $('#cekout').click(function (result) {   
            var lokasi= $("#lokasi").val();
            var nik =   $("#nik").val();    
            var nama =   $("#nama").val();
            var alamat =   $("#alamat").val();      

            $.post(
              'cekout', { 
                lokasi: lokasi, 
                nik:   nik,
                nama:   nama,
                alamat:   alamat
              }, function () {
            
                close_window();
                return false;
              }
            );
           
          });
     
        </script>
  </form>
                </section>   
            </div>
        </div>   
       </div>
    </body>
</html>
