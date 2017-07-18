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
class Verification extends Passport
{
    /**
     *  @return bool
     */
    public function ValidateAccountDetails($email, $password) : bool
    {
        (string)$sql = "SELECT * FROM `users` WHERE `email`='$email'";

        (object)$result = Database::Connection('login')->Query($sql);

        if ($result->num_rows !== 1)
        {
            JSON::Name('login')->Stack[] = "We couldn't find this user.";
            return false;
        }

        (string)$db_password = $result->fetch_object()->password;

        // Check if the password is correct
        if (password_verify($password, $db_password))
        {
            return true;
        }
        else {
            JSON::Name('login')->Stack[] = "The password is incorrect.";
            return false;
        }
    }
}
