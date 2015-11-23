## PHP-Object
Non dynamic base object class for PHP. Allows making getters and setters via getProperty and setProperty methods with any accessor type. Not defined properties will throw error.
```php
class MyObject extends \aw\Object {
    private $_property = null;
    public function getProperty(){
        return 'GET-'.$this->_property;
    }
    public function setProperty($value){
        $this->_property = 'SET-'.$value;
    }
}
```
Instances of MyObject will be non-dynamic objects with one property "property" that can be accessed via "$instance->property"
```php
$instance = new MyObject();
echo $instance->property; // GET-
$instance->property = 'something';
echo $instance->property; // GET-SET-something
echo $instance->anyProperty; // throws error
```
