<?php

require('../vendor/autoload.php');

$app = new Silex\Application();
$app['debug'] = true;

// Register the monolog logging service
$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => 'php://stderr',
));

// Our web handlers

$app->get('/', function() use($app) {

    $app['monolog']->addDebug('logging output.');

    $email = "";
    $campaign = "";

    $return_string = "";

    if (isset($_GET['utm_content'])) {
        $email = $_GET['utm_content'];
    }
    if (isset($_GET['utm_source'])) {
        $campaign = $_GET['utm_source']; 
    }


    $RELATE_IQ_API_KEY = "54344ba3e4b00c4eb44c60dc"
    $RELATE_IQ_API_SECRET = "XXv17NeOIBhFFBbOAjDC94MdH7A"
    $url = "https://api.relateiq.com/v2/contacts?properties.email=lou@ginkgotree.com";

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_USERPWD, $RELATE_IQ_API_KEY . ":" . $RELATE_IQ_API_SECRET);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($curl);

    curl_close($curl);

    $return_string .= "VAR DUMP: " . var_dump(json_decode($result, true));

    $return_string .= "<br>Email: " . $email . "<br>Campaign: " . $campaign; 

    return $return_string;

});

$app->run();

?>
