<?php

namespace Passet\Tag;

use \Passet\Container\Container,
    \Passet\Exception\PassetInvalidArgumentException,
    \Passet\Exception\PassetSrcUnreadableException;

class Style extends TagAbs
{
    /**
     * Initialize attributes href, type, rel and media.
     *
     * @throws PassetInvalidArgumentException
     * @throws PassetSrcUnreadableException
     * @param string $href link path.
     */
    public function __construct($href)
    {
        if (!is_string($href)) {
            throw new PassetInvalidArgumentException('argument should be string.');
        }
        if (!is_readable($href)) {
            throw new PassetSrcUnreadableException('file unreadable. file path:' . $href);
        }
        $this->_attributes['href'] = $href;
        $this->_attributes['type'] = 'text/css';
        $this->_attributes['rel'] = 'stylesheet';
        $this->_attributes['media'] = 'all';
    }

    /**
     * set media attribute.
     * 
     * @throws PassetInvalidArgumentException
     * @param string $media media name.
     * @return self
     */
    public function setMedia($media)
    {
        if (!is_string($media)) {
            throw new PassetInvalidArgumentException('argument should be string.');
        }
        $this->_attributes['media'] = $media;
    }

    /**
     * add asset container to this object.
     *
     * @return void
     */
    public function add()
    {
        Container::addStyle($this);
    }

    /**
     * build style or link tag string.
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
        return "<link{$attributes}>";
    }

    /**
     * build inline style tag string.
     * 
     * @throws PassetSrcUnreadableException
     * @return string
     */
    private function _inlineGen()
    {
        $contents = file_get_contents($this->_attributes['href']);

        unset($this->_attributes['href']);
        if (isset($this->_attributes['async'])) {
            unset($this->_attributes['async']);
        }

        $attributes = join(' ', $this->_makeAttributesArr());
        if (!empty($attributes)) {
            $attributes = ' ' . $attributes;
        }

        return "<style{$attributes}>{$contents}</style>";
    }
}
