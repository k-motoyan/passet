<?php

namespace Passet\Compiler;

use \Passet\Exception\PassetInvalidArgumentException;
use \Passet\Exception\PassetFileNotFoundException;
use \Passet\Exception\PassetCompileException;

class Stylus
{
    /** @var Command\Stylus stylus compile option object. */
    private $_option;

    /**
     * Set compile option object.
     *
     * @throws PassetInvalidArgumentException
     * @throws PassetFileNotFoundException
     * @param string $css_path output path form compiled css.
     * @param string $stylus_path compile target stylus path.
     */
    public function __construct($css_path, $stylus_path)
    {
        if (!is_string($css_path)) {
            throw new PassetInvalidArgumentException('first argument should be string.');
        }
        if (!is_string($stylus_path)) {
            throw new PassetInvalidArgumentException('second argument should be string.');
        }
        if (!file_exists($css_path)) {
            throw new PassetFileNotFoundException('css path not found. path: ' . $css_path);
        }
        if (!file_exists($stylus_path)) {
            throw new PassetFileNotFoundException('stylus path not found. path: ' . $stylus_path);
        }

        $this->_option = new Command\Stylus($css_path, $stylus_path);
    }

    /**
     * css compile by stylus.
     *
     * @throws PassetCompileException
     * @return string output css file path.
     */
    public function compile()
    {
        exec($this->_option->buildCompileCommand(), $output, $result_code);
        if ($result_code > 0) {
            throw new PassetCompileException('Stylus compile Error!!');
        }
        return $this->_option->getOutputCssFileName();
    }
}