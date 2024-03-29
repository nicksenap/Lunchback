<?php
ini_set('error_reporting', E_ALL);
$config = include('config.php');

// Change these
define('API_KEY',      $api_key);
define('API_SECRET',   $secret_key);
define('REDIRECT_URI', $callbackURL);
define('SCOPE',        $linkedinScope);


// You'll probably use a database
session_name('linkedin');
session_start();

// OAuth 2 Control Flow
if (isset($_GET['error'])) {
    // LinkedIn returned an error
    print $_GET['error'] . ': ' . $_GET['error_description'];
    exit;
} elseif (isset($_GET['code'])) {
    // User authorized your application
    if ($_SESSION['state'] == $_GET['state']) {
        // Get token so you can make API calls
        getAccessToken();
    } else {
        // CSRF attack? Or did you mix up your states?
        exit;
    }
} else {
    if ((empty($_SESSION['expires_at'])) || (time() > $_SESSION['expires_at'])) {
        // Token has expired, clear the state
        $_SESSION = array();

    }
    if (empty($_SESSION['access_token'])) {
        // Start authorization process
        getAuthorizationCode();
    }
}
// Congratulations! You have a valid token. Now fetch your profile
$user = fetch('GET', '/v1/people/~:(id,first-name,last-name,headline,email-address,picture-url,industry,site-standard-profile-request,interests,summary,main-address,phone-numbers,skills:(skill))');
var_dump($user);
die;


function getAuthorizationCode() {
    $params = array('response_type' => 'code',
        'client_id' => API_KEY,
        'scope' => SCOPE,
        'state' => uniqid('', true), // unique long string
        'redirect_uri' => REDIRECT_URI,
    );
    // Authentication request
    $url = 'https://www.linkedin.com/uas/oauth2/authorization?' . http_build_query($params);
    // print_r($url);
    // Needed to identify request when it returns to us
    $_SESSION['state'] = $params['state'];
    // Redirect user to authenticate
    header("Location: $url");
    exit;

}

function getAccessToken() {
    $params = array('grant_type' => 'authorization_code',
        'client_id' => API_KEY,
        'client_secret' => API_SECRET,
         //'code' => $_GET['code'],
        'code' => 'AQQEhMFuvW87RkydiMhTFS2-caedNxsRX8nLN2E_Iv9LPjAy3gu5k52taRBVw9HNpaY7UC3uNhjvhbE2l_x4_yjN5IedSOwCTCSZuHa9Y_3w8N5xrHk',
        'redirect_uri' => REDIRECT_URI,
    );
    // Access Token request
    $url = 'https://www.linkedin.com/uas/oauth2/accessToken?' . http_build_query($params);
    // Tell streams to make a POST request
    $context = stream_context_create(
        array('http' =>
            array('method' => 'POST',
            )
        )
    );

    // Retrieve access token information
    $response = file_get_contents($url, false, $context);

    // Native PHP object, please
    $token = json_decode($response);

    // Store access token and expiration time
    $_SESSION['access_token'] = $token->access_token; // guard this! 
    $_SESSION['expires_in']   = $token->expires_in; // relative time (in seconds)
    $_SESSION['expires_at']   = time() + $_SESSION['expires_in']; // absolute time
    //print_r($_SESSION);
    return true;
}

function fetch($method, $resource, $body = '') {
    $params = array('oauth2_access_token' => $_SESSION['access_token'],
        'format' => 'json',
    );

    // Need to use HTTPS
    $url = 'https://api.linkedin.com' . $resource . '?' . http_build_query($params);
    // Tell streams to make a (GET, POST, PUT, or DELETE) request
    $context = stream_context_create(
        array('http' =>
            array('method' => $method,
            )
        )
    );

    // Hocus Pocus
    $response = file_get_contents($url, false, $context);

    // Native PHP object, please
    return json_decode($response);
}
