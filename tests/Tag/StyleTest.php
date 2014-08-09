<?php

use \Passet\Tag\Style;

class StyleTest extends PHPUnit_Framework_TestCase
{
    const TEST_CLASS_NAME = 'Passet\Tag\Style';

    public function testConstruct()
    {
        $style = new Style('tests/_fixture/static/css/1.css');
        $this->assertTrue(is_a($style, self::TEST_CLASS_NAME));

        Closure::bind(function() {
            $style = new Style('tests/_fixture/static/css/1.css');
            $this->assertEquals('tests/_fixture/static/css/1.css', $style->_attributes['href']);
            $this->assertEquals('text/css', $style->_attributes['type']);
            $this->assertEquals('stylesheet', $style->_attributes['rel']);
            $this->assertEquals('all', $style->_attributes['media']);
        }, $this, self::TEST_CLASS_NAME)->__invoke();
    }

    public function testConstructPassetInvalidArgumentException()
    {
        $this->setExpectedException('\Passet\Exception\PassetInvalidArgumentException');
        new Style(array());
    }

    public function testConstructPassetSrcUnreadableException()
    {
        $this->setExpectedException('\Passet\Exception\PassetSrcUnreadableException');
        new Style('/path/to/not/found');
    }

    public function testSetMedia()
    {
        Closure::bind(function() {
            $style = new Style('tests/_fixture/static/css/1.css');
            $style->setMedia('test');
            $this->assertEquals('test', $style->_attributes['media']);
        }, $this, self::TEST_CLASS_NAME)->__invoke();
    }

    public function testSetMediaPassetInvalidArgumentException()
    {
        $this->setExpectedException('\Passet\Exception\PassetInvalidArgumentException');
        $style = new Style('tests/_fixture/static/css/1.css');
        $style->setMedia(new StdClass);
    }

    public function testBuild()
    {
        $style = new Style('tests/_fixture/static/css/1.css');
        $this->assertEquals(
            '<link href="tests/_fixture/static/css/1.css" type="text/css" rel="stylesheet" media="all">',
            $style->build()
        );
    }

    public function testBuildInline()
    {
        $css_file = file_get_contents('tests/_fixture/static/css/1.css');
        $style = new Style('tests/_fixture/static/css/1.css');
        $this->assertEquals(
            "<style type=\"text/css\" rel=\"stylesheet\" media=\"all\">{$css_file}</style>",
            $style->enableAsyncLoad()->writeInline()->build()
        );
    }
}
