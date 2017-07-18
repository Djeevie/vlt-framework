<?php
/**
 * This file is part of the VLT Framework.
 *
 * (C) Davey Velthove <davey@velthove.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
**/
/**
 *  @TODO Rewrite the Register facade.
 **/
final class User extends Controller
{
    public function __construct(array $request)
    {
        parent::__construct($request);
        $this->_model = new UserModel();
    }

    /**
     *
     *
     *  @return void
    **/
    protected function Index(array $params)
    {
        if (Authorisation::IsLoggedIn())
        {
            Http::Redirect('/home/');
        }
        else {
            Http::Redirect('/user/login/');
        }
    }

    /**
     *  @TODO REWRITE
     *
     *  @return bool
    **/
    protected function Register(array $params)
    {
        if (Authorisation::IsLoggedIn())
        {
            Http::Redirect('/home/');
        }

        if (isset($this->_post['signup']))
        {
            (string)$email      = trim($this->_post['email']);
            (string)$password   = trim($this->_post['password']);
            (string)$token      = trim($this->_post['_token']);

            JSON::Create('register');

            $reg = new Register($email, $password, $token);
            $reg->RegisterUser();

            JSON::Name('register')->Send();
        }

        $this->_generateView($this->_model->Register(), false);

        return true;
    }

    /**
     *  @TODO Function works great, but a code review is neccessary.
     *
     *  @return bool
    **/
    protected function Login(array $params) : bool
    {
        if (Authorisation::IsLoggedIn())
        {
            Http::Redirect('/home/');
        }

        if (!empty($this->_post))
        {
            (string)$email      = trim($this->_post['email']);
            (string)$password   = trim($this->_post['password']);
            (string)$token      = trim($this->_post['_token']);

            JSON::Create('login');

            (Object)$login = new Login($email, $password, $token);

            $result = $login->LogUserIn();

            if ($result)
            {
                Http::Redirect('/home/');
            }
            else
            {
                JSON::Name('login')->Send();
            }
        }

        $this->_generateView($this->_model->Login(), false);

        return true;
    }

    /**
     *  @TODO Warning: this function does not use the cookie class yet. Rewrite it!
     *
     *  @return bool
    **/
    protected function SignOut()
    {
        setcookie('sessid', '', time() - 3600, '/', $_SERVER['SERVER_HOST'], false, true);
        session_destroy();
        Http::Redirect('/user/login');
    }

    /**
     *
     *
     *  @return bool
    **/
    protected function Settings(array $params) : bool
    {
        $this->_generateView($this->_model->Login(), true);

        return 1;
    }

    /**
     *
     *
     *  @return bool
    **/
    protected function Dashboard(array $params) : bool
    {
        $this->_generateView($this->_model->Dashboard());

        return 1;
    }
}
