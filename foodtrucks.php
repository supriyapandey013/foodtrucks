<?php
/* error_reporting(1);
   ini_set('display_errors', 1);
   ini_set('display_startup_errors', 1);
   error_reporting(E_ALL);  */
function getcontent($url){
$ch = curl_init();
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json;charset=UTF-8',));
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); 
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0); 
$response = curl_exec($ch);
if(curl_errno($ch)) { curl_close($ch); return ;}
curl_close($ch);
$responseData=json_decode($response,true);
return $responseData;
}



ob_start();
$resource=getcontent('https://data.sfgov.org/resource/rqzj-sfat.json?status=APPROVED');
ob_end_clean();
//print_r($resource);
?>
<html>
<head>
</head>
<body>


<hr>
<?php if(empty($_POST['submit'])){ ?>
<form method="post" > <button type="submit" name="submit" value="1">Search In Your Place</button> </form>
<?php }else{ 
$PublicIP = $_SERVER['REMOTE_ADDR'];
$json     = file_get_contents("http://ipinfo.io/$PublicIP/geo");
$json     = json_decode($json, true);
echo $json['country'].' - '.$json['region'].' - '.$json['city'].'('.$json['loc'].')';
 } ?>
<hr>

<table border="10px">

<tr>
<th>Owner</th>
<th>Location</th>
<th>Address</th>
<th>Items</th>
</tr>

<?php foreach($resource as $k => $movie) { ?>
<tr>
<td><?php echo $movie['applicant']; ?></td>
<td><?php echo $movie['locationdescription']; ?></td>
<td><a target="_blank" href="https://maps.google.com/?q=<?php echo $movie['latitude']; ?>,<?php echo $movie['longitude']; ?>" >
<?php echo $movie['address']; ?></a></td>
<td><?php echo $movie['fooditems']; ?></td>
</tr>
<?php } ?>

</table>
<hr>
<br>


</body>
</html>

<script>

</script>