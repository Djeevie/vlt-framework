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
class Authorisation
{
    private static $email;
    private static $token;

    public static function SecurePage()
    {
        // Create a new database instance
        Database::CreateNewConnection('auth');

        // Is the variable set?
        if (isset($_SESSION['sessid']))
        {
            self::$token = $_SESSION['sessid'];
            // Does it exist? Check if the same token exists in the database.
            // DO NOT USE
            // if (self::checkSession())
            // {
            //     return true;
            // }
            // else {
            //     Http::Redirect('/user/login/');
            // }
            return true;
        }

        if (!isset($_COOKIE['sessid']))
        {
            Http::Redirect('/user/login/');
        }

        $sessionCookie = new Cookie('sessid');
        $sessionCookie->Load();
        self::$token = $sessionCookie->value;

        if (self::checkSession())
        {
            $_SESSION['sessid'] = self::$token;
        }
    }

    public static function IsLoggedIn()
    {
        if (isset($_SESSION['sessid']))
        {
            return true;
        }
        else {
            return false;
        }
    }

    private static function checkSession()
    {
        $sql = "SELECT `token` FROM `login_token` WHERE `token`='".self::$token."'";

        $result = Database::Connection('auth')->Query($sql);

        if ($result->num_rows == 1)
        {
            return true;
        }
        else {
            return false;
        }
    }
}
