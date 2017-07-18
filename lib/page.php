<?php
/**
 * This file is part of the VLT Framework.
 *
 * (C) Davey Velthove <davey@velthove.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
**/

final class Page extends Model
{
    /**
     * @param $controller takes the name of a controller.
     * @param $method takes the name of the method being used.
     **/
    public static function GetPageInformation(string $controller, string $method) : String
    {
        return self::getTitle($controller, $method);
    }

    /**
     * @param $controller takes the name of a controller.
     * @param $method takes the name of the method being used.
     * @TODO add error handling here
     **/
    private static function getTitle($controller, $method) : String
    {
        $sql = "SELECT `page_title` FROM `pages`
                WHERE `controller`='$controller'
                AND `method`='$method'";

        $result = Database::Connection('default')->Query($sql);
        return $result->fetch_object()->page_title;
    }
}
