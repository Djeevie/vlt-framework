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
 *
 */
final class Login extends Passport
{
    private $verification;
    private $authentication;
    private $authorisation;

    public function __construct($email, $password, $token)
    {
        $this->verification     = new Verification();
        $this->authentication   = new Authentication();
        $this->authorisation    = new Authorisation();
        $this->_email           = $email;
        $this->_password        = $password;
        $this->_token           = $token;
        Database::CreateNewConnection('login');
    }

    public function LogUserIn()
    {
        try
        {
            // First, check the form token.
            if (!Token::Check($this->_token))
            {
                throw new Exception("The security token doesn't match.", 1);
            }

            // Check the credentials.
            if (!$this->CheckCredentials())
            {
                return false;
            }

            //If they're valid, the user receives a token and gets redirected.
            $this->authentication->CreateToken();
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }

        return true;
    }

    private function CheckCredentials() : bool
    {
        (bool)$success = $this->verification->ValidateAccountDetails($this->_email, $this->_password);

        // If there's an error
        if (!$success)
        {
            return false;
        }

        return true;
    }
}
