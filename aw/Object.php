<?php
namespace aw {

  use \Exception;

  class Object {
    final public function __get(string $name) {
      $value = null;
      $getter = static::getAccessorName($name);
      if (method_exists($this, $getter)) {
        $value = $this->$getter($name);
      } else {
        throw new Exception('Property accessor "' . $name . '" not found.');
      }
      return $value;
    }

    final public function __set(string $name, $value) {
      $setter = static::getMutatorName($name);
      if (method_exists($this, $setter)) {
        $this->$setter($value);
      } else {
        throw new Exception('Property mutator "' . $name . '" not found.');
      }
    }

    final public function __isset(string $name) {
      $checker = static::getCheckerName($name);
      return method_exists($this, $checker) ? $this->$checker() : method_exists($this, static::getAccessorName($name));
    }

    /**
     * Property cannot be unset/deleted, unset tries to nullify it.
     * @param string $name
     * @throws \Exception
     */
    final public function __unset(string $name) {
      $remover = static::getRemoverName($name);
      if (method_exists($this, $remover)) {
        $this->$remover();
      }else{
        $setter = static::getMutatorName($name);
        if (method_exists($this, $setter)) {
          $this->$setter(null);
        } else {
          throw new Exception('Property mutator "' . $name . '" not found.');
        }
      }
    }

    static public function getAccessorName($name) {
      return $name ? 'get' . strtoupper($name[0]) . substr($name, 1) : null;
    }

    static public function getMutatorName($name) {
      return $name ? 'set' . strtoupper($name[0]) . substr($name, 1) : null;
    }

    static public function getCheckerName($name) {
      return $name ? 'has' . strtoupper($name[0]) . substr($name, 1) : null;
    }

    static public function getRemoverName($name) {
      return $name ? 'remove' . strtoupper($name[0]) . substr($name, 1) : null;
    }
  }
}