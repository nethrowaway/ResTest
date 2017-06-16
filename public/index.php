<?php

define('APP_PATH', dirname(__DIR__));

// autoload via composer
include_once APP_PATH . '/vendor/autoload.php';

// initialise
date_default_timezone_set("Europe/London");
$metadataHelper = new ResTest\Helpers\Metadata();

// allow for category to be sent as an optional parameter
$category = 'Digitalia';
if (!empty($_GET['category'])) {
    $category = $_GET['category'];
}

// run script
$app = new ResTest\BlackInkParser($metadataHelper);
echo $app->parseLinksInCategory($category);