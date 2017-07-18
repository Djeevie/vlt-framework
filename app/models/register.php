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
 *  Facade
 */
final class Register
{
    private $email;
    private $password;
    private $token;

    function __construct(string $email, string $password, string $token)
    {
        $this->email           = $email;
        $this->password        = $password;
        $this->token           = $token;
        Database::CreateNewConnection('register');
    }

    public function RegisterUser() : bool
    {
        try {
            if (!Token::Check($this->token))
            {
                throw new Exception("We couldn't ensure the intigrity of your
                request. Please try again.", 1);
            }
        } catch (Exception $e) {
            die($e);
        }

        if (!$this->checkForms())
        {
            return false;
        }

        $this->addUserToDatabase();
        Http::Redirect('/user/login/');
    }

    private function checkForms()
    {
        (bool)$error = false;

        if (!Input::LegitEmail($this->email))
        {
            $error = true;
            JSON::Name('register')->Stack[] = "Please enter a valid email address.";
        }

        if (Input::DoesUserExist($this->email))
        {
            $error = true;
            JSON::Name('register')->Stack[] = "The user already exists.";
        }

        if (!Input::LegitPassword($this->password))
        {
            $error = true;
            JSON::Name('register')->Stack[] = "The password isn't valid.";
        }

        if ($error)
        {
            return false;
        }
        else {
            return true;
        }
    }

    private function addUserToDatabase()
    {
        (string)$email = $this->email;
        (string)$password = password_hash($this->password, PASSWORD_DEFAULT, ['cost' => 10]);

        (string)$sql = "INSERT INTO `users` (`email`, `password`)
                        VALUES ('$email', '$password')";

        try
        {
            $result = Database::Connection('register')->Query($sql);

            if (!$result)
            {
                throw new Exception("Due to some difficulties we're unable to
                register you at this moment. Please retry again later.", 1);
            }
        }
        catch (Exception $e)
        {
            die($e);
        }
    }
}
