<?php
add_action( 'wp_ajax_submit_to_effectcheck', 'submit_to_effectcheck');

/* AJAX action handler for WP integration 
  - Submit content to EffectCheck for sentiments
*/
function submit_to_effectcheck(){
  $username = get_option('effectcheck_username'); // "team6";
  $password = get_option('effectcheck_password'); // "eiMVcC2P1MpzPRlg2tG8DFZfJWaRzUqWVF6hIpxqeRQZy4kAGpGDhRGP9hB6baQW";

  if(!$username || !$password) die("Please set your EffectCheck API username and password.");

  /* URL to the EC API */
  $url = "http://effectcheck.com/RestApi/Score";

  $content = ($_POST['content']) ? $_POST['content'] : $_GET['content'];

  /* Handle JSONP if needed to */
  $jsoncallback = ($_POST['callback']) ? $_POST['callback'] : $_GET['callback'];

  $headers = ($_POST['headers']) ? $_POST['headers'] : $_GET['headers'];
  $mimeType =($_POST['mimeType']) ? $_POST['mimeType'] : $_GET['mimeType'];

  /* Construct post data */
  $postData = array('content' => $content, 'category' => 'Generic');

  /* Constructing the curl POST VARS */
  $postvars = '';
  while ($data = current($postData)) {
   $postvars .= urlencode(key($postData)).'='.urlencode($data).'&';
   next($postData);
  }

  $session = curl_init($url);
  curl_setopt($session, CURLOPT_USERPWD,"$username:$password"); 
  curl_setopt($session, CURLOPT_POST, true);
  curl_setopt($session, CURLOPT_POSTFIELDS, $postvars);
  curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
  // $response = '{}';
  try {
    $response = curl_exec($session);
  } catch (Exception $e) {
    echo $e;
    die("Error talking to EffectCheck");
  }


  if ($mimeType != "") {
    header("Content-Type: ".$mimeType);
  }

  /* Output Result */
  if( $jsoncallback ) {
    echo $jsoncallback . "(" . $response . ")";
  } else {
    echo $response;
  }
  curl_close($session);
  die();
};

?>