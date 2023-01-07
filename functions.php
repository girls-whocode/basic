<?php
  use yii\helpers\Url;
  use yii\helpers\Html;
  use yii\helpers\HtmlPurifier;
  use yii\helpers\ArrayHelper;

  // cents: 0=never, 1=if needed, 2=always
  function formatMoney($number, $cents = 2) { 
    if (is_numeric($number)) {
      if (!$number) {
        $money = ($cents == 2 ? '0.00' : '0');
      } else {

        if (floor($number) == $number) {
          $money = number_format($number, ($cents == 2 ? 2 : 0));
        } else {
          $money = number_format(round($number, 2), ($cents == 0 ? 0 : 2));
        }
      }
      return '$'.$money;
    }
  }

  function formatPhoneNumber($phoneNumber) {
    $phoneNumber = preg_replace('/[^0-9]/','',$phoneNumber);

    if(strlen($phoneNumber) > 10) {
      $countryCode = substr($phoneNumber, 0, strlen($phoneNumber)-10);
      $areaCode = substr($phoneNumber, -10, 3);
      $nextThree = substr($phoneNumber, -7, 3);
      $lastFour = substr($phoneNumber, -4, 4);
      $phoneNumber = '+'.$countryCode.' ('.$areaCode.') '.$nextThree.'-'.$lastFour;
    }
    else if(strlen($phoneNumber) == 10) {
      $areaCode = substr($phoneNumber, 0, 3);
      $nextThree = substr($phoneNumber, 3, 3);
      $lastFour = substr($phoneNumber, 6, 4);
      $phoneNumber = '('.$areaCode.') '.$nextThree.'-'.$lastFour;
    }
    else if(strlen($phoneNumber) == 7) {
      $nextThree = substr($phoneNumber, 0, 3);
      $lastFour = substr($phoneNumber, 3, 4);
      $phoneNumber = $nextThree.'-'.$lastFour;
    }

    return $phoneNumber;
  }

  class FuzzyDateParser {   
    public $verbose = false;
    public $result;
    public $hasFailed = false;

    public static function fromText($text) {
      $instance = new FuzzyDateParser();
      return $instance->parse($text);
    }

    public function parse($text) {   
      static $ignoredErrors = array(
        'The timezone could not be found in the database',
      );
      $this->result = date_parse($text);
      $errors = array();
      if ($this->result['error_count'] > 0) {
        foreach ($this->result['errors'] as $errorMessage) {
          if (!in_array($errorMessage, $ignoredErrors)) { 
            $errors[] = $errorMessage;
          }
        }
      }
      $this->result['error_count'] = count($errors);
      $this->result['errors'] = $errors;

      $this->hasFailed = ($this->result['error_count'] > 0 
        && $this->result['year'] === false 
        && $this->result['year'] === false 
        && $this->result['day'] === false);
      if ($this->hasFailed and $this->verbose) {
        print_r($this->result);
      }

      return $this;
    }

    function __toString() {        
      return ($this->hasFailed) ? '' : sprintf(
        '%04d-%02d-%02d', 
        $this->result['year'], 
        $this->result['month'], 
        $this->result['day']
      );
    }
  }
?>