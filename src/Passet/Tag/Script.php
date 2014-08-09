<?php

namespace Passet\Tag;

use \Passet\Container\Container,
    \Passet\Exception\PassetInvalidArgumentException,
    \Passet\Exception\PassetSrcUnreadableException;

class Script extends TagAbs
{
    /**
     * Initialize attributes src and type.
     *
     * @throws PassetInvalidArgumentException
     * @throws PassetSrcUnreadableException
     * @param string $src_path src path.
     */
    public function __construct($src_path)
    {
        if (!is_string($src_path)) {
            throw new PassetInvalidArgumentException('argument should be string.');
        }
        if (!is_readable($src_path)) {
            throw new PassetSrcUnreadableException('file unreadable. file path:' . $src_path);
        }
        $this->_attributes['src'] = $src_path;
        $this->_attributes['type'] = 'application/javascript';
    }

    /**
     * add asset container to this object.
     *
     * @return void
     */
    public function add()
    {
        Container::addScript($this);
    }

    /**
     * build script tag string.
     *
     * @return string
     */
    public function build()
    {
        if ($this->_inline) {
            return $this->_inlineGen();
        }

        $attributes = join(' ', $this->_makeAttributesArr());
        if (!empty($attributes)) {
            $attributes = ' ' . $attributes;
        }
        return "<script{$attributes}></script>";
    }

    /**
     * build inline script tag string.
     * 
     * @return string
     */
    private function _inlineGen()
    {
        $contents = file_get_contents($this->_attributes['src']);

        unset($this->_attributes['src']);
        if (isset($this->_attributes['async'])) {
            unset($this->_attributes['async']);
        }

        $attributes = join(' ', $this->_makeAttributesArr());
        if (!empty($attributes)) {
            $attributes = ' ' . $attributes;
        }

        return "<script{$attributes}>{$contents}</script>";
    }
}
