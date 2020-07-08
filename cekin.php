<?php
if(empty($_POST['nik']) || empty($_POST['lokasi'])  ){
 exit(); 
}
include 'inc/inc_con_db.php';

    $nik=asi($_POST['nik']);
    $lokasi=decrypt(asi($_POST['lokasi']));
    
    $cek_nik=cek_nik($nik);
    $jsonArray = json_decode($cek_nik,true);
    if(isset($jsonArray['content'][0]['NAMA_LGKP'])){
        $nama = $jsonArray['content'][0]['NAMA_LGKP'];
        $alamat = $jsonArray['content'][0]['ALAMAT'];
        $kab = $jsonArray['content'][0]['KAB_NAME'];
        $rw = $jsonArray['content'][0]['NO_RW'];
        $rt = $jsonArray['content'][0]['NO_RT'];
        $kec = $jsonArray['content'][0]['KEC_NAME'];
        $prov = $jsonArray['content'][0]['PROP_NAME'];
        $desa = $jsonArray['content'][0]['KEL_NAME'];
 
        $alamat=$alamat.', RT.'.$rt.', RW.'.$rw.', '.$desa.', '.$kec.', '.$kab.', '.$prov;
    }

    if(empty($nama)) $cek_nik=false; else $cek_nik=true;

    if(!$cek_nik){
      echo '<h1>NIK tidak valid</h1>';
      echo '<a href="index"><button type="button" class="btn btn-round btn-warning btn-lg">OK</button></a>';
      exit();
    }

    $cek_lok=mysqli_num_rows( mysqli_query($con,"select * from lokasi where id='".$lokasi."'") );
    if($cek_lok==0){
      echo '<h1>Lokasi tidak terdaftar</h1>';
      echo '<a href="index"><button type="button" class="btn btn-round btn-warning btn-lg">OK</button></a>';
      exit();
    }

    $result=mysqli_query($con,"insert into gp_checkinout set 
                userid='".$nik."',
                nama='".$nama."',
                alamat='".$alamat."',
                lokasi='".$lokasi."',
                checktype='1'
            ");
     $last_id = mysqli_insert_id($con);

   
       echo '<input type="hidden" id="nik" name="nik" value="'.$nik.'">';
       echo '<input type="hidden" id="lokasi" name="lokasi" value="'.$lokasi.'">';
       echo '<input type="hidden" id="nama" name="nama" value="'.$nama.'">';
       echo '<input type="hidden" id="alamat" name="alamat" value="'.$alamat.'">';

       setcookie('NIKKunjunganCookie',$nik,mktime (0, 0, 0, 12, 31, 2050)); 
       setcookie('CekinCookie', $last_id ,mktime (0, 0, 0, 12, 31, 2050)); 

       $result2=mysqli_query($con,"select  
                                         gp_checkinout.userid,
                                         gp_checkinout.lokasi,
                                         lokasi.nama as nm_lokasi,
                                         gp_checkinout.nama as nama,
                                         gp_checkinout.checktime 
                                  from 
                                    gp_checkinout,
                                    lokasi
                                  where
                                    gp_checkinout.lokasi=lokasi.id and
                                    gp_checkinout.id ='".$last_id."'");
       $data=mysqli_fetch_array($result2);

       buat_qr($data['nm_lokasi']);
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

