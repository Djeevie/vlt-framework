<?php
/**
 * This file is part of the VLT Framework.
 *
 * (C) Davey Velthove <davey@velthove.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
**/

final class UserModel extends Model
{
    public function Index() : array
    {
        $this->_resultStack['page_title'] =
            Page::GetPageInformation('user', 'index');

        return $this->_resultStack;
    }

    public function Register() : array
    {
        $this->_resultStack['page_title'] =
            Page::GetPageInformation('user', 'register');

        return $this->_resultStack;
    }

    public function Login() : array
    {
        $this->_resultStack['page_title'] =
            Page::GetPageInformation('user', 'login');

        return $this->_resultStack;
    }

    public function Settings() : array
    {
        $this->_resultStack['page_title'] =
            Page::GetPageInformation('user', 'settings');

        return $this->_resultStack;
    }

    public function RegisterUser($post) : bool
    {

        return 1;
    }

    public function LoginUser()
    {
        return 0;
    }
}
