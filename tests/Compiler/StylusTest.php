<?php

use \Passet\Compiler\Stylus;

class StylusTest extends PHPUnit_Framework_TestCase
{
    const TEST_CLASS_NAME = 'Passet\Compiler\Stylus';

    public function testConstruct()
    {
        Closure::bind(function() {
            $stylus = new Stylus('tests/_fixture/static/css/', 'tests/_fixture/stylus/src/stylus.styl');
            $this->assertTrue(is_a($stylus, StylusTest::TEST_CLASS_NAME));
            $this->assertTrue(is_a($stylus->_command, 'Passet\Compiler\Command\Stylus'));
        }, $this, self::TEST_CLASS_NAME)->__invoke();
    }

    public function testConstructPassetInvalidArgumentExceptionCase1()
    {
        $this->setExpectedException('\Passet\Exception\PassetInvalidArgumentException');
        new Stylus([], 'tests/_fixture/stylus/src/stylus.styl');
    }

    public function testConstructPassetInvalidArgumentExceptionCase2()
    {
        $this->setExpectedException('\Passet\Exception\PassetInvalidArgumentException');
        new Stylus('tests/_fixture/static/css/', []);
    }

    public function testConstructPassetFileNotFoundExceptionCase1()
    {
        $this->setExpectedException('\Passet\Exception\PassetFileNotFoundException');
        new Stylus('tests/_fixture/static/css/', 'tests/_fixture/tee/');
    }

    public function testConstructPassetFileNotFoundExceptionCase2()
    {
        $this->setExpectedException('\Passet\Exception\PassetFileNotFoundException');
        new Stylus('tests/_fixture/static/csss/', 'tests/_fixture/stylus/src/stylus.styl');
    }

    /**
     * @group compile
     */
    public function testCompileWhenCompiledFileNotExists()
    {
        $css_file = (new Stylus('tests/_fixture/static/css/', 'tests/_fixture/stylus/src/stylus.styl'))->compile();
        $this->assertTrue(file_exists($css_file));
    }

    /**
     * @group compile
     * @depends testCompileWhenCompiledFileNotExists
     */
    public function testCompileWhenCompiledFileAlreadyExists()
    {
        $css_file = (new Stylus('tests/_fixture/static/css/', 'tests/_fixture/stylus/src/stylus.styl'))->compile();
        $this->assertTrue(file_exists($css_file));
        unlink($css_file);
    }
}
