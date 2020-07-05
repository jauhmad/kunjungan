<?php
$dbuser = "root";
$dbpass = "";
$dbname = "sim_kunjungandb";
$dbhost = "localhost";

$con = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);

if (!$con) {
  echo "Failed to connect to MySQL";
  exit();
}

$judul="SinonaKU";
$title=$judul.' | Pemerintah Kabupaten Kulon Progo';
$set_tahun="2020";

$footer="&copy; Maret 2020 - ".date('Y')." Pemerintah Kabupaten Kulon Progo";

function cleanurl($url){
    $url = strtok($url, "?");
    return $url;
}

function tgl_format_indo($tgl){
	$get_tgl=substr($tgl,8,2);    
    $get_bln=substr($tgl,5,2);    
    $get_thn=substr($tgl,0,4);              
	$hasil=$get_tgl.'-'.$get_bln.'-'.$get_thn;
	return $hasil;
}

function tgl_format_itl($tgl){
	$dt=explode("-",$tgl);
	$tanggal=$dt[2].'-'.$dt[1].'-'.$dt[0];
	return $tanggal;
}

function format_rp($angka){
    $hasil = number_format($angka, 2, '.', ',');
	 return $hasil;
}


function cleantext ($text,$html=true) {
        global $con;
        $text = preg_replace( "'<script[^>]*>.*?</script>'si", '', $text );
        $text = preg_replace( '/<a\s+.*?href="([^"]+)"[^>]*>([^<]+)<\/a>/is', '\2 (\1)', $text );
        $text = preg_replace( '/<!--.+?-->/', '', $text );
        $text = preg_replace( '/{.+?}/', '', $text );
        $text = preg_replace( '/&nbsp;/', ' ', $text );
        $text = preg_replace( '/&amp;/', '&', $text );
        $text = preg_replace( '/&quot;/', '"', $text );
        $text = strip_tags( $text );
        $text = preg_replace("/\r\n\r\n\r\n+/", " ", $text);
        $text = $html ? htmlspecialchars( $text ) : $text;
        $text = mysqli_real_escape_string($con,$text);
        return $text;
}

function bilanghari($tanggal){  
    $day = date('D', strtotime($tanggal));
    $dayList = array(
    	'Sun' => 'Minggu',
    	'Mon' => 'Senin',
    	'Tue' => 'Selasa',
    	'Wed' => 'Rabu',
    	'Thu' => 'Kamis',
    	'Fri' => 'Jumat',
    	'Sat' => 'Sabtu'
    );
    return $dayList[$day];
}

function bilangbulan($tanggal){ 
    if($tanggal=='0000-00-00')
    $day='00';
    else 
    $day = date('m', strtotime($tanggal));
    $dayList = array(
        '00' => '-',
    	'01' => 'Jan',
    	'02' => 'Feb',
    	'03' => 'Mar',
    	'04' => 'Apr',
    	'05' => 'Mei',
    	'06' => 'Jun',
    	'07' => 'Jul',
    	'08' => 'Agt',
    	'09' => 'Sep',
    	'10' => 'Okt',
    	'11' => 'Nov',
    	'12' => 'Des'
    );
    return $dayList[$day];
}

function namabulan($t){  
    $dayList = array(
        '01' => 'Januari',
        '02' => 'Februari',
        '03' => 'Maret',
        '04' => 'April',
        '05' => 'Mei',
        '06' => 'Juni',
        '07' => 'Juli',
        '08' => 'Agustus',
        '09' => 'September',
        '10' => 'Oktober',
        '11' => 'November',
        '12' => 'Desember',
        '1' => 'Januari',
        '2' => 'Februari',
        '3' => 'Maret',
        '4' => 'April',
        '5' => 'Mei',
        '6' => 'Juni',
        '7' => 'Juli',
        '8' => 'Agustus',
        '9' => 'September'
    );
    return $dayList[$t];
}


//security function
function asi($unsafe_variable){
    global $con;
     $text = preg_replace( "'<script[^>]*>.*?</script>'si", '', $unsafe_variable );
        $text = preg_replace( '/<a\s+.*?href="([^"]+)"[^>]*>([^<]+)<\/a>/is', '\2 (\1)', $text );
        $text = preg_replace( '/<!--.+?-->/', '', $text );
        $text = preg_replace( '/{.+?}/', '', $text );
        $text = preg_replace( '/&nbsp;/', ' ', $text );
        $text = preg_replace( '/&amp;/', '&', $text );
        $text = preg_replace( '/&quot;/', '"', $text );
        $text = strip_tags( $text );
        $text = preg_replace("/\r\n\r\n\r\n+/", " ", $text);
        // $text = $html ? htmlspecialchars( $text ) : $text;
        $safe_variable = mysqli_real_escape_string($con,$text);
    return trim($safe_variable);
}

//xss GET
function xss($search){
       $_GET[$search]= !isset($_GET[$search]) ? null : $_GET[$search];
       $search = $_GET[$search]; 
       $search =  htmlspecialchars($search, ENT_QUOTES, 'UTF-8');

       if($search==null)
         return $search;
       else
         return $search;
   
}

