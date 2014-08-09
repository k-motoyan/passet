<?php

namespace Passet\Tag;

use \Passet\Exception\PassetInvalidArgumentException;

/**
 * Html basic tag generating class.
 *
 * @author k-motoyan
 */
abstract class TagAbs
{
    /** @var array retail the html tag attributes by hash array. */
    protected $_attributes = array();

    /** @var bool inline write flg. */
    protected $_inline = false;

    /**
     * set id attribute.
     * 
     * @throws PassetInvalidArgumentException
     * @param string $id id name.
     * @return self
     */
    public function setId($id)
    {
        if (!is_string($id)) {
            throw new PassetInvalidArgumentException('argument should be string.');
        }
        $this->_attributes['id'] = $id;
        return $this;
    }

    /**
     * set class attribute.
     * 
     * @throws PassetInvalidArgumentException
     * @param string $class class name.
     * @return self
     */
    public function setClass($class)
    {
        if (!is_string($class)) {
            throw new PassetInvalidArgumentException('argument should be string.');
        }
        $this->_attributes['class'] = $class;
        return $this;
    }

    /**
     * set type attribute.
     * 
     * @throws PassetInvalidArgumentException
     * @param string $type type name.
     * @return self
     */
    public function setType($type)
    {
        if (!is_string($type)) {
            throw new PassetInvalidArgumentException('argument should be string.');
        }
        $this->_attributes['type'] = $type;
        return $this;
    }

    /**
     * set async load using flg.
     * 
     * @return self
     */
    public function enableAsyncLoad()
    {
        $this->_attributes['async'] = '';
        return $this;
    }

    /**
     * set inline writing flg.
     * 
     * @return self
     */
    public function writeInline()
    {
        $this->_inline = true;
        return $this;
    }

    /**
     * set custom attribute.
     * 
     * @throws PassetInvalidArgumentException
     * @param string $attr_name custom attribute name.
     * @param string $attr_val custom attribute value, default is empty.
     * @return self
     */
    public function setCustomAttribute($attr_name, $attr_val='')
    {
        if (!is_string($attr_name) || !is_string($attr_val)) {
            throw new PassetInvalidArgumentException('argument should be string.');
        }
        $this->_attributes[$attr_name] = $attr_val;
        return $this;
    }

    /**
     * build tag string.
     */
    protected abstract function build();

    /**
     * return the array in joined key and value of "=".
     * if value is empty then array into only key.
     * 
     * @return array
     */
    protected function _makeAttributesArr()
    {
        $attributes = array();
        foreach ($this->_attributes as $key => $val) {
            $attributes[] = empty($val) ? $val : $key . '="' . $val . '"';
        }
        return $attributes;
    }
}
