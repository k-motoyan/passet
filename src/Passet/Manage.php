<?php

namespace Passet;

use \Passet\Container\Container,
    \Passet\Tag\Script,
    \Passet\Tag\Style,
    \Passet\Tag\Img;

class Manage
{
    /**
     * return the Script instance.
     *
     * @param $src_path javascript src path.
     * @return Script
     */
    public static function js($src_path)
    {
        return new Script($src_path);
    }

    /**
     * output retain script tags.
     *
     * @return void
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
     * @param $src_path style sheet src path.
     * @return Style
     */
    public static function css($src_path)
    {
        return new Style($src_path);
    }

    /**
     * output retain style tags.
     *
     * @return void
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
     * @param $src_path image src path.
     * @return Img
     */
    public static function img($src_path)
    {
        return new Img($src_path);
    }
}
