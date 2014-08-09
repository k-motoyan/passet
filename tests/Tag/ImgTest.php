<?php

use \Passet\Tag\Img;

class ImgTest extends PHPUnit_Framework_TestCase
{
    const TEST_CLASS_NAME = 'Passet\Tag\Img';

    public function testConstruct()
    {
        $img = new Img('tests/_fixture/static/img/img.gif');
        $this->assertTrue(is_a($img, self::TEST_CLASS_NAME));

        Closure::bind(function() {
            $img = new Img('tests/_fixture/static/img/img.gif');
            $this->assertEquals('tests/_fixture/static/img/img.gif', $img->_attributes['src']);
        }, $this, self::TEST_CLASS_NAME)->__invoke();
    }

    public function testCountructPassetInvalidArgumentException()
    {
        $this->setExpectedException('\Passet\Exception\PassetInvalidArgumentException');
        new Img(array());
    }

    public function testConstructPassetSrcUnreadableException()
    {
        $this->setExpectedException('\Passet\Exception\PassetSrcUnreadableException');
        new Img('/path/to/not/found');
    }

    public function testConstructImageTypeCheckByGif()
    {
        Closure::bind(function() {
            $img = new Img('tests/_fixture/static/img/img.gif');
            $this->assertEquals(IMAGETYPE_GIF, $img->_image_type);
        }, $this, self::TEST_CLASS_NAME)->__invoke();
    }

    public function testConstructImageTypeCheckByJpeg()
    {
        Closure::bind(function() {
            $img = new Img('tests/_fixture/static/img/img.jpg');
            $this->assertEquals(IMAGETYPE_JPEG, $img->_image_type);
        }, $this, self::TEST_CLASS_NAME)->__invoke();
    }

    public function testConstructImageTypeCheckByPng()
    {
        Closure::bind(function() {
            $img = new Img('tests/_fixture/static/img/img.png');
            $this->assertEquals(IMAGETYPE_PNG, $img->_image_type);
        }, $this, self::TEST_CLASS_NAME)->__invoke();
    }

    public function testConstructImageTypeCheckByBmp()
    {
        Closure::bind(function() {
            $img = new Img('tests/_fixture/static/img/img.bmp');
            $this->assertEquals(IMAGETYPE_BMP, $img->_image_type);
        }, $this, self::TEST_CLASS_NAME)->__invoke();
    }

    public function testConstructImageTypeCheckPassetUnknownImageTypeException()
    {
        $this->setExpectedException('\Passet\Exception\PassetUnknownImageTypeException');
        new Img('tests/_fixture/static/js/1.js');
    }

    public function testConstructPassetInvalidArgumentException()
    {
        $this->setExpectedException('\Passet\Exception\PassetInvalidArgumentException');
        new Img(array());
    }

    public function testSetAlt()
    {
        Closure::bind(function() {
            $img = new Img('tests/_fixture/static/img/img.bmp');
            $img->setalt('alt');
            $this->assertEquals('alt', $img->_attributes['alt']);
        }, $this, self::TEST_CLASS_NAME)->__invoke();
    }

    public function testSetAltPassetInvalidArgumentException()
    {
        $this->setExpectedException('\Passet\Exception\PassetInvalidArgumentException');
        $img = new Img('tests/_fixture/static/img/img.bmp');
        $img->setAlt(array());
    }

    public function testSetWidth()
    {
        Closure::bind(function() {
            $img = new Img('tests/_fixture/static/img/img.bmp');
            $img->setWidth(100);
            $this->assertEquals(100, $img->_attributes['width']);
        }, $this, self::TEST_CLASS_NAME)->__invoke();
    }

    public function testSetWidthPassetInvalidArgumentException()
    {
        $this->setExpectedException('\Passet\Exception\PassetInvalidArgumentException');
        $img = new Img('tests/_fixture/static/img/img.bmp');
        $img->setWidth('foo');
    }

    public function testSetHeight()
    {
        Closure::bind(function() {
            $img = new Img('tests/_fixture/static/img/img.bmp');
            $img->setHeight(100);
            $this->assertEquals(100, $img->_attributes['height']);
        }, $this, self::TEST_CLASS_NAME)->__invoke();
    }

    public function testSetHeightPassetInvalidArgumentException()
    {
        $this->setExpectedException('\Passet\Exception\PassetInvalidArgumentException');
        $img = new Img('tests/_fixture/static/img/img.bmp');
        $img->setHeight('foo');
    }

    public function testBuild()
    {
        $img = new Img('tests/_fixture/static/img/img.bmp');
        $this->assertEquals('<img src="tests/_fixture/static/img/img.bmp">', $img->build());
    }

    public function testBuildInline()
    {
        $encoded_image = base64_encode(file_get_contents('tests/_fixture/static/img/img.gif'));
        $img = new Img('tests/_fixture/static/img/img.gif');
        $this->assertEquals(
            "<img src=\"data:image/gif:base64,{$encoded_image}\">",
            $img->enableAsyncLoad()->writeInline()->build()
        );
    }
}
