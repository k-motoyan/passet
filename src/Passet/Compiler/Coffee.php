<?php

namespace Passet\Compiler;

use \Passet\Exception\PassetInvalidArgumentException;
use \Passet\Exception\PassetFileNotFoundException;
use \Passet\Exception\PassetCompileException;

class Coffee extends CompilerAbs
{
    /** @var string compiled file put path. */
    private $_coffee_path;

    /** @var Command\Coffee coffee script compile option object. */
    private $_command;

    /**
     * Set compile option object.
     *
     * @throws PassetInvalidArgumentException
     * @throws PassetFileNotFoundException
     * @param string $js_path output path form compiled javascript.
     * @param string $coffee_path compile target coffee script path.
     */
    public function __construct($js_path, $coffee_path)
    {
        if (!is_string($js_path)) {
            throw new PassetInvalidArgumentException('first argument should be string.');
        }
        if (!is_string($coffee_path)) {
            throw new PassetInvalidArgumentException('second argument should be string.');
        }
        if (!file_exists($coffee_path)) {
            throw new PassetFileNotFoundException('coffee script path not found. path: ' . $coffee_path);
        }

        $this->_coffee_path = rtrim(str_replace('/', DIRECTORY_SEPARATOR, $coffee_path), DIRECTORY_SEPARATOR);
        $this->_command = new Command\Coffee($js_path, $coffee_path);
    }

    /**
     * javascript compile by coffee.
     *
     * @throws PassetCompileException
     * @return string output javascript file path.
     */
    public function compile()
    {
        $output_file_name = $this->_command->getOutputJsFileName();
        $coffee_path =
            is_dir($this->_coffee_path) ? glob($this->_coffee_path . DIRECTORY_SEPARATOR . '*') : $this->_coffee_path;
        if (!$this->_needCompile($output_file_name, $coffee_path)) {
            return $output_file_name;
        }

        exec($this->_command->buildCompileCommand(), $output, $result_code);
        if ($result_code > 0) {
            throw new PassetCompileException('Coffee compile Error!!');
        }
        return $this->_command->getOutputJsFileName();
    }
}