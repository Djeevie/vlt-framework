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
 *  @return int
 */
class Token
{
    private static $form_token;

    public static function GenerateToken(int $length) : string
    {
        if ($length < 8 || $length > 50000)
        {
            $length = 8;
        }

        $token = bin2hex(random_bytes($length));

        return $token;
    }

    public static function GetForm()
    {
        if (empty(self::$form_token))
            self::$form_token = self::GenerateToken(8);

        $_SESSION['form_token'] = self::$form_token;

        $html = "<input name='_token' value='".self::$form_token."' type='hidden'/>";

        return $html;
    }

    public static function Check($token)
    {
        if (isset($_SESSION['form_token']))
        {
            if ($_SESSION['form_token'] == $token)
            {
                return true;
            }
        }

        return false;
    }
}
