<?php

use \Passet\Tag\Script;

class ScriptTest extends PHPUnit_Framework_TestCase
{
    const TEST_CLASS_NAME = 'Passet\Tag\Script';

    public function testConstruct()
    {
        $script = new Script('tests/_fixture/static/js/1.js');
        $this->assertTrue(is_a($script, self::TEST_CLASS_NAME));

        Closure::bind(function() {
            $script = new Script('tests/_fixture/static/js/1.js');
            $this->assertEquals('tests/_fixture/static/js/1.js', $script->_attributes['src']);
            $this->assertEquals('application/javascript', $script->_attributes['type']);
        }, $this, self::TEST_CLASS_NAME)->__invoke();
    }

    public function testConstructPassetInvalidArgumentException()
    {
        $this->setExpectedException('\Passet\Exception\PassetInvalidArgumentException');
        new Script(array());
    }

    public function testConstructPassetSrcUnreadableException()
    {
        $this->setExpectedException('\Passet\Exception\PassetSrcUnreadableException');
        new Script('/path/to/not/found');
    }

    public function testBuild()
    {
        $script = new Script('tests/_fixture/static/js/1.js');
        $this->assertEquals(
            '<script src="tests/_fixture/static/js/1.js" type="application/javascript"></script>',
            $script->build()
        );
    }

    public function testBuildInline()
    {
        $script_file = file_get_contents('tests/_fixture/static/js/1.js');
        $script = new Script('tests/_fixture/static/js/1.js');
        $this->assertEquals(
            "<script type=\"application/javascript\">{$script_file}</script>",
            $script->enableAsyncLoad()->writeInline()->build()
        );
    }
}
