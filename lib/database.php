<?php
/**
 * This file is part of the VLT Framework.
 *
 * (C) Davey Velthove <davey@velthove.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
**/

class Database
{
    /**
     * @var _connection holds the MySQLi class instances.
    **/
    private static $connections = [];
    private $db;

    private function __construct($name)
    {
        self::$connections[$name] = new MySQLi(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if (self::$connections[$name]->connect_errno)
        {
            die("A connection to the database couldn't be established.");
        }
    }

    public static function Connection(string $name)
    {
        return self::$connections[$name];
    }

    /**
     * @return Database object
    **/
    public static function CreateNewConnection(string $name) : bool
    {
        if (empty(self::$connections[$name]))
        {
            self::$connections[] = new Database($name);
            return true;
        }

        return false;
    }

    /**
     * @return string
    **/
    public function GetLastID($name) : String
    {
        return $this->db->getLastId;
    }

    /**
     * @return mixed
    **/
    public function Query(string $sql)
    {
        try
        {
            $result = $this->db->query($sql);

            if ($this->db->error)
            {
                echo $this->db->error;
                return $result;
            }
            elseif (is_bool($result))
            {
                throw new Exception("An error accoured. Our apologies for the inconvenience.", 1);
            }
        }
        catch (Exception $e)
        {
            echo $e->getMessage();
            return false;
        }

        return $result;
    }

    public function Insert(string $sql) : bool
    {
        $result = $this->db->query($sql);

        if ($this->db->error)
        {
            echo self::$this->db->error;
            die();
        }

        return $result;
    }

    // DO NOT USE@TODO Improve the code by checking wether the DB already exists or not.
    public function CreateDb(string $name) : Bool
    {
        $sql = 'CREATE DATABASE '.$name;

        if ($this->db->query($sql) === true)
        {
            return true;
        }
        else {
            return false;
        }
    }
}
