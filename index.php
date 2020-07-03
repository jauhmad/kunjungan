<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Tracing Kunjungan</title>
    </head>
    <body>
<?php
include 'inc/inc_con_db.php';

     if(!isset($_COOKIE[$cookie_name]) ) {
        echo '<div id="dnik"><input type="text" id="nik"  name="nik" placeholder="Masukkan NIK anda"></div>';
     }else{
        echo '<div id="dnik">NIK Anda <input type="text" id="nik"  name="nik" value="'.$_COOKIE[$cookie_name].'" ></div>';  
     }

?>
    
        
      
    	 <h3 id="toptitle">Scan QR Code</h3>
                <!-- <hr> -->
        <canvas></canvas>
       <!--  <hr> -->
        <ul></ul>
		<script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" src="js/qrcodelib.js"></script>
        <script type="text/javascript" src="js/webcodecamjquery.js"></script>
        <script type="text/javascript">
            var arg = {
                resultFunction: function(result) {
                    //$('body').append($('<li>' + result.format + ': ' + result.code + '</li>'));
                   
                    var lokasi=result.code;
                    var nik = $("#nik").val();

                    $.post("cekin", {lokasi: lokasi, nik:nik}, function(result){
                        $("canvas").WebCodeCamJQuery(arg).data().plugin_WebCodeCamJQuery.stop();
                        $("#toptitle").html(result);
                        $("#dnik").remove();
                      });

                   // $(location).attr('href', 'http://localhost/kunjungan');
                }
            };
            $("canvas").WebCodeCamJQuery(arg).data().plugin_WebCodeCamJQuery.play();
        </script>
       


    </body>
</html>