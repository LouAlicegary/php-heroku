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

    $return_string .= "Email: " . $email . "\nCampaign: " . $campaign; 

    return $return_string;

});

$app->run();

?>
