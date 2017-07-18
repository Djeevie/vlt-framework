<?php
/**
 * This file is part of the VLT Framework.
 *
 * (C) Davey Velthove <davey@velthove.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
**/

spl_autoload_register(function($className)
{
    $_autoLoader = new Autoloader($className);
});

// The class in this file represents an ultra-simple autoloader.
// @TODO Implement a PSR-4 compliant autoloader. I don't like bad code.
final class Autoloader
{
    /**
     *  @var _classStack holds strings with the location to classes.
    **/
    private $_classStack = [];

    /**
     * Constructor fills an array with strings, containing location paths, and
     * then requires the file with the required class.
     *  @param $classname takes the name of a required class.
     **/
    public function __construct(string $className)
    {
        $className = strtolower($className);

        array_push($this->_classStack,
            "../app/controllers/".$className.".php");
        array_push($this->_classStack,
            "../app/models/".$className.".php");
        array_push($this->_classStack,
            "../app/views/".$className.".php");
        array_push($this->_classStack,
            "../lib/".$className.".php");

        $this->_load();

        return;
    }

    // Require PHP file containing required class.
    private function _load()
    {
        foreach ($this->_classStack as $key)
        {
            if (file_exists($key))
            {
                require($key);
                break;
            }
        }
    }

}
