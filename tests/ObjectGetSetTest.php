<?php
namespace aw {

  use \PHPUnit_Framework_TestCase as TestCase;

  class _ObjectGetSetTest_Object extends Object {
    public $_property = null;

    public function getProperty() {
      return $this->_property;
    }

    public function setProperty($value) {
      $this->_property = $value;
    }
  }

  class ObjectGetSetTest extends TestCase {
    public $obj;

    public function setUp() {
      $this->obj = new _ObjectGetSetTest_Object();
    }

    public function testAccessor() {
      $obj = $this->obj;
      $obj->_property = 1;
      $this->assertEquals($obj->_property, $obj->property);
      $obj->_property = (object)true;
      $this->assertEquals($obj->_property, $obj->property);
    }

    /**
     * @test
     * @expectedException Exception
     */
    public function testMissingAccessor() {
      $obj = $this->obj;
      $obj->notAProperty;
    }

    public function testMutator() {
      $obj = $this->obj;
      $obj->property = 1;
      $this->assertEquals(1, $obj->_property);
      $obj->property = 'to be string';
      $this->assertEquals('to be string', $obj->_property);

    }

    /**
     * @expectedException Exception
     */
    public function testMissingMutator() {
      $obj = $this->obj;
      $obj->anyProperty = true;

    }

    public function testIsset() {
      $obj = $this->obj;
      $this->assertTrue(isset($obj->property));
      $this->assertFalse(isset($obj->anotherProperty));
    }

    public function testUnset() {
      $obj = $this->obj;
      $obj->_property = 1;
      unset($obj->property);
      $this->assertNull($obj->property);
    }

    public function testGetAccessorName() {
      $this->assertEquals('getA', Object::getAccessorName('a'), 'make uppercase');
      $this->assertEquals('getA', Object::getAccessorName('A'), 'keep uppercase');
      $this->assertEquals('getABCD', Object::getAccessorName('ABCD'), 'keep uppercase');
      $this->assertEquals('getAbcd', Object::getAccessorName('abcd'), 'make uppercase only first letter');
    }

    public function testGetMutatorName() {
      $this->assertEquals('setA', Object::getMutatorName('a'), 'make uppercase');
      $this->assertEquals('setA', Object::getMutatorName('A'), 'keep uppercase');
      $this->assertEquals('setABCD', Object::getMutatorName('ABCD'), 'keep uppercase');
      $this->assertEquals('setAbcd', Object::getMutatorName('abcd'), 'make uppercase only first letter');
    }
  }
}