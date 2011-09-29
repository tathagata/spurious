<html>
<head>
<meta name = "viewport" content = "width = device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=no;">	
<link rel="stylesheet" type="text/css" media="all" href="http://trina.ch/berlinhackfest/curious/style.css" />
<link rev="canonical" type="text/html" href="http://trina.ch/berlinhackfest/curious" />
<script type="text/javascript" src="js/jquery.js"></script>

<script src="http://code.google.com/apis/gears/gears_init.js" type="text/javascript" charset="utf-8"></script>
<script src="js/geo.js" type="text/javascript" charset="utf-8"></script>
<script src="js/mapping.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script src="https://www.google.com/jsapi?key=ABQIAAAAEuwUqFVvNIBr6HOzKB5bChSeo-zD9t-xtZqO38hYJbYqntkDphTN7cSL-plbi9qxYVTuyFpMTyatQA" type="text/javascript"></script>


<style>
	body {font-family: Helvetica;font-size:11pt;padding:0px;margin:0px}
	#title {background-color:#e22640;padding:5px;}
	#current {font-size:10pt;padding:5px;}	
</style>
</head>
<?php //$_SESSION['twitter_profile'];?>
<body onLoad="initialize_map();initialize()">
<?php
require_once("twitteroauth/twitteroauth.php");
//session_start();
// user accepted access
	if( !isset($_COOKIE['oauth_token']) || !isset($_COOKIE['oauth_token_secret']) )
	{
		// user comes from twitter
		//echo $_GET['oauth_token'];
		$twitterObj = new EpiTwitter('dwP6Jmpcmu9rlh0K47qaA','DLUQwbCeVJUASw5ASoEoplUr8sxkoQhhNgxxhqZfs');
 
	    	$twitterObj->setToken($_GET['oauth_token']);
		$token = $twitterObj->getAccessToken();
		setcookie('oauth_token', $token->oauth_token);
		setcookie('oauth_token_secret', $token->oauth_token_secret);
		$twitterObj->setToken($token->oauth_token, $token->oauth_token_secret);

	}
	else
	{
	 // user switched pages and came back or got here directly, stilled logged in
	 $twitterObj->setToken($_COOKIE['oauth_token'],$_COOKIE['oauth_token_secret']);
	}

    $user= $twitterObj->get_accountVerify_credentials();
	echo "
	<p>
	Username: <br />
	<strong>{$user->screen_name}</strong><br />
	Profile Image:<br/>
	<img src=\"{$user->profile_image_url}\"><br />
	Last Tweet: <br />
	<strong>{$user->status->text}</strong><br/>

	</p>

	<div id=\"header\"><h1>Hi <?php echo $user->screen_name; ?>, feeling curious?</h1>
	<p><img src=\"{$user->profile_image_url}\" />;</p>
            
        </ul>
	</div>
	<div id=\"title\">Show Position In Map</div>
	<div id=\"current\">Initializing...</div>
	<div id=\"map_canvas\" style=\"width:320px; height:350px\"></div>
	<div id=\"news\"></div>
</body>
</html>";
?>

