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


// Exporter
$exporter = new PackageExporter();


echo "<html>";
echo "<head>";
echo '<link rel="stylesheet" type="text/css" href="theme/css/main.css">';
echo "</head>";
echo "<body>";
echo "<div class=\"page\">";
echo $interfaceCreator->buildInterface($finalPackage);
echo "</div>";
echo "<div id=\"exports\">";
echo json_encode($exporter->exportPackage($finalPackage));
echo "</div>";
echo "</body></html>";
