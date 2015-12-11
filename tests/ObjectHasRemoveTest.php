<?php
/**
 * Created by Oleg Galaburda on 11.12.15.
 */


namespace aw {

  use \PHPUnit_Framework_TestCase as TestCase;

  class _ObjectHasRemoveTest_Object extends Object {
    public $_property = null;

    public function getProperty() {
      return $this->_property;
    }

    public function setProperty($value) {
      $this->_property = $value;
    }

    public function hasProperty() {
      return !$this->_property;
    }

    public function removeProperty() {
      return $this->_property = null;
    }
  }

  class OObjectHasRemoveTest {
    public function testHasProperty() {

    }

    public function testRemoveProperty() {

    }
  }
}