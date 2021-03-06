<?php

namespace Passet\Tag;

use \Passet\Exception\PassetInvalidArgumentException;
use \Passet\Exception\PassetSrcUnreadableException;
use \Passet\Exception\PassetUnknownImageTypeException;

class Img extends TagAbs
{
    /** @var string file type. */
    private $_image_type;

    /**
     * Initialize attribute src and src file type.
     *
     * @throws PassetInvalidArgumentException
     * @throws PassetSrcUnreadableException
     * @throws PassetUnknownImageTypeException
     * @param string $image_src_path src path.
     */
    public function __construct($image_src_path)
    {

        if (!is_string($image_src_path)) {
            throw new PassetInvalidArgumentException('first argument should be string.');
        }
        if (!is_readable($image_src_path)) {
            throw new PassetSrcUnreadableException('file unreadable. file path:' . $image_src_path);
        }

        list(/* height */, /* width */, $type) = getimagesize($image_src_path);
        switch ($type) {
            case IMAGETYPE_GIF:
                $this->_image_type = IMAGETYPE_GIF;
                break;
            case IMAGETYPE_JPEG:
                $this->_image_type = IMAGETYPE_JPEG;
                break;
            case IMAGETYPE_PNG:
                $this->_image_type = IMAGETYPE_PNG;
                break;
            case IMAGETYPE_BMP:
                $this->_image_type = IMAGETYPE_BMP;
                break;
            default:
                throw new PassetUnknownImageTypeException('src is not image.');
        }

        $this->_attributes['src'] = $image_src_path;
    }

    /**
     * set alt attribute.
     *
     * @throws PassetInvalidArgumentException
     * @param string $alt alt attribute.
     * @return self
     */
    public function setAlt($alt)
    {
        if (!is_string($alt)) {
            throw new PassetInvalidArgumentException('first argument should be string.');
        }
        $this->_attributes['alt'] = $alt;
        return $this;
    }

    /**
     * set width attribute.
     *
     * @throws PassetInvalidArgumentException
     * @param int $width width attribute.
     * @return self
     */
    public function setWidth($width)
    {
        if (!is_numeric($width) || is_float($width) || $width < 1) {
            throw new PassetInvalidArgumentException('first argument should be positive integer.');
        }
        $this->_attributes['width'] = (string)$width;
    }

    /**
     * set height attribute.
     *
     * @throws PassetInvalidArgumentException
     * @param int $height height attribute.
     * @return self
     */
    public function setHeight($height)
    {
        if (!is_numeric($height) || is_float($height) || $height < 1) {
            throw new PassetInvalidArgumentException('first argument should be positive integer.');
        }
        $this->_attributes['height'] = (string)$height;
    }

    /**
     * build script tag string.
     *
     * @return string
     */
    public function build()
    {
        if ($this->_inline) {
            $encoded_image = base64_encode(file_get_contents($this->_attributes['src']));
            $mime_type = image_type_to_mime_type($this->_image_type);
            $this->_attributes['src'] = "data:{$mime_type};base64,{$encoded_image}";

            if (isset($this->_attributes['async'])) {
                unset($this->_attributes['async']);
            }
        }

        $attributes = join(' ', $this->_makeAttributesArr());
        if (!empty($attributes)) {
            $attributes = ' ' . $attributes;
        }
        return "<img{$attributes}>";
    }
}
