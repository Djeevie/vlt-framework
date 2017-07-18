<?php
/**
 * This file is part of the VLT Framework.
 *
 * (C) Davey Velthove <davey@velthove.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
**/

final class Register extends Model
{
    public function RegisterUser(string $username, string $password) : bool
    {
        $password = password_hash($password, PASSWORD_DEFAULT, ['cost' => 10]);

        $sql = "INSERT INTO `users` (`email`, `password`)
                VALUES ('$username', '$password')";

        self::$_db->Insert($sql);

        return true;
    }
}
