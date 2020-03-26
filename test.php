<?php

use Model\PriceImporter;
use Model\Pricing;
use Model\Terminal;

include 'bootstrap.php';

// load price data
$importer = new PriceImporter('prices.csv');
try {
    $priceData = $importer->getPriceData();
} catch (Exception $e) {
    echo $e->getMessage();
    exit;
}

// set up terminal and pricing
$pricing = new Pricing($priceData);
$terminal = new Terminal();
$terminal->setPricing($pricing);

// scan test products
$tests = ['ABCDABAA', 'CCCCCCC', 'ABCD'];
$eol = php_sapi_name() === 'cli' ? "\n" : '<br>';
foreach ($tests as $test) {
    echo "Running test for pattern $test $eol";
    $terminal->reset();
    $chars = str_split(($test));
    foreach ($chars as $char) {
        $terminal->scan($char);
    }
    echo 'Result: $' . $terminal->total . $eol;
}
