<?php
namespace aw{
    use \PHPUnit_Framework_TestCase as TestCase;

    class MyObject extends Object {
        public $_property = null;
        public function getProperty(){
            return $this->_property;
        }
        public function setProperty($value){
            $this->_property = $value;
        }
    }

    class ObjectTest extends TestCase{

        /**
         * @test
         */
        public function testAccessor(){
            $obj = new MyObject();
            $obj->_property = 1;
            $this->assertEquals($obj->_property, $obj->property);
            $obj->_property = (object)true;
            $this->assertEquals($obj->_property, $obj->property);
        }

        /**
         * @test
         * @expectedException Exception
         */
        public function testMissingAccessor(){
            $obj = new MyObject();
            $obj->notAProperty;
        }

        /**
         * @test
         */
        public function testMutator(){
            $obj = new MyObject();
            $obj->property = 1;
            $this->assertEquals(1, $obj->_property);
            $obj->property = 'to be string';
            $this->assertEquals('to be string', $obj->_property);

        }

        /**
         * @test
         * @expectedException Exception
         */
        public function testMissingMutator(){
            $obj = new MyObject();
            $obj->anyProperty = true;

        }

        /**
         * @test
         */
        public function testIsset(){
            $obj = new MyObject();
            $this->assertTrue(isset($obj->property));
            $this->assertFalse(isset($obj->anotherProperty));
        }

        /**
         * @test
         */
        public function testUnset(){
            $obj = new MyObject();
            $obj->_property = 1;
            unset($obj->property);
            $this->assertNull($obj->property);
        }

        /**
         * @test
         */
        public function testGetAccessorName(){
            $this->assertEquals('getA', Object::getAccessorName('a'), 'make uppercase');
            $this->assertEquals('getA', Object::getAccessorName('A'), 'keep uppercase');
            $this->assertEquals('getABCD', Object::getAccessorName('ABCD'), 'keep uppercase');
            $this->assertEquals('getAbcd', Object::getAccessorName('abcd'), 'make uppercase only first letter');
        }
        /**
         * @test
         */
        public function testGetMutatorName(){
            $this->assertEquals('setA', Object::getMutatorName('a'), 'make uppercase');
            $this->assertEquals('setA', Object::getMutatorName('A'), 'keep uppercase');
            $this->assertEquals('setABCD', Object::getMutatorName('ABCD'), 'keep uppercase');
            $this->assertEquals('setAbcd', Object::getMutatorName('abcd'), 'make uppercase only first letter');
        }
    }
}