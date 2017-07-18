<?php
/**
 * This file is part of the VLT Framework.
 *
 * (C) Davey Velthove <davey@velthove.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
**/

class Authentication extends Model
{
    protected static $_username;
    protected static $_password;

    /**
     *
     *
     *  @return bool
    **/
    private static function ValidateEmail(string $address) : bool
    {
        if (!filter_var($address, FILTER_VALIDATE_EMAIL))
        {
            return false;
        }

        list($user, $domain) = explode('@', $address);

        if (!checkdnsrr($domain, 'MX'))
        {
            return false;
        }

        return true;
    }

    /**
     *
     *
     *  @return bool
    **/
    private static function ValidatePassword(string $password) : bool
    {
        if (strlen($password) < 5)
        {
            return false;
        }

        return true;
    }

    /**
     *  This public function checks both the e-mail and password provided.
     *
     *  @return int
    **/
    public static function CheckAuthForms($email, $password) : int
    {
        if ((!empty($email)) && (!empty($password)))
        {
            if (!self::ValidateEmail($email))
            {
                return 2;
            }
            elseif (!self::ValidatePassword($password))
            {
                return 3;
            }

        }

        if (empty($email))
        {
            return 4;
        }

        if (empty($password))
        {
            return 5;
        }

        return 1;
    }

    /**
     *
     *
     *  @return bool
    **/
    public static function UserExists($email) : bool
    {
        $sql = "SELECT `email` FROM `users` WHERE `email`='$email'";

        $result = self::$_db->Query($sql);

        if ($result->num_rows > 0)
        {
            return true;
        }
        else {
            return false;
        }
    }
}
