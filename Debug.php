<?php

/**
 * @package Flextype Components
 *
 * @author Sergey Romanenko <awilum@yandex.ru>
 * @link http://components.flextype.org
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flextype\Component\Debug;

class Debug
{
    /**
     * Time
     *
     * @var array
     */
    protected static $time = [];

    /**
     * Memory
     *
     * @var array
     */
    protected static $memory = [];

    /**
     * Save current time for current point
     *
     * Debug::elapsedTimeSetPoint('point_name');
     *
     * @param string $point_name Point name
     */
    public static function elapsedTimeSetPoint(string $point_name) : void
    {
        Debug::$time[$point_name] = microtime(true);
    }

    /**
     * Get elapsed time for current point
     *
     * echo Debug::elapsedTime('point_name');
     *
     * @param  string $point_name Point name
     * @return string
     */
    public static function elapsedTime(string $point_name) : string
    {
        if (isset(Debug::$time[$point_name])) return sprintf("%01.4f", microtime(true) - Debug::$time[$point_name]);
    }

    /**
     * Save current memory for current point
     *
     * Debug::memoryUsageSetPoint('point_name');
     *
     * @param string $point_name Point name
     */
    public static function memoryUsageSetPoint(string $point_name) : void
    {
        Debug::$memory[$point_name] = memory_get_usage();
    }

    /**
     * Get memory usage for current point
     *
     * echo Debug::memoryUsage('point_name');
     *
     * @param  string $point_name Point name
     * @return string
     */
    public static function memoryUsage(string $point_name) : string
    {
        if (isset(Debug::$memory[$point_name])) {
            $unit = array('B', 'KB', 'MB', 'GB', 'TiB', 'PiB');
            $size = memory_get_usage() - Debug::$memory[$point_name];
            $memory_usage = @round($size/pow(1024, ($i=floor(log($size, 1024)))), 2).' '.$unit[($i < 0 ? 0 : $i)];
            return $memory_usage;
        }
    }

    /**
     * Print the variable $data and exit if exit = true
     *
     * Debug::dump($data);
     *
     * @param mixed   $data Data
     * @param bool    $exit Exit
     */
    public static function dump($data, bool $exit = false) : void
    {
        echo "<pre>dump \n---------------------- \n\n" . print_r($data, true) . "\n----------------------</pre>";
        if ($exit) exit;
    }

    /**
     * Prints a list of all currently declared classes.
     *
     * Debug::classes();
     *
     * @access public
     * @return string
     */
    public static function classes()
    {
        return Debug::dump(get_declared_classes());
    }

    /**
     * Prints a list of all currently declared interfaces.
     *
     * Debug::interfaces();
     *
     * @access public
     * @return string
     */
    public static function interfaces()
    {
        return Debug::dump(get_declared_interfaces());
    }

    /**
     * Prints a list of all currently included (or required) files.
     *
     * Debug::includes();
     *
     * @access public
     * @return string
     */
    public static function includes()
    {
        return Debug::dump(get_included_files());
    }

    /**
     * Prints a list of all currently declared functions.
     *
     * Debug::functions();
     *
     * @access public
     * @return string
     */
    public static function functions()
    {
        return Debug::dump(get_defined_functions());
    }

    /**
     * Prints a list of all currently declared constants.
     *
     * Debug::constants();
     *
     * @access public
     * @return string
     */
    public static function constants()
    {
        return Debug::dump(get_defined_constants());
    }

    /**
     * Prints a list of all currently loaded PHP extensions.
     *
     * Debug::extensions();
     *
     * @access public
     * @return string
     */
    public static function extensions()
    {
        return Debug::dump(get_loaded_extensions());
    }

    /**
     * Prints a list of the configuration settings read from php.ini
     *
     * Debug::phpini();
     *
     * @access public
     * @return string
     */
    public static function phpini()
    {
        if (!is_readable(get_cfg_var('cfg_file_path'))) {
            return false;
        }

        return Debug::dump(parse_ini_file(get_cfg_var('cfg_file_path'), true));
    }
}
