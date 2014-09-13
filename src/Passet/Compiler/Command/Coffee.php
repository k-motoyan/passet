<?php

namespace Passet\Compiler\Command;

use \Passet\Exception\PassetCoffeeCompileCommandException;

class Coffee
{
    /** @const type of compilation with single file. */
    const SINGLE_COMPILE = 1;

    /** @const type of compilation with multi file. */
    const JOIN_COMPILE = 2;

    /** @var int type of compilation. */
    private $_compile_type;

    /** @var string javascript path (file or directory). */
    private $_js_path;

    /** @var string coffee path (file or directory). */
    private $_coffee_path;

    /**
     * Initialize js path and coffee path and compile type.
     *
     * @throws PassetCoffeeCompileCommandException
     * @param string $js_path
     * @param string $coffee_path
     */
    public function __construct($js_path, $coffee_path)
    {
        if ( (is_dir($js_path) || is_file($js_path)) && is_file($coffee_path) ) {
            $this->_compile_type = self::SINGLE_COMPILE;
        } else if (is_dir($coffee_path)) {
            $this->_compile_type = self::JOIN_COMPILE;
        } else {
            throw new PassetCoffeeCompileCommandException('illegal arguments.');
        }

        $this->_js_path = $js_path;
        $this->_coffee_path = $coffee_path;
    }

    /**
     * Get coffee compilation command.
     *
     * @throws \Exception
     * @return string compile command.
     */
    public function buildCompileCommand()
    {
        if ($this->_compile_type === self::SINGLE_COMPILE) {
            $compile_command = "coffee -c -o {$this->_js_path} {$this->_coffee_path}";
        } else if ($this->_compile_type === self::JOIN_COMPILE) {
            $compile_command = "cat {$this->_coffee_path}/*.coffee | coffee -c -s > {$this->_js_path}";
        } else {
            throw new \Exception('with out fail.');
        }
        return $compile_command;
    }

    /**
     * Get output javascript file name.
     *
     * @return string output javascript file name.
     */
    public function getOutputJsFileName()
    {
        if ($this->_compile_type === self::JOIN_COMPILE) {
            return $this->_js_path;
        }

        $js_file = str_replace('.coffee', '.js', basename($this->_coffee_path));
        return rtrim($this->_js_path, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $js_file;
    }
}
