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
You can change behaviour of your property when `isset`/`unset` are used.
```php
class StringProperty extends \aw\Object {
    private $_property = '';
    public function getProperty():string {
        return $this->_property;
    }
    public function setProperty(string $value) {
        $this->_property = $value;
    }
    protected function hasProperty():bool {
        return !$this->_property;
    }
    protected function removeProperty() {
        $this->_property = '';
    }
}
```
Then check if your property is empty or set it to be empty:
```php
$prop = new StringProperty();
echo json_encode(isset($prop->property)); // false
$prop->property = 'value';
echo json_encode(isset($prop->property)); // true
unset($prop->property);
echo json_encode($prop->property); // "" -- will output empty string in JSON format
echo json_encode(isset($prop->property)); // false
```
*Note:* Defining `has*` and `remove*` methods is optional, but without them you will not bw able to define logic for isset and unset actions over your property.  Without them unset/delete property via `unset()` just tries to pass `null` into property mutator method and even if property set to `null`, `isset()` will always return `true`:
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
