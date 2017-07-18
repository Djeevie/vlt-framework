<?php
/**
 * This file is part of the VLT Framework.
 *
 * (C) Davey Velthove <davey@velthove.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
**/

// @TODO comment functions in this class.
abstract class Controller
{
    /**
     * @var _method The method to call in a controller.
     * @var _request A parameter specified by the user.
     * @var _viewModel Contains a class extended from Model.
     * @var _post Contains a sanitized copy of the $_POST array.
    **/
    protected $_method;
    protected $_model;
    protected $_post = [];

    public function __construct(array $request)
    {
        $this->_method  = $request['method'];
        $this->_params  = $request['params'];
        $this->_post    = filter_var_array($_POST, FILTER_SANITIZE_STRING);
        // Start session for the user.
        session_start();
    }

    // Execute the requested method.
    public function ExecuteMethod()
    {
        return $this->{$this->_method}($this->_params);
    }

    // This function generates the view. @TODO more comments
    protected function _generateView($modelResults, bool $fullview) : bool
    {
        $data = $modelResults;
        $view = '../app/views/'.
            strtolower(get_class($this)).'/'.$this->_method.'.html';

        if ($fullview)
        {
            require '../app/views/_fullview.php';
        }
        else
        {
            require '../app/views/_basicview.php';
        }

        return 1;
    }
}
