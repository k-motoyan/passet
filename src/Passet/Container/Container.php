<?php

namespace Passet\Container;

use \Passet\Tag\Script,
    \Passet\Tag\Style;

class Container
{
    /** @var Script[] retain of \PassetTag\Script objects. */
    private static $_js_container = array();

    /** @var Style[] retain of \PassetTag\Style objects. */
    private static $_css_container = array();

    /**
     * add container to \Passet\Tag\Script instance.
     *
     * @param Script $tag_script \Passet\Tag\Script instance.
     * @return void
     */
    public static function addScript(Script $tag_script)
    {
        self::$_js_container[] = $tag_script;
    }

    /**
     * add container to \Passet\Tag\Style instance.
     *
     * @param Style $tag_style \Passet\Tag\Style instance.
     * @return void
     */
    public static function addStyle(Style $tag_style)
    {
        self::$_css_container[] = $tag_style;
    }

    /**
     * return the array with \Passet\Tag\Script instance.
     *
     * @return Script[]
     */
    public static function getJsContainer()
    {
        return self::$_js_container;
    }

    /**
     * return the array with \Passet\Tag\Style instance.
     *
     * @return Style[]
     */
    public static function getCssContainer()
    {
        return self::$_css_container;
    }
}
