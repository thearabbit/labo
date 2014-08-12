<?php
namespace Rabbit\Cpanel\Libraries;


class EmptyClass
{
    private $_data = array();

    public function __set($name, $value)
    {
        $this->_data[$name] = $value;
    }

    public function __get($name)
    {
        if (array_key_exists($name, $this->_data)) {
            return $this->_data[$name];
        };
        return null;
    }
}