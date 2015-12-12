<?php

require_once 'aw/Object.php';

class MyObject extends \aw\Object {
    private $_property = null;
    public function getProperty(){
        return 'GET-'.$this->_property;
    }
    public function setProperty($value){
        $this->_property = 'SET-'.$value;
    }
    public function getData(){
        return 'DATA:'.$this->hiddenProperty;
    }
    protected function getHiddenProperty(){
        return 'hidden value';
    }
}

$instance = new MyObject();
echo $instance->property.PHP_EOL; // GET-
$instance->property = 'something';
echo $instance->property.PHP_EOL; // GET-SET-something
echo $instance->getData().PHP_EOL; // DATA:hidden value
echo $instance->data.PHP_EOL; // DATA:hidden value
echo $instance->anyProperty.PHP_EOL; // throws error Property accessor "anyProperty" not found.

class StringProperty extends \aw\Object {
    private $_property = '';
    public function getProperty():string {
        return $this->_property;
    }
    public function setProperty(string $value) {
        $this->_property = $value;
    }
    protected function hasProperty():bool {
        return (bool)$this->_property;
    }
    protected function removeProperty() {
        $this->_property = '';
    }
}

$prop = new StringProperty();
echo json_encode(isset($prop->property)).PHP_EOL; // false
$prop->property = 'value';
echo json_encode(isset($prop->property)).PHP_EOL; // true
unset($prop->property);
echo json_encode($prop->property).PHP_EOL; // "" -- will output empty string in JSON format
echo json_encode(isset($prop->property)).PHP_EOL; // false