<?php
include 'lib/EpiCurl.php';
include 'lib/EpiOAuth.php';
include 'lib/EpiTwitter.php';
include 'lib/secret.php';

$Twitter = new EpiTwitter('dwP6Jmpcmu9rlh0K47qaA', 'DLUQwbCeVJUASw5ASoEoplUr8sxkoQhhNgxxhqZfs');
echo 'Here is stuff';
echo '<a href="' . $Twitter->getAuthenticateUrl() . '"><img src="twitterButton.png" alt="sign in with twitter" /></a>';

if(isset($_GET['oauth_token']) || (isset($_COOKIE['oauth_token']) && isset($_COOKIE['oauth_token_secret'])))
{
  // user has signed in
}
elseif(isset($_GET['denied'])
{
 // user denied access
 echo 'You must sign in through twitter first';
}
else
{
// user not logged in
 echo 'You are not logged in';
}



?>
