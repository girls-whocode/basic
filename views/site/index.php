<?php

/** @var yii\web\View $this */

$this->title = Yii::$app->name;

class FuzzyDateParser 
{   
    public $verbose = false;

    public $result;

    public $hasFailed = false;


    public static function fromText($text) 
    {
        $instance = new FuzzyDateParser();
        return $instance->parse($text);
    }

    public function parse($text)
    {   
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

    function __toString()
    {        
        return ($this->hasFailed) ? '' : sprintf(
            '%04d-%02d-%02d', 
            $this->result['year'], 
            $this->result['month'], 
            $this->result['day']
        );
    }

}
?>
<div class="site-index">
  <?= date("l jS \of F Y h:i:s A") ?>
</div>
