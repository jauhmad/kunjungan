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


        <script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" src="js/qrcodelib.js"></script>
    
        <page>
            <div>
             <?php
              if(!isset($_COOKIE['NIKKunjunganCookie']) ) {
                   echo '<div>
                            <h1>NIK Anda</h1>
                            <input class="form-control" type="text" id="nik"  name="nik" placeholder="Masukkan NIK anda">
                         </div>   ';
              }else{
                   echo '<div>
                           <h1>NIK Anda</h1>
                            <input class="form-control" type="text" id="nik"  name="nik" value="'.$_COOKIE['NIKKunjunganCookie'].'" >
                         </div>  ';  
              }

               if(isset($_COOKIE['CekinCookie']) && $_COOKIE['CekinCookie']!='0' ) { 
                    include 'inc/inc_con_db.php';
                    $result=mysqli_query($con,"select * from gp_checkinout where id='".$_COOKIE['CekinCookie']."'"); 
                    $data=mysqli_fetch_array($result);

                 
                  header("location:bukti_kunjung?id=".encrypt($_COOKIE['CekinCookie']) );
                  exit();


               }

            ?>
            <h1>Scan QR Code</h1>
            <canvas></canvas>
            <div class="clearfix"></div>
            <div class="separator">
                <!-- <p class="change_link">New to site?
                  <a href="#signup" class="to_register"> Create Account </a>
                </p>
                 -->
                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><i class="fa fa-arrows-alt"></i> Tracing Kunjungan</h1>
                  <p>©2020 Pemerintah Kabupaten Kulon Progo</p>
                </div>
              </div>
         
        </page>

       
        <script type="text/javascript" src="js/webcodecamjquery.js"></script>
        <script type="text/javascript" src="js/mainjquery.js"></script>
        <script type="text/javascript">
            var arg = {
                resultFunction: function(result) {
                    //$('body').append($('<li>' + result.format + ': ' + result.code + '</li>'));
                   
                    var lokasi=result.code;
                    var nik = $("#nik").val();

                    $.post("cekin", {lokasi: lokasi, nik:nik}, function(result){
                        $("canvas").WebCodeCamJQuery(arg).data().plugin_WebCodeCamJQuery.stop();
                        $("page").html(result);
                       // $("#dnik").remove();
                      });

                   // $(location).attr('href', 'http://localhost/kunjungan');
                }
            };
            $("canvas").WebCodeCamJQuery(arg).data().plugin_WebCodeCamJQuery.play();
        </script>
     
                    </form>
                </section>   
            </div>
        </div>   
       </div>
    </body>
</html>