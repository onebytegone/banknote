<?php

require 'environment.php';
require 'code/require.php';

// NOTE: temp data. should be paresed from user data source
$incomeEntries = new TemporalItemStore();
$incomeToFund = new TemporalItemStore();
$expenseEntries = new TemporalItemStore();
$fundDraw = new TemporalItemStore();



// Package setup
$initialPackage = array(
   'sto_usr_income_entries' => $incomeEntries,
   'sto_usr_income_to_fund' => $incomeToFund,
   'sto_usr_expense_entries' => $expenseEntries,
   'sto_usr_fund_draw' => $fundDraw,
);

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

$tableGenerator = new OutputTableGenerator();
$tableGenerator->fieldName = 'sto_usr_income_entries';

$interfaceCreator->generators = array($tableGenerator);

echo $interfaceCreator->buildInterface($finalPackage);
