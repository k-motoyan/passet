<?php

namespace Command;

use \Passet\Compiler\Command\Stylus;

class StylusTest extends \PHPUnit_Framework_TestCase
{
    const TEST_CLASS_NAME = 'Passet\Compiler\Command\Stylus';

    public function testConstruct()
    {
        \Closure::bind(function() {
            $stylus = new Stylus('tests/_fixture/static/css/', 'tests/_fixture/stylus/src/stylus.styl');
            $this->assertEquals($stylus->_css_path, 'tests/_fixture/static/css/');
            $this->assertEquals($stylus->_stylus_path, 'tests/_fixture/stylus/src/stylus.styl');
            $this->assertTrue(is_a($stylus, StylusTest::TEST_CLASS_NAME));
        }, $this, self::TEST_CLASS_NAME)->__invoke();
    }

    public function testConstructPassetStylusCompileCommandException()
    {
        $this->setExpectedException('\Passet\Exception\PassetStylusCompileCommandException');
        new Stylus('tests/_fixture/static/css/', 'tests/_fixture/stylus/src/');
    }

    public function testBuildCompileCommand()
    {
        $stylus = new Stylus('tests/_fixture/static/css/', 'tests/_fixture/stylus/src/stylus.styl');
        $this->assertEquals(
            'stylus tests/_fixture/stylus/src/stylus.styl -o tests/_fixture/static/css/',
            $stylus->buildCompileCommand()
        );
    }

    public function testGetOutputCssFileName()
    {
        $stylus = new Stylus(
            str_replace('/', DIRECTORY_SEPARATOR, 'tests/_fixture/static/css/'),
            'tests/_fixture/stylus/src/stylus.styl'
        );

        $this->assertEquals(
            str_replace('/', DIRECTORY_SEPARATOR, 'tests/_fixture/static/css/stylus.css'),
            $stylus->getOutputCssFileName()
        );
    }
}
