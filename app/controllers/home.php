<?php
/**
 * This file is part of the VLT Framework.
 *
 * (C) Davey Velthove <davey@velthove.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
**/

class Home extends Controller
{
    public function __construct(array $request)
    {
        parent::__construct($request);
        $this->_model = new HomeModel();
        Authorisation::SecurePage();
    }

    protected function Index(array $params) : bool
    {
        $this->_generateView($this->_model->Index(), true);

        return 1;
    }
}
