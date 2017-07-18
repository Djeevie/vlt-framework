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
class Input
{
    public static function LegitEmail($address)
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

    public static function LegitPassword($password)
    {
        if (strlen($password) < 5)
        {
            return false;
        }

        return true;
    }

    public static function DoesUserExist($email)
    {
        (string)$sql = "SELECT * FROM `users` WHERE `email`='$email'";

        (object)$result = Database::Connection('default')->Query($sql);

        if ($result->num_rows == 1)
        {
            return true;
        } else {
            return false;
        }
    }
}
