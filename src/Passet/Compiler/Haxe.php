<?php

namespace Passet\Compiler;

use \Passet\Exception\PassetInvalidArgumentException;
use \Passet\Exception\PassetFileNotFoundException;
use \Passet\Exception\PassetCompileException;

class Haxe
{
    /** @var string haxe project path. */
    private $_project_path;

    /** @var string haxe build configuration file name. */
    private $_hxml_file;

    /**
     * Set haxe configuration file path.
     *
     * @throws PassetInvalidArgumentException
     * @throws PassetFileNotFoundException
     * @param string $project_path haxe project directory path.
     * @param string $hxml_file haxe configuration file name.
     */
    public function __construct($project_path, $hxml_file)
    {
        if (!is_string($project_path)) {
            throw new PassetInvalidArgumentException('first argument should be string.');
        }
        if (!file_exists($project_path)) {
            throw new PassetFileNotFoundException('project directory not found. path: ' . $project_path);
        }
        if (!is_string($hxml_file)) {
            throw new PassetInvalidArgumentException('second argument should be string.');
        }

        $hxml_path = rtrim($project_path, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $hxml_file;
        if (!file_exists($hxml_path)) {
            throw new PassetFileNotFoundException('hxml file not found. path: ' . $hxml_path);
        }

        $this->_project_path = $project_path;
        $this->_hxml_file = $hxml_file;
    }

    /**
     * javascript compile by haxe.
     *
     * @throws PassetCompileException
     */
    public function compile()
    {
        exec("cd {$this->_project_path} && haxe {$this->_hxml_file}", $output, $result_code);
        if ($result_code > 0) {
            throw new PassetCompileException('Haxe compile Error!!');
        }
    }
}