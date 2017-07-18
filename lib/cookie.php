<?php
/**
 * This file is part of the VLT Framework.
 *
 * (C) Davey Velthove <davey@velthove.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
**/

class Cookie
{
    private $name;
    private $value;
    private $options = [];

    /**
     *  @return mixed
    **/
    public function __set($key, $value)
    {
        $this->{$key} = $value;
    }

    /**
     *  @return mixed
    **/
    public function __get($name)
    {
        return $this->{$name};
    }

    /**
     *  @return mixed
    **/
    public function __construct( $name)
    {
        $this->name = $name;
    }
// @TODO FIX BUG
    // /**
    //  *  @return mixed
    // **/
    // public function Save() : bool
    // {
    //     if (!empty($this->options))
    //     {
    //         $arg = $this->options;
    //         $this->setCookie($arg[0], $arg[1], $arg[2], $arg[3], $arg[4]);
    //         return true;
    //     }
    //     else
    //     {
    //         $this->setCookie(time() + 3600);
    //         return true;
    //     }
    //
    //     return false;
    // }

    /**
     *  @return mixed
    **/
    public function Save($expires, string $path = "/", string $domain = null, bool $secure = false, bool $httponly = true)
    {
        setcookie($this->name, $this->value, $expires, $path, $domain, $secure, $httponly);
    }

    /**
     *  @return mixed
    **/
    private function Load()
    {
        $this->value = isset($_COOKIE[$this->name]) ? $_COOKIE[$this->name] : null;
    }

    public function Remove() : bool
    {
        setcookie($this->name, "", time() - 3600);

        if (isset($_COOKIE[$this->name]))
            return false;

        return true;
    }
}
