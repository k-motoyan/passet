<?php

namespace Passet\Tag;

use \Passet\Exception\PassetInvalidArgumentException,
    \Passet\Exception\PassetSrcUnreadableException,
    \Passet\Exception\PassetUnknownImageTypeException;

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
     * @param string $src_path src path.
     */
    public function __construct($src_path)
    {

        if (!is_string($src_path)) {
            throw new PassetInvalidArgumentException(
                PassetInvalidArgumentException::MESSAGE_ARGUMENT_SHOUD_BE_STRING
            );
        }
        if (!is_readable($src_path)) {
            throw new PassetSrcUnreadableException('file unreadable. file path:' . $src_path);
        }

        list(/* height */, /* width */, $type) = getimagesize($src_path);
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

        $this->_attributes['src'] = $src_path;
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
            throw new PassetInvalidArgumentException(
                PassetInvalidArgumentException::MESSAGE_ARGUMENT_SHOUD_BE_STRING
            );
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
            throw new PassetInvalidArgumentException(
                PassetInvalidArgumentException::MESSAGE_ARGUMENT_SHOUL_BE_POSITIVE_INTEGER
            );
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
            throw new PassetInvalidArgumentException(
                PassetInvalidArgumentException::MESSAGE_ARGUMENT_SHOUL_BE_POSITIVE_INTEGER
            );
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
