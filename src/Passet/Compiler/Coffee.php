<?php

namespace Passet\Compiler;

use \Passet\Exception\PassetInvalidArgumentException;
use \Passet\Exception\PassetFileNotFoundException;
use \Passet\Exception\PassetCompileException;

class Coffee
{
    /** @var Command\Coffee coffee script compile option object. */
    private $_option;

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

        $this->_option = new Command\Coffee($js_path, $coffee_path);
    }

    /**
     * javascript compile by coffee.
     *
     * @throws PassetCompileException
     * @return string output javascript file path.
     */
    public function compile()
    {
        exec($this->_option->buildCompileCommand(), $output, $result_code);
        if ($result_code > 0) {
            throw new PassetCompileException('Coffee compile Error!!');
        }
        return $this->_option->getOutputJsFileName();
    }
}