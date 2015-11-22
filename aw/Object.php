<?php
namespace aw {
    class Object {
        public function __get($name) {
            $value = null;
            $getter = self::getAccessorName($name);
            if (method_exists($this, $getter)) {
                $value = $this->$getter($name);
            } else {
                throw new \Exception('Property accessor "' . $name . '" not found.');
            }
            return $value;
        }

        public function __set($name, $value) {
            $setter = self::getMutatorName($name);
            if (method_exists($this, $setter)) {
                $this->$setter($value);
            } else {
                throw new \Exception('Property mutator "' . $name . '" not found.');
            }
        }

        static public function getAccessorName($name) {
            return $name ? 'get' . strtoupper($name[0]) . substr($name, 1) : null;
        }

        static public function getMutatorName($name) {
            return $name ? 'set' . strtoupper($name[0]) . substr($name, 1) : null;
        }
    }
}