<?php

namespace Command;

use \Passet\Compiler\Command\Coffee;

class CoffeeTest extends \PHPUnit_Framework_TestCase
{
    const TEST_CLASS_NAME = 'Passet\Compiler\Command\Coffee';

    public function testConstruct()
    {
        \Closure::bind(function() {
            $coffee = new Coffee('tests/_fixture/static/js/coffee.js', 'tests/_fixture/coffee/src/');
            $this->assertEquals($coffee->_js_path, 'tests/_fixture/static/js/coffee.js');
            $this->assertEquals($coffee->_coffee_path, 'tests/_fixture/coffee/src/');
            $this->assertEquals($coffee->_compile_type, Coffee::JOIN_COMPILE);
            $this->assertTrue(is_a($coffee, CoffeeTest::TEST_CLASS_NAME));
        }, $this, self::TEST_CLASS_NAME)->__invoke();

        \Closure::bind(function() {
            $coffee = new Coffee('tests/_fixture/static/js/', 'tests/_fixture/coffee/src/coffee1.coffee');
            $this->assertEquals($coffee->_compile_type, Coffee::SINGLE_COMPILE);
            $this->assertTrue(is_a($coffee, CoffeeTest::TEST_CLASS_NAME));
        }, $this, self::TEST_CLASS_NAME)->__invoke();
    }

    public function testConstructPassetCoffeeCompileCommandException()
    {
        $this->setExpectedException('\Passet\Exception\PassetCoffeeCompileCommandException');
        new Coffee('tests/_fixture/static/js/', 'tests/_fixture/coffee/src/coffee.coffee');
    }

    public function testBuildCompileCommand()
    {
        $coffee1 = new Coffee('tests/_fixture/static/js/', 'tests/_fixture/coffee/src/coffee1.coffee');
        $this->assertEquals(
            'coffee -c -o tests/_fixture/static/js/ tests/_fixture/coffee/src/coffee1.coffee',
            $coffee1->buildCompileCommand()
        );

        $coffee2 = new Coffee('tests/_fixture/static/js/coffee.js', 'tests/_fixture/coffee/src/');
        $this->assertEquals(
            'cat tests/_fixture/coffee/src//*.coffee | coffee -c -s > tests/_fixture/static/js/coffee.js',
            $coffee2->buildCompileCommand()
        );
    }

    public function testBuildCompileCommandException()
    {
        \Closure::bind(function() {
            $this->setExpectedException('\Exception');
            $coffee = new Coffee('tests/_fixture/static/js/', 'tests/_fixture/coffee/src/coffee1.coffee');
            $coffee->_compile_type = null;
            $coffee->buildCompileCommand();
        }, $this, self::TEST_CLASS_NAME)->__invoke();
    }

    public function testGetOutputCssFileName()
    {
        $coffee1 = new Coffee(
            str_replace('/', DIRECTORY_SEPARATOR, 'tests/_fixture/static/js/'),
            'tests/_fixture/coffee/src/coffee1.coffee'
        );
        $this->assertEquals(
            str_replace('/', DIRECTORY_SEPARATOR, 'tests/_fixture/static/js/coffee1.js'),
            $coffee1->getOutputJsFileName()
        );

        $coffee2 = new Coffee('tests/_fixture/static/js/coffee.js', 'tests/_fixture/coffee/src/');
        $this->assertEquals(
            'tests/_fixture/static/js/coffee.js',
            $coffee2->getOutputJsFileName()
        );
    }
}
