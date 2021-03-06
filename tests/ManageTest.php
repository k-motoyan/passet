<?php

use \Passet\Manage;

class ManageTest extends PHPUnit_Framework_TestCase
{
    public function testJs()
    {
        $js = Manage::js('tests/_fixture/static/js/1.js');
        $this->assertTrue(is_a($js, '\Passet\Tag\Script'));
    }

    public function testCss()
    {
        $css = Manage::css('tests/_fixture/static/css/1.css');
        $this->assertTrue(is_a($css, '\Passet\Tag\Style'));
    }

    public function testImg()
    {
        $img = Manage::img('tests/_fixture/static/img/img.gif');
        $this->assertTrue(is_a($img, '\Passet\Tag\Img'));
    }

    public function testOutputJs()
    {
        $regex1 = '<script src="tests\/_fixture\/static\/js\/1\.js" type="application\/javascript"><\/script>';
        $regex2 = '<script src="tests\/_fixture\/static\/js\/2\.js" type="application\/javascript"><\/script>';
        $this->expectOutputRegex('/' . $regex1 . $regex2 . '/');
        Manage::js('tests/_fixture/static/js/1.js')->add();
        Manage::js('tests/_fixture/static/js/2.js')->add();
        Manage::outputJs();
    }

    public function testOutputCss()
    {
        $regex1 = '<link href="tests\/_fixture\/static\/css\/1\.css" type="text\/css" rel="stylesheet" media="all">';
        $regex2 = '<link href="tests\/_fixture\/static\/css\/2\.css" type="text\/css" rel="stylesheet" media="all">';
        $this->expectOutputRegex('/' . $regex1 . $regex2 . '/');
        Manage::css('tests/_fixture/static/css/1.css')->add();
        Manage::css('tests/_fixture/static/css/2.css')->add();
        Manage::outputCss();
    }

    /**
     * @group compile
     */
    public function testHaxe()
    {
        $haxe = Manage::haxe('tests/_fixture/static/js/haxe.js', 'tests/_fixture/haxe/', 'build.hxml');
        $this->assertEquals(get_class($haxe), 'Passet\Tag\Script');
        unlink('tests/_fixture/static/js/haxe.js');
    }

    /**
     * @group compile
     */
    public function testCoffee()
    {
        $coffee = Manage::coffee('tests/_fixture/static/js/coffee.js', 'tests/_fixture/coffee/src/');
        $this->assertEquals(get_class($coffee), 'Passet\Tag\Script');
        unlink('tests/_fixture/static/js/coffee.js');
    }

    /**
     * @group compile
     */
    public function testStylus()
    {
        $stylus = Manage::stylus('tests/_fixture/static/css/', 'tests/_fixture/stylus/src/stylus.styl');
        $this->assertEquals(get_class($stylus), 'Passet\Tag\Style');
        unlink('tests/_fixture/static/css/stylus.css');
    }
}
