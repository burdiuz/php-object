<?php
/**
 * Created by Oleg Galaburda on 11.12.15.
 */


namespace aw {

  use \PHPUnit_Framework_TestCase as TestCase;

  class _ObjectHasRemoveTest_Object extends Object {
    public $_property = '';

    public function getProperty() {
      return $this->_property;
    }

    public function setProperty($value) {
      $this->_property = $value;
    }

    public function hasProperty() {
      return (bool)$this->_property;
    }

    public function removeProperty() {
      return $this->_property = '';
    }
  }

  class ObjectHasRemoveTest extends TestCase {
    public $target;
    public function setUp(){
      $this->target = new _ObjectHasRemoveTest_Object();
    }

    public function testHasProperty() {
      $this->assertFalse(isset($this->target->property));
      $this->target->property = 'value';
      $this->assertTrue(isset($this->target->property));
    }

    public function testRemoveProperty() {
      $this->target->property = 'value';
      unset($this->target->property);
      $this->assertFalse(isset($this->target->property));
    }
  }
}