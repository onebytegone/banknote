<?php

/**
 * @copyright 2015 Ethan Smith
 */
class SourceDataConverter {
   public $config = array();
   public $conversionMapping = array(
      'single_store' => 'createStore',
      'array_of_stores' => 'createSetOfStores',
   );

   public function __construct($configData) {
      $this->config = $configData;
   }

   public function convertInput($data) {
      if (!$data) {
         return null;
      }

      $keys = array_keys($data);
      $self = $this;
      return array_filter(array_combine($keys, array_map(function($name, $dataEntry) use ($self) {
         $settings = $self->config[$name];
         if ($settings) {
            $method = $self->conversionMapping[$settings['conversion']];
            return $self->$method($dataEntry);
         }
         return null;
      }, $keys, $data)));
   }

   public function createStore($data) {
      $entries = array_map(function ($item) {
         $entry = new AmountEntry();
         $entry->amount = $item['amount'];
         $entry->date = $item['date'];
         $entry->name = isset($item['name']) ? $item['name'] : '';
         $entry->note = isset($item['note']) ? $item['note'] : '';
         $entry->timePeriod = TimePeriod::fetchTimePeriodByMonthAndDay($entry->date);
         return $entry;
      }, $data);

      return new TemporalItemStore($entries);
   }

   public function createSetOfStores($data) {
      return array_map(array($this, 'createStore'), $data);
   }
}
