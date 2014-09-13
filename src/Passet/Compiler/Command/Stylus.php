<?php

namespace Passet\Compiler\Command;

use \Passet\Exception\PassetStylusCompileCommandException;

class Stylus
{
    /** @var string css directory path. */
    private $_css_path;

    /** @var string stylus file path. */
    private $_stylus_path;

    /**
     * Initialize css path and stylus path.
     *
     * @throws PassetStylusCompileCommandException
     * @param string $css_path css output directory path.
     * @param string $stylus_path stylus file path.
     */
    public function __construct($css_path, $stylus_path)
    {
        if ( !(is_dir($css_path) && is_file($stylus_path)) ) {
            throw new PassetStylusCompileCommandException('illegal arguments.');
        }

        $this->_css_path = $css_path;
        $this->_stylus_path = $stylus_path;
    }

    /**
     * Get stylus compilation command.
     *
     * @return string compile command.
     */
    public function buildCompileCommand()
    {
        return "stylus {$this->_stylus_path} -o {$this->_css_path}";
    }

    /**
     * Get output css file name.
     *
     * @return string output css file name.
     */
    public function getOutputCssFileName()
    {
        $css_file = str_replace('.styl', '.css', basename($this->_stylus_path));
        return rtrim($this->_css_path, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $css_file;
    }
}
