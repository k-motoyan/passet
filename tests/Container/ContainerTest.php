<?php

use \Passet\Container\Container,
    \Passet\Tag\Script,
    \Passet\Tag\Style;

class ContainerTest extends PHPUnit_Framework_TestCase
{
    const TEST_CLASS_NAME = 'Passet\Tag\Container';

    public function testAddScript()
    {
        $script = new Script(__FILE__);
        Container::addScript($script);
        $js_container = Container::getJsContainer();
        $this->assertEquals($script, array_shift($js_container));
    }

    public function testAddStyle()
    {
        $style = new Style(__FILE__);
        Container::addStyle($style);
        $css_container = Container::getCssContainer();
        $this->assertEquals($style, array_shift($css_container));
    }
}
