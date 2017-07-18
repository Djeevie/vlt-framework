<?php
/**
 * This file is part of the VLT Framework.
 *
 * (C) Davey Velthove <davey@velthove.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
**/

final class Identification extends Authentication
{
    /**
     *
     *
     *  @return bool
    **/
    public function VerifyLoginData(string $username, string $password) : bool
    {
        $sql = "SELECT `email`, `password`
                FROM `users` WHERE `email`='$username'";

        $result = self::$_db->Query($sql);

        $pass_matches = password_verify($password,$result->fetch_object()->password);

        if ($pass_matches)
        {
            return true;
        }
        else
        {
            return false;
        }

    }

    public function LogUserIn(string $username)
    {
        $length = 128;

        try
        {
            if (!isset($_SESSION['session_id']))
            {
                $_SESSION['session_id'] = bin2hex(random_bytes($length));
                $_SESSION['user']       = $username;

                $sessionCookie = new Cookie('session_id');
                $sessionCookie->value = $_SESSION['session_id'];
                $sessionCookie->Save();

                $userName = new Cookie('user');
                $userName->value = $username;
                $userName->Save();
                Http::Redirect('/home/');
            }
        }
        catch (Exception $e)
        {
            echo "An error has occured: ".$e->getMessage()."<br><br>"
                    ."Our aliens are working on it.";
        }

    }

    /**
     *
     *
     *  @return bool
    **/
    public static function SecurePage()
    {
        if (!isset($_SESSION['session_id']))
        {
            if (isset($_COOKIE['session_id']))
            {
                $_SESSION['session_id'] = $_COOKIE['session_id'];
            }
            else {
                self::Redir();
            }

            return;
        }


    }

    public static function IsLoggedIn()
    {
        if (isset($_SESSION['session_id']))
        {//xdie("1");
            return true;
        }
        else {
            //die("2");
            return false;
        }
die("3");
        if ((isset($_COOKIE['session_id'])) && (isset($_SESSION['session_id'])))
        {die("4");
            if ($_COOKIE['session_id'] == $_SESSION['session_id'])
            {die("5");
                return true;
            }
            else {die("6");
                return false;
            }
        }

        return true;
    }

    private static function Redir()
    {
        Http::Redirect('/user/login/');
    }
}
