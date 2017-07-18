<?php
/**
 * This file is part of the VLT Framework.
 *
 * (C) Davey Velthove <davey@velthove.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
**/

class Contact extends Controller
{
    public function __construct(array $request)
    {
        parent::__construct($method, $request);
        $this->_model = new ContactModel();
    }

    protected function Index($params)
    {

    }
}
