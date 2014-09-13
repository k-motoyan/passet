<?php

use \Passet\Compiler\Coffee;

class CoffeeTest extends PHPUnit_Framework_TestCase
{
    const TEST_CLASS_NAME = 'Passet\Compiler\Coffee';

    public function testConstruct()
    {
        Closure::bind(function() {
            $coffee = new Coffee('tests/_fixture/static/js/', 'tests/_fixture/coffee/src/');
            $this->assertTrue(is_a($coffee, CoffeeTest::TEST_CLASS_NAME));
            $this->assertTrue(is_a($coffee->_option, 'Passet\Compiler\Command\Coffee'));
        }, $this, self::TEST_CLASS_NAME)->__invoke();
    }

    public function testConstructPassetInvalidArgumentExceptionCase1()
    {
        $this->setExpectedException('\Passet\Exception\PassetInvalidArgumentException');
        new Coffee([], 'tests/_fixture/coffee/src/');
    }

    public function testConstructPassetInvalidArgumentExceptionCase2()
    {
        $this->setExpectedException('\Passet\Exception\PassetInvalidArgumentException');
        new Coffee('tests/_fixture/static/js/', []);
    }

    public function testConstructPassetFileNotFoundException()
    {
        $this->setExpectedException('\Passet\Exception\PassetFileNotFoundException');
        new Coffee('tests/_fixture/static/js/', 'tests/_fixture/tee/');
    }

    /**
     * @group compile
     */
    public function testCompile()
    {
        $js_file = (new Coffee('tests/_fixture/static/js/', 'tests/_fixture/coffee/src/coffee1.coffee'))->compile();
        $this->assertTrue(file_exists($js_file));
        unlink($js_file);
    }
}
