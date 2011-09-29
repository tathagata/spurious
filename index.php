<html>
<head>
<meta name = "viewport" content width = device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=no;">	
<link rel="stylesheet" type="text/css" media="all" href="http://trina.ch/berlinhackfest/curious/demo.css" />
<link rev="canonical" type="text/html" href="http://trina.ch/berlinhackfest/curious" />
<script type="text/javascript" src="js/jquery.js"></script>
<script src="http://code.google.com/apis/gears/gears_init.js" type="text/javascript" charset="utf-8"></script>
<script src="js/geo.js" type="text/javascript" charset="utf-8"></script>
<script src="js/mapping.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script src="https://www.google.com/jsapi?key=ABQIAAAAEuwUqFVvNIBr6HOzKB5bChSeo-zD9t-xtZqO38hYJbYqntkDphTN7cSL-plbi9qxYVTuyFpMTyatQA" type="text/javascript"></script>
</head>
<body onLoad="initialize_map();initialize()">
	<div id="header">
    	<h1>I'm curious about...</h1>
		<ul>
			<li>add event</li>
            <li>find event</li>
        </ul>
	</div>
<?php
include 'lib/EpiCurl.php';
include 'lib/EpiOAuth.php';
include 'lib/EpiTwitter.php';
include 'lib/secret.php';

$twitterObj = new EpiTwitter('dwP6Jmpcmu9rlh0K47qaA','DLUQwbCeVJUASw5ASoEoplUr8sxkoQhhNgxxhqZfs');
//$oauth_token = $_GET['oauth_token'];

if(isset($_GET['oauth_token']) || (isset($_COOKIE['oauth_token']) && isset($_COOKIE['oauth_token_secret'])))
{

// user accepted access
	if( !isset($_COOKIE['oauth_token']) || !isset($_COOKIE['oauth_token_secret']) )
	{
		// user comes from twitter
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
<html>
<head>
<meta name = \"viewport\" content = \"width = device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=no;\">	
<link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"http://trina.ch/berlinhackfest/curious/demo.css\" />
<link rev=\"canonical\" type=\"text/html\" href=\"http://trina.ch/berlinhackfest/curious\" />
<script type=\"text/javascript\" src=\"js/jquery.js\"></script>

<script src=\"http://code.google.com/apis/gears/gears_init.js\" type=\"text/javascript\" charset=\"utf-8\"></script>
<script src=\"js/geo.js\" type=\"text/javascript\" charset=\"utf-8\"></script>
<script src=\"js/mapping.js\" type=\"text/javascript\" charset=\"utf-8\"></script>
<script type=\"text/javascript\" src=\"http://maps.google.com/maps/api/js?sensor=false\"></script>
<script src=\"https://www.google.com/jsapi?key=ABQIAAAAEuwUqFVvNIBr6HOzKB5bChSeo-zD9t-xtZqO38hYJbYqntkDphTN7cSL-plbi9qxYVTuyFpMTyatQA\" type=\"text/javascript\"></script>
<script type=\"text/javascript\" src=\"http://tweet-it.st.pongsocket.com/tweet-it.js\"></script>
<script type='text/javascript' src='http://trina.ch/wp-content/themes/trina/js/switch.js'></script>

</head>
<body onLoad=\"initialize_map();initialize()\">
	<div id=\"header\">
    	<h1>I'm curious about...</h1>
		<ul>
			<li>add event</li>
            <li>find event</li>
        </ul>
	</div>
    <div id=\"content\">
    	<div id=\"map\">
            <div id=\"title\">Show Position In Map</div>
            <div id=\"current\">Initializing...</div>
            <div id=\"options\">
            	<ul class=\"switches\">
            		<li class=\"active\" id=\"add\"><a href=\"#\">Post</a></li>
                    <li id=\"explore\"><a href=\"#\">Explore</a></li>
                </ul>
            </div>
            <div class=\"slides\">
            	<div id=\"post\" class=\"active\">
                    <div id=\"input\">
                        <div id=\"tweet-bar\"><input type=\"text\" name=\"tweet\" placeholder=\"I'm curious about...\"></div>
                        <div id=\"controls\">
                            <div id=\"add-image\"></div>
                            <div id=\"tweet\"></div>
                        </div>
                    </div><!-- end input -->
                    <!--<div id=\"news\"></div>-->
                </div><!-- end #post -->
                <div>
                	<div id=\"output\">
                    <iframe src=\"http://finden.colegillespie.com\" width=\"800\" height=\"350\"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- end content -->
</body>
</html>";
}

elseif(isset($_GET['denied']))
{
 // user denied access
 echo 'You must sign in through twitter first';
}
else
{
// user not logged in
 echo 'You are not logged in';
$url = $twitterObj->getAuthorizationUrl();
 echo "<div style='width:200px;margin-top:200px;margin-left:auto;margin-right:auto'>";
 echo "<a href='$url'>Sign In with Twitter</a>";
 echo "</div>";
}


	if(isset($_POST['submit']))
	  {
	  	$msg = $_REQUEST['tweet'];
		
		$twitterObj->setToken($_SESSION['ot'], $_SESSION['ots']);
		$update_status = $twitterObj->post_statusesUpdate(array('status' => $msg));
		$temp = $update_status->response;
	
		echo "<b>Update status:".$temp."</b>";	
		#echo "<div align='center'>Updated your Timeline Successfully .</div>";
		
	  }

	  echo "<div style='margin-top:100px;'>";
	  echo "<p>";
	  echo "<center>";
	  echo "</center>";
	  echo "</p>";
	  echo "</div>";
?> 
