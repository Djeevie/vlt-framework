<?php
/**
 * This file is part of the VLT Framework.
 *
 * (C) Davey Velthove <davey@velthove.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
**/

final class Http
{
    public static function Redirect(string $url)
    {
        if (isset($_SERVER['HTTPS']))
        {
            $location = 'Location: https://'.$_SERVER['SERVER_NAME'].$url;
        }
        else
        {
            $location = 'Location: http://'.$_SERVER['SERVER_NAME'].$url;
        }

        header($location);

        die();
    }
}
