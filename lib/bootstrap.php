<?php
/**
 * This file is part of the VLT Framework.
 *
 * (C) Davey Velthove <davey@velthove.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
**/

final class Bootstrap
{
    /**
     * @var _get: Contains a sanitized duplicate of the $_GET superglobal array.
     * @var _container: Contains an instance of controller (MVC-container).
     **/
    private $_get = [];
    private $_container = [];

    /**
     * @param $request takes the $_GET superglobal array.
     **/
    public function __construct()
    {
        $this->_get = filter_var_array($_GET, FILTER_SANITIZE_STRING);

        $controller = trim($this->_get['controller']);
        $method     = trim($this->_get['method']);
        $params     = [];

        if (($controller == "") || (strlen($controller) < 2))
        {
            $controller = 'home';
        }
        else
        {
            $controller = strtolower($controller);
        }

        if (($method == "") || (strlen($method) < 2))
        {
            $method = 'index';
        }
        else
        {
            $method = strtolower($method);
        }

        $this->_get['controller'] = $controller;
        $this->_get['method'] = $method;

        // Push all other user-specified parameters in $params array.
        foreach ($this->_get as $key => $value)
        {
            if ($key != 'controller' && $key != 'method')
            {
                // Push
                $params[trim($key)] = trim($value);

                // Unset the array to avoid duplicates.
                unset($this->_get[$key]);
            }
        }

        // Once done, push the $params array to the $this->_get array.
        $this->_get['params'] = $params;
    }

    /**
     * @TODO Add try/catch blocks.
     * This function checks if the request is valid and eventually returns
     * an instance of the requested controller.
     **/
    public function Run() : bool
    {
        if (!class_exists($this->_get['controller']))
        {
            echo 'Controller does not exist.';
            return 0;
        }

        $parent = class_parents($this->_get['controller']);

        if (!in_array("Controller", $parent))
        {
            echo 'The base controller could not be found.';
            return 0;
        }

        if (!method_exists($this->_get['controller'], $this->_get['method']))
        {
            echo 'The method could not be found.';
            return 0;
        }

        $this->_container = new $this->_get['controller']($this->_get);

        // Execute
        $this->_container->ExecuteMethod();

        return 1;
    }
}
