<?php
class EnviMockContainer
{
    private $container = array();
    private $editors = array();
    private $process_list = array();
    private static $singleton;

    private function __construct()
    {
    }
    private function __clone()
    {
    }

    public static function singleton()
    {
        if (!self::$singleton) {
            self::$singleton = new EnviMockContainer;
        }
        return self::$singleton;
    }

    public function setEditor($class_name, $method_name, $editor)
    {
        $this->editors[strtolower($class_name)][strtolower($method_name)] = $editor;
    }

    public function &getEditor($class_name, $method_name)
    {
        return $this->editors[strtolower($class_name)][strtolower($method_name)];
    }

    public function setAttribute($class_name, $method_name, $setter_key, $setter_value)
    {
        $this->container[strtolower($class_name)][strtolower($method_name)][$setter_key] = $setter_value;
    }
    public function getAttributeMethodAll($class_name, $method_name)
    {
        return isset($this->container[strtolower($class_name)][strtolower($method_name)]) ? $this->container[strtolower($class_name)][strtolower($method_name)] : false;
    }
    public function getAttribute($class_name, $method_name, $setter_key, $default_value = false)
    {
        return isset($this->container[strtolower($class_name)][strtolower($method_name)][$setter_key]) ? $this->container[strtolower($class_name)][strtolower($method_name)][$setter_key] : $default_value;
    }
    public function unsetAttributeMethodAll($class_name, $method_name)
    {
        return $this->container[strtolower($class_name)][strtolower($method_name)] = array();
    }
    public function unsetAttribute($class_name, $method_name, $setter_key)
    {
        if (isset($this->container[strtolower($class_name)][strtolower($method_name)][$setter_key])) {
            unset($this->container[strtolower($class_name)][strtolower($method_name)][$setter_key]);
        }
    }

    public function setProcess($class_name, $method_name, $arguments)
    {
        return $this->process_list[] = array('class_name' => $class_name, 'method_name' => $method_name, 'arguments' => $arguments);
    }
    public function getProcessAll()
    {
        return $this->process_list;
    }
    public function unsetProcessAll()
    {
        return $this->process_list = array();
    }

    public function getAttributeAll()
    {
        return $this->container;
    }
}

