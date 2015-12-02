## PHP-Object
Non dynamic base object class for PHP. Allows making getters and setters via getProperty and setProperty methods with public/protected accessor. Not defined properties will throw error.
```php
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
```
Instances of MyObject will be non-dynamic objects with one property "property" that can be accessed via "$instance->property"
```php
$instance = new MyObject();
echo $instance->property.PHP_EOL; // GET-
$instance->property = 'something';
echo $instance->property.PHP_EOL; // GET-SET-something
echo $instance->getData().PHP_EOL; // DATA:hidden value
echo $instance->anyProperty.PHP_EOL; // throws error Property accessor "anyProperty" not found.
```
  
*Note:* You cannot unset/delete property, unset() just tries to pass NULL into property mutator method. Even if its changed to NULL, isset() for property will still return TRUE:
```php
class MySimpleObject extends \aw\Object {
    private $_property = null;
    public function getProperty(){
        return $this->_property;
    }
    public function setProperty($value){
        $this->_property = $value;
    }
}

$simple = new MySimpleObject();
$simple->property = 'something';
echo 'Is set: '.json_encode(isset($simple->property)).PHP_EOL; // Is set: true
echo 'Is null: '.json_encode(is_null($simple->property)).PHP_EOL; // Is null: false
unset($simple->property);
echo 'Is set: '.json_encode(isset($simple->property)).PHP_EOL; // Is set: true
echo 'Is null: '.json_encode(is_null($simple->property)).PHP_EOL; // Is null: true
```
