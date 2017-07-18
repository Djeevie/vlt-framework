<?php
/**
 * This file is part of the VLT Framework.
 *
 * (C) Davey Velthove <davey@velthove.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
**/

class JSON
{
    private static $instances = [];
    public $Stack = [];

    public static function Create(string $name) : bool
    {
        if (!empty($instances[$name]))
        {
            return false;
        }

        self::$instances[$name] = new JSON();
        return true;
    }

    public static function Name(string $name) : self
    {
        return self::$instances[$name];
    }

    public function Send()
    {
        $json = json_encode($this->Stack);
        echo $json;
	}
}
