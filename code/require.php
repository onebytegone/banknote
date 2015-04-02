<?php

require 'MasterConfigParser.php';
require 'model/temporal/TimePeriod.php';
require 'model/temporal/TemporalItem.php';
require 'model/temporal/TemporalItemStore.php';
require 'model/AmountEntry.php';
require 'model/elements/TableElement.php';
require 'calculate/IncomeCalculate.php';
require 'calculate/AmountCalculate.php';
require 'formatter/ItemStoreTableFormatter.php';
require 'formatter/ItemStoreGeneralFormatter.php';
require 'formatter/store/ItemStoreArrayMap.php';
require 'formatter/combiner/EntrySumCombiner.php';
require 'formatter/entry/EntryFieldFormatter.php';
require 'formatter/ui/TableGenerator.php';
require 'steps/CalculationStep.php';
require 'steps/TotalForPeriod.php';
require 'steps/TotalByCategory.php';
require 'steps/DifferenceOfStores.php';
require 'factory/EntryFactory.php';
require 'factory/AmountEntryFactory.php';
require 'factory/CalculationStepFactory.php';
require 'interface/InterfaceCreator.php';
require 'interface/generator/OutputTableGenerator.php';
require 'conversion/SourceDataConverter.php';
