## PHP-Object
[![Build Status](https://travis-ci.org/burdiuz/php-object.svg?branch=master)](https://travis-ci.org/burdiuz/php-object)
[![Coverage Status](https://coveralls.io/repos/burdiuz/php-object/badge.svg?branch=master&service=github)](https://coveralls.io/github/burdiuz/php-object?branch=master)
[![Dependency Status](https://www.versioneye.com/user/projects/568a56eceb4f47003c001007/badge.svg?style=flat)](https://www.versioneye.com/user/projects/568a56eceb4f47003c001007)
[![Latest Stable Version](https://poser.pugx.org/actualwave/object/v/stable)](https://packagist.org/packages/actualwave/object) [![Total Downloads](https://poser.pugx.org/actualwave/object/downloads)](https://packagist.org/packages/actualwave/object) [![License](https://poser.pugx.org/actualwave/object/license)](https://packagist.org/packages/actualwave/object)

Non dynamic base object class for PHP. Allows making getters and setters via `get*` and `set*` methods with public/protected accessor. Not defined properties will throw error.

### Installation
Via [composer](https://getcomposer.org/)
```
composer require actualwave/object
```

### Usage
Basically instead of shared magic methods `__set`, `__get`, `__isset`, `__unset` you can define individual methods for each property:
* get* - get[Property name from upper-case char], for reading property value.
* set* - set[Property name from upper-case char], for setting property new value.
* has* - has[Property name from upper-case char], for checking is property set.
* remove* - remove[Property name from upper-case char], for removing(using `unset()` on it) property.  

`has*` and `remove*` methods have default action and are optional. By default, `has*` will always return `true` for properties with defined getter and `remove*` will try to pass `null` into setter.

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
Instances of `MyObject` will be non-dynamic objects with one read-write property `property` that can be accessed via `$instance->property` and two read-only properties -- `hiddenProperty` and its alias `data`.
```php
$instance = new MyObject();
echo $instance->property.PHP_EOL; // GET-
$instance->property = 'something';
echo $instance->property.PHP_EOL; // GET-SET-something
echo $instance->getData().PHP_EOL; // DATA:hidden value
echo $instance->data.PHP_EOL; // DATA:hidden value
echo $instance->anyProperty.PHP_EOL; // throws error Property accessor "anyProperty" not found.
```
You can change behaviour of your property when `isset`/`unset` are used via `has*` and `remove*` methods.
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
        return (bool)$this->_property;
    }
    protected function removeProperty() {
        $this->_property = '';
    }
}
```
Then check if your property is empty or set it to be empty:
```php
$prop = new StringProperty();
echo json_encode(isset($prop->property)).PHP_EOL; // false
$prop->property = 'value';
echo json_encode(isset($prop->property)).PHP_EOL; // true
unset($prop->property);
echo json_encode($prop->property).PHP_EOL; // "" -- will output empty string in JSON format
echo json_encode(isset($prop->property)).PHP_EOL; // false
```
*Note:* Defining `has*` and `remove*` methods is optional, but without them you will not be able to define logic for `isset()` and `unset()` actions over your property.  Without them unset/delete property via `unset()` just tries to pass `null` into property mutator method and even if property set to `null`, `isset()` will always return `true`:
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
