<?php
namespace aw {

  use \Exception;

  class Object {
    public function __get(string $name) {
      $value = null;
      $getter = self::getAccessorName($name);
      if (method_exists($this, $getter)) {
        $value = $this->$getter($name);
      } else {
        throw new Exception('Property accessor "' . $name . '" not found.');
      }
      return $value;
    }

    public function __set(string $name, $value) {
      $setter = self::getMutatorName($name);
      if (method_exists($this, $setter)) {
        $this->$setter($value);
      } else {
        throw new Exception('Property mutator "' . $name . '" not found.');
      }
    }

    public function __isset(string $name) {
      return method_exists($this, self::getAccessorName($name));
    }

    /**
     * Property cannot be unset/deleted, unset tries to nullify it.
     * @param string $name
     * @throws \Exception
     */
    public function __unset(string $name) {
      $setter = self::getMutatorName($name);
      if (method_exists($this, $setter)) {
        $this->$setter(null);
      } else {
        throw new Exception('Property mutator "' . $name . '" not found.');
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