<?php

namespace Passet;

use \Passet\Container\Container;
use \Passet\Tag\Script;
use \Passet\Tag\Style;
use \Passet\Tag\Img;
use \Passet\Compiler\Haxe;
use \Passet\Compiler\Coffee;
use \Passet\Compiler\Stylus;

class Manage
{
    /** @var array passet optional parameters. */
    private static $_parameters;

    /**
     * initialize passet.
     *
     * @param array $parameters
     */
    public static function setting(array $parameters=array())
    {
        $default_parameters = include 'Config/Parameter.php';
        self::$_parameters = array_merge($default_parameters, $parameters);
    }

    /**
     * return the Script instance.
     *
     * @param string $src_path javascript src path.
     * @return Script
     */
    public static function js($src_path)
    {
        return new Script( self::_generatePath(self::$_parameters['js_base_path'], $src_path) );
    }

    /**
     * output retain script tags.
     */
    public static function outputJs()
    {
        foreach (Container::getJsContainer() as $js) {
            echo $js->build();
        }
    }

    /**
     * return the Style instance.
     *
     * @param string $src_path style sheet src path.
     * @return Style
     */
    public static function css($src_path)
    {
        return new Style( self::_generatePath(self::$_parameters['css_base_path'], $src_path) );
    }

    /**
     * output retain style tags.
     */
    public static function outputCss()
    {
        foreach (Container::getCssContainer() as $css) {
            echo $css->build();
        }
    }

    /**
     * return the Img instance.
     *
     * @param string $src_path image src path.
     * @return Img
     */
    public static function img($src_path)
    {
        return new Img( self::_generatePath(self::$_parameters['img_base_path'], $src_path) );
    }

    /**
     * return the Script instance from compiled javascript by haxe.
     *
     * @param string $src_path compiled javascript src path.
     * @param string $project_path haxe project directory path.
     * @param string $hxml_file haxe compile option file.
     * @return Script
     */
    public static function haxe($src_path, $project_path, $hxml_file)
    {
        (new Haxe($project_path, $hxml_file))->compile();
        return self::js($src_path);
    }

    /**
     * return the Script instance from compiled javascript by coffee.
     *
     * @param string $js_path
     * @param string $coffee_path
     * @return Script
     */
    public static function coffee($js_path, $coffee_path)
    {
        $js_file_path = (new Coffee($js_path, $coffee_path))->compile();
        return self::js($js_file_path);
    }

    /**
     * return the Style instance from compiled css by stylus.
     *
     * @param string $css_path output css directory path.
     * @param string $stylus_path compilation stylus file path.
     * @return Style
     */
    public static function stylus($css_path, $stylus_path)
    {
        $css_file_path = (new Stylus($css_path, $stylus_path))->compile();
        return self::css($css_file_path);
    }

    /**
     * return the combined base path and original path.
     *
     * @param string $base_path file base path.
     * @param string $original_path file original path.
     * @return string
     */
    private static function _generatePath($base_path, $original_path)
    {
        if (empty($base_path)) {
            return $original_path;
        }

        $ds = DIRECTORY_SEPARATOR;
        return rtrim($base_path, $ds) . $ds . ltrim($original_path, $ds);
    }
}