//https://blog.teamtreehouse.com/how-to-create-bulletproof-sessions
function validateSession()
{
    if( isset($_SESSION['OBSOLETE']) && !isset($_SESSION['EXPIRES']) )
        return false;

    if(isset($_SESSION['EXPIRES']) && $_SESSION['EXPIRES'] < time())
        return false;

    return true;
}

function preventHijacking()
{
    if(!isset($_SESSION['IPaddress']) || !isset($_SESSION['userAgent']))
        return false;

    if ($_SESSION['IPaddress'] != $_SERVER['REMOTE_ADDR'])
        return false;

    if( $_SESSION['userAgent'] != $_SERVER['HTTP_USER_AGENT'])
        return false;

    return true;
}

function regenerateSession()
{
    // If this session is obsolete it means there already is a new id
    if(isset($_SESSION['OBSOLETE']) || (isset($_SESSION['OBSOLETE']) && $_SESSION['OBSOLETE'] == true))
        return;

    // Set current session to expire in 10 seconds
    $_SESSION['OBSOLETE'] = true;
    $_SESSION['EXPIRES'] = time() + 10;

    // Create new session without destroying the old one
    session_regenerate_id(false);

    // Grab current session ID and close both sessions to allow other scripts to use them
    $newSession = session_id();
    session_write_close();

    // Set session ID to the new one, and start it back up again
    session_id($newSession);
    session_start();

    // Now we unset the obsolete and expiration values for the session we want to keep
    unset($_SESSION['OBSOLETE']);
    unset($_SESSION['EXPIRES']);
}

function sessionStart($name, $limit = 0, $path = '/', $domain = null, $secure = null)
{
    // Set the cookie name
    @session_name($name . '_Session'); //@-php7

    // Set SSL level
    $https = isset($secure) ? $secure : isset($_SERVER['HTTP']);

    // Set session cookie options
    @session_set_cookie_params($limit, $path, $domain, $https, true); 
   // @session_regenerate_id(true); 
    @session_start();

    // Make sure the session hasn't expired, and destroy it if it has
    if(validateSession())
    {
        // Check to see if the session is new or a hijacking attempt
        if(!preventHijacking())
        {
            // Reset session data and regenerate id
            $_SESSION = array();
            $_SESSION['IPaddress'] = $_SERVER['REMOTE_ADDR'];
            $_SESSION['userAgent'] = $_SERVER['HTTP_USER_AGENT'];
            regenerateSession();

        // Give a 5% chance of the session id changing on any request
        }elseif(rand(1, 100) <= 5){
            regenerateSession();
        }
    }else{
        $_SESSION = array();
        session_destroy();
        session_start();
        header("location:logout");
        exit();
    }
}

function session_exp(){
   $_SESSION['EXPIRES'] = time()+(24*60);// 24 menit
}




function umur($birthday){
    // Convert Ke Date Time
 if(strtotime($birthday)){
    
    $biday = new DateTime($birthday);
    $today = new DateTime();
    
    $diff = $today->diff($biday);
    
   
    return $diff->y;
  }
}

function bln_diff($date1, $date2)
{
$timeStart = strtotime("$date1");
$timeEnd = strtotime("$date2");
// Menambah bulan ini + semua bulan pada tahun sebelumnya
$numBulan = 1 + (date("Y",$timeEnd)-date("Y",$timeStart))*12;
// menghitung selisih bulan
$numBulan += date("m",$timeEnd)-date("m",$timeStart);

return $numBulan;
}

$actual_link = "{$_SERVER['REQUEST_URI']}";
$remote_addr = $_SERVER["REMOTE_ADDR"];
?>

<?php
function polaurl($end) {
$adr=$_SERVER['PHP_SELF'];
$alamat=explode("/",$adr);
$akhir=end($alamat);
$_RESULT=str_replace("$akhir","",$adr);
echo $_SERVER['HTTP_HOST'],$_RESULT,$end;
}


function my_simple_crypt( $string, $action = 'e' ) {
    // you may change these values to your own
    $secret_key ='453r';
    $secret_iv = '6ygf';
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $key = hash( 'sha256', $secret_key );
    $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
    if( $action == 'e' ) {
        $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
    }
    else if( $action == 'd' ){
        $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
    }
    return $output;
}

function encrypt($string){
       return my_simple_crypt( $string, 'e' );
}
function decrypt($string){
       return my_simple_crypt( $string, 'd' );
}

function encrypt_pwd($string){
    $secret_key = '6tgtr6y6tr7yhdhHjYT78J6yhyYYhuHHujy67';
    $secret_iv = '5Tyhg68HHgtrg67gi1aAAcvFisa9mYu7jg';
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $key = hash( 'sha256', $secret_key );
    $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
    $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
    return $output;
}


function notif($mode, $txt, $page){
 $_SESSION['notif']=$mode;
 $_SESSION['txt']=$txt;
 header("location:".$page);
 exit();
}

function buat_qr($codeContents){
       include "phpqrcode/qrlib.php"; 
       $tempdir = "images/"; 
       if (!file_exists($tempdir)) mkdir($tempdir);
       $logopath="images/logo.png";
       //$codeContents = $data['nama']; 

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
         return;
}

?>