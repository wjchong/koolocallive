<?php
include_once("config.php");
function clear(){
	$a = explode("_", $_COOKIE['session_id']);
	$id = $a[0];
	$conn = $GLOBALS['conn'];
	$sql = "UPDATE users SET session = '', token = '' WHERE id = '$id'";
	unset($_COOKIE['session_id']);
    setcookie('session_id', '', time() - 3600, '/');
	if(mysqli_query($conn, $sql)){
		return true;
	}else{
		return false;
	}
	$_SESSION['login'] = null;
}

if(clear()){
	session_destroy();
	// mysqli_query($conn, "UPDATE users SET moengage_unique_id='' WHERE id='".$id."'");  
	header('location: login.php');

}else{
	echo "Error occuried. Please try again later.";
}

?>
<link rel="manifest" href="manifest.json">
<script type="text/javascript">
(function(i,s,o,g,r,a,m,n){
i['moengage_object']=r;t={}; q = function(f){return function(){(i['moengage_q']=i['moengage_q']||[]).push({f:f,a:arguments});};};
f = ['track_event','add_user_attribute','add_first_name','add_last_name','add_email','add_mobile',
'add_user_name','add_gender','add_birthday','destroy_session','add_unique_user_id','moe_events','call_web_push','track','location_type_attribute'];
for(k in f){t[f[k]]=q(f[k]);}
a=s.createElement(o);m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m);
i['moe']=i['moe'] || function(){n=arguments[0];return t;}; a.onload=function(){if(n){i[r] = moe(n);}};
})(window,document,'script','https://cdn.moengage.com/webpush/moe_webSdk.min.latest.js','Moengage');

Moengage = moe({
app_id:"YJQ9WUT6IU77C9FVFWJWUILT",
debug_logs: 0
});
//Moengage.destroy_session();
</script>
