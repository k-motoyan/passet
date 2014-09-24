<?php

namespace Passet\Compiler;

abstract class CompilerAbs
{
    /**
     * Do compile.
     *
     * @return string compiled file path.
     */
    abstract public function compile();

    /**
     * Check whether compiler compile it.
     *
     * @param string $output_file
     * @param string|array $compile_files
     * @return bool
     */
    protected function _needCompile($output_file, $compile_files)
    {
        if (!file_exists($output_file)) {
            return true;
        }

        $output_file_last_update_time = $this->_getFileLastUpdateDate($output_file);
        $compile_file_last_update_time = $this->_getFileLastUpdateDate($compile_files);
        return ($compile_file_last_update_time > $output_file_last_update_time);
    }

    /**
     * Return the file last update time by DateTime object.
     * if file path is array, selected highest update time.
     *
     * @param string|array $file_pathes
     * @return \DateTime
     */
    private function _getFileLastUpdateDate($file_pathes)
    {
        if (is_array($file_pathes)) {
            $file_path = array_reduce($file_pathes, function($carry, $item) {
                $prev_time = (new \DateTime())->setTimestamp(filemtime($carry));
                $now_time = (new \DateTime())->setTimestamp(filemtime($item));
                return ($prev_time >= $now_time) ? $carry : $item;
            });
            return (new \DateTime())->setTimestamp(filemtime($file_path));
        }

        return (new \DateTime())->setTimestamp(filemtime($file_pathes));
    }
}
