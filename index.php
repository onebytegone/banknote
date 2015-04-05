<?php

require 'environment.php';
require 'code/require.php';


function getJSON($filename) {
   return json_decode(file_get_contents($filename), true);
}

$converter = new SourceDataConverter(getJSON('config/source-conversion.json'));
$initialPackage = $converter->convertInput(getJSON('demo/demo-data.json'));

// Setup data steps
$stepConfig = json_decode(file_get_contents('config/data-steps.json'), true);
$stepFactory = new CalculationStepFactory();
$steps = $stepFactory->generateStepList($stepConfig);


// Run calculations
$finalPackage = array_reduce($steps, function ($package, $step) {
   $package = $step->calculate($package);
   return $package;
}, $initialPackage);


// Generate output
$interfaceCreator = new InterfaceCreator();
$interfaceCreator->loadFromConfig(getJSON('config/interface-tables.json'));

echo $interfaceCreator->buildInterface($finalPackage);
