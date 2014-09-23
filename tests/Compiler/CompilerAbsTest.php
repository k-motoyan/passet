<?php

class CompilerAbsTest extends PHPUnit_Framework_TestCase
{
    const TEST_CLASS_NAME = 'Passet\Compiler\CompilerAbs';

    const TEST_TMP_COMPILE_FILE = 'tests/_fixture/tmp/compile.txt';

    const TEST_TMP_OUTPUT_FILE = 'tests/_fixture/tmp/output.txt';

    const TEST_TMP_FILE = 'tests/_fixture/tmp/file';

    public $tmp_compile_file;

    public $tmp_output_file;

    public $tmp_file;

    public function setUp()
    {
        $this->tmp_compile_file = str_replace('/', DIRECTORY_SEPARATOR, self::TEST_TMP_COMPILE_FILE);
        $this->tmp_output_file = str_replace('/', DIRECTORY_SEPARATOR, self::TEST_TMP_OUTPUT_FILE);
        $this->tmp_file = str_replace('/', DIRECTORY_SEPARATOR, self::TEST_TMP_FILE);
    }

    public function testNeedCompileWhenOutputFileNotExists()
    {
        Closure::bind(function() {
            file_put_contents($this->tmp_compile_file, 'tmp');
            $compiler = $this->getMockForAbstractClass(CompilerAbsTest::TEST_CLASS_NAME);
            $this->assertTrue($compiler->_needCompile($this->tmp_output_file, $this->tmp_compile_file));
            sleep(1);
        }, $this, self::TEST_CLASS_NAME)->__invoke();
    }

    /**
     * @depends testNeedCompileWhenOutputFileNotExists
     */
    public function testNeedCompileWhenOutputFileUpdateTimeGraterThanCompileFileUpdateTime()
    {
        Closure::bind(function() {
            file_put_contents($this->tmp_output_file, 'tmp');
            $compiler = $this->getMockForAbstractClass(CompilerAbsTest::TEST_CLASS_NAME);
            $this->assertFalse($compiler->_needCompile($this->tmp_output_file, $this->tmp_compile_file));
            sleep(1);
        }, $this, self::TEST_CLASS_NAME)->__invoke();
    }

    /**
     * @depends testNeedCompileWhenOutputFileUpdateTimeGraterThanCompileFileUpdateTime
     */
    public function testNeedCompileWhenOutputFileUpdateTimeLessThanCompileFileUpdateTime()
    {
        Closure::bind(function() {
            file_put_contents($this->tmp_compile_file, 'tmp');
            $compiler = $this->getMockForAbstractClass(CompilerAbsTest::TEST_CLASS_NAME);
            $this->assertTrue($compiler->_needCompile($this->tmp_output_file, $this->tmp_compile_file));
            unlink($this->tmp_output_file);
            unlink($this->tmp_compile_file);
        }, $this, self::TEST_CLASS_NAME)->__invoke();
    }

    public function testGetFileLastUpdateDateWhenParamTypeString()
    {
        Closure::bind(function() {
            file_put_contents($this->tmp_file, 'tmp');
            $expect_datetime = (new \DateTime())->setTimestamp(filemtime($this->tmp_file));

            $compiler = $this->getMockForAbstractClass(CompilerAbsTest::TEST_CLASS_NAME);
            $actual_datetime = $compiler->_getFileLastUpdateDate($this->tmp_file);

            $this->assertEquals($actual_datetime, $expect_datetime);
            unlink($this->tmp_file);
        }, $this, self::TEST_CLASS_NAME)->__invoke();
    }

    public function testGetFileLastUpdateDateWhenParamTypeArray()
    {
        Closure::bind(function() {
            $files = [];
            foreach (range(1, 3) as $i) {
                $files[] = $this->tmp_file . $i;
                file_put_contents($this->tmp_file . $i, 'tmp');
                sleep(1);
            }
            $expect_datetime = (new \DateTime())->setTimestamp(filemtime($files[2]));

            $compiler = $this->getMockForAbstractClass(CompilerAbsTest::TEST_CLASS_NAME);
            $actual_datetime = $compiler->_getFileLastUpdateDate($files);

            $this->assertEquals($actual_datetime, $expect_datetime);

            foreach ($files as $file) {
                unlink($file);
            }
        }, $this, self::TEST_CLASS_NAME)->__invoke();
    }
}