<?php

use \Passet\Tag\TagAbs;

class TagAbsTest extends PHPUnit_Framework_TestCase
{
    const TEST_CLASS_NAME = 'Passet\Tag\TagAbs';

    public function testConstruct()
    {
        $tag = $this->getMockForAbstractClass(TagAbsTest::TEST_CLASS_NAME);
        $this->assertTrue(is_a($tag, TagAbsTest::TEST_CLASS_NAME));
    }

    public function testSetId()
    {
        Closure::bind(function() {
            $tag = $this->getMockForAbstractClass(TagAbsTest::TEST_CLASS_NAME);
            $this->assertFalse(array_key_exists('id', $tag->_attributes));
            $this->assertEquals($tag, $tag->setId('test'));
            $this->assertEquals('test', $tag->_attributes['id']);
        }, $this, TagAbsTest::TEST_CLASS_NAME)->__invoke();
    }

    public function testSetIdPassetInvalidArgumentException()
    {
        $this->setExpectedException('\Passet\Exception\PassetInvalidArgumentException');
        $tag = $this->getMockForAbstractClass(TagAbsTest::TEST_CLASS_NAME);
        $tag->setId(new StdClass);
    }

    public function testSetClass()
    {
        Closure::bind(function() {
            $tag = $this->getMockForAbstractClass(TagAbsTest::TEST_CLASS_NAME);
            $this->assertFalse(array_key_exists('class', $tag->_attributes));
            $this->assertEquals($tag, $tag->setClass('test'));
            $this->assertEquals('test', $tag->_attributes['class']);
        }, $this, TagAbsTest::TEST_CLASS_NAME)->__invoke();
    }

    public function testSetClassPassetInvalidArgumentException()
    {
        $this->setExpectedException('\Passet\Exception\PassetInvalidArgumentException');
        $tag = $this->getMockForAbstractClass(TagAbsTest::TEST_CLASS_NAME);
        $tag->setClass(new StdClass);
    }

    public function testSetCustomAttribute()
    {
        Closure::bind(function() {
            $tag = $this->getMockForAbstractClass(TagAbsTest::TEST_CLASS_NAME);
            $this->assertFalse(array_key_exists('test', $tag->_attributes));
            $this->assertEquals($tag, $tag->setCustomAttribute('test', 'test'));
            $this->assertEquals('test', $tag->_attributes['test']);
        }, $this, TagAbsTest::TEST_CLASS_NAME)->__invoke();

        Closure::bind(function() {
            $tag = $this->getMockForAbstractClass(TagAbsTest::TEST_CLASS_NAME);
            $this->assertEquals($tag, $tag->setCustomAttribute('test'));
            $this->assertEquals('', $tag->_attributes['test']);
        }, $this, TagAbsTest::TEST_CLASS_NAME)->__invoke();
    }

    public function testSetCustomAttributePassetInvalidArgumentException()
    {
        $this->setExpectedException('\Passet\Exception\PassetInvalidArgumentException');
        $tag = $this->getMockForAbstractClass(TagAbsTest::TEST_CLASS_NAME);
        $tag->setCustomAttribute(new StdClass);
    }

    public function testSetType()
    {
        Closure::bind(function() {
            $tag = $this->getMockForAbstractClass(TagAbsTest::TEST_CLASS_NAME);
            $this->assertFalse(array_key_exists('type', $tag->_attributes));
            $this->assertEquals($tag, $tag->setType('test'));
            $this->assertEquals('test', $tag->_attributes['type']);
        }, $this, TagAbsTest::TEST_CLASS_NAME)->__invoke();
    }

    public function testSetTypePassetInvalidArgumentException()
    {
        $this->setExpectedException('\Passet\Exception\PassetInvalidArgumentException');
        $tag = $this->getMockForAbstractClass(TagAbsTest::TEST_CLASS_NAME);
        $tag->setType(new StdClass);
    }

    public function testEnableAsyncLoad()
    {
        Closure::bind(function() {
            $tag = $this->getMockForAbstractClass(TagAbsTest::TEST_CLASS_NAME);
            $this->assertFalse(array_key_exists('async', $tag->_attributes));
            $this->assertEquals($tag, $tag->enableAsyncLoad());
            $this->assertTrue(array_key_exists('async', $tag->_attributes));
            $this->assertTrue(empty($tag->_attributes['async']));
        }, $this, TagAbsTest::TEST_CLASS_NAME)->__invoke();
    }

    public function testWriteInline()
    {
        Closure::bind(function() {
            $tag = $this->getMockForAbstractClass(TagAbsTest::TEST_CLASS_NAME);
            $this->assertFalse($tag->_inline);
            $this->assertTrue($tag->writeInline()->_inline);
        }, $this, TagAbsTest::TEST_CLASS_NAME)->__invoke();
    }

    public function testMakeAttributesArr()
    {
        Closure::bind(function() {
            $expect = array('id="a"', 'class="b"');
            $tag = $this->getMockForAbstractClass(TagAbsTest::TEST_CLASS_NAME);
            $this->assertEquals($expect, $tag->setId('a')->setClass('b')->_makeAttributesArr());
        }, $this, TagAbsTest::TEST_CLASS_NAME)->__invoke();

        Closure::bind(function() {
            $expect = array('id="a"');
            $tag = $this->getMockForAbstractClass(TagAbsTest::TEST_CLASS_NAME);
            $this->assertEquals($expect, $tag->setId('a')->_makeAttributesArr());
        }, $this, TagAbsTest::TEST_CLASS_NAME)->__invoke();

        Closure::bind(function() {
            $expect = array('class="b"');
            $tag = $this->getMockForAbstractClass(TagAbsTest::TEST_CLASS_NAME);
            $this->assertEquals($expect, $tag->setClass('b')->_makeAttributesArr());
        }, $this, TagAbsTest::TEST_CLASS_NAME)->__invoke();

        Closure::bind(function() {
            $expect = array('');
            $tag = $this->getMockForAbstractClass(TagAbsTest::TEST_CLASS_NAME);
            $this->assertEquals($expect, $tag->setCustomAttribute('test')->_makeAttributesArr());
        }, $this, TagAbsTest::TEST_CLASS_NAME)->__invoke();

        Closure::bind(function() {
            $expect = array();
            $tag = $this->getMockForAbstractClass(TagAbsTest::TEST_CLASS_NAME);
            $this->assertEquals($expect, $tag->_makeAttributesArr());
        }, $this, TagAbsTest::TEST_CLASS_NAME)->__invoke();
    }
}
