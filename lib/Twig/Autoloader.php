<?php
// fix php version bug
if(!function_exists('spl_object_hash')) {
    function spl_object_hash($object){
        if (is_object($object)){
            ob_start();
            var_dump($object);
            $dump = ob_get_contents();
            ob_end_clean();
            if (preg_match('/^object\(([a-z0-9_]+)\)\#(\d)+/i', $dump, $match)) {
                return md5($match[1] . $match[2]);
            }
        }
        return null;
    }
}

/*
 * This file is part of Twig.
 *
 * (c) 2009 Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Autoloads Twig classes.
 *
 * @package twig
 * @author  Fabien Potencier <fabien@symfony.com>
 */
class Twig_Autoloader
{
    /**
     * Registers Twig_Autoloader as an SPL autoloader.
     */
    public static function register()
    {
        ini_set('unserialize_callback_func', 'spl_autoload_call');
        spl_autoload_register(array(new self, 'autoload'));
    }

    /**
     * Handles autoloading of classes.
     *
     * @param string $class A class name.
     */
    public static function autoload($class)
    {
        if (0 !== strpos($class, 'Twig')) {
            return;
        }

        if (is_file($file = dirname(__FILE__).'/../'.str_replace(array('_', "\0"), array('/', ''), $class).'.php')) {
            require $file;
        }
    }
}
