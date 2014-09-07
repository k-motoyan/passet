<?php

use \Passet\Compiler\Haxe;

class HaxeTest extends PHPUnit_Framework_TestCase
{
    const TEST_CLASS_NAME = 'Passet\Compiler\Haxe';

    public function testConstruct()
    {
        Closure::bind(function() {
            $haxe = new Haxe('tests/_fixture/haxe/', 'build.hxml');
            $this->assertTrue(is_a($haxe, HaxeTest::TEST_CLASS_NAME));
            $this->assertEquals('tests/_fixture/haxe/', $haxe->_project_path);
            $this->assertEquals('build.hxml', $haxe->_hxml_file);
        }, $this, self::TEST_CLASS_NAME)->__invoke();
    }

    public function testConstructPassetInvalidArgumentExceptionCase1()
    {
        $this->setExpectedException('\Passet\Exception\PassetInvalidArgumentException');
        new Haxe(array(), 'build.hxml');
    }

    public function testConstructPassetInvalidArgumentExceptionCase2()
    {
        $this->setExpectedException('\Passet\Exception\PassetInvalidArgumentException');
        new Haxe('tests/_fixture/haxe/', array());
    }

    public function testConstructPassetFileNotFoundExceptionCase1()
    {
        $this->setExpectedException('\Passet\Exception\PassetFileNotFoundException');
        new Haxe('tests/_fixture/haxe/', 'compile.hxml');
    }

    public function testConstructPassetFileNotFoundExceptionCase2()
    {
        $this->setExpectedException('\Passet\Exception\PassetFileNotFoundException');
        new Haxe('', 'build.hxml');
    }

    /**
     * @group compile
     */
    public function testCompile()
    {
        (new Haxe('tests/_fixture/haxe/', 'build.hxml'))->compile();
        $this->assertTrue(file_exists('tests/_fixture/static/js/haxe.js'));
        unlink('tests/_fixture/static/js/haxe.js');
    }
}
