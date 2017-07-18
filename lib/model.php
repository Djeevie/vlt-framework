<?php
/**
 * This file is part of the VLT Framework.
 *
 * (C) Davey Velthove <davey@velthove.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
**/

abstract class Model
{
    /**
     * @var _db Contains reference to the Database singleton-class.
     * @var _pageInformation Contains object instance of thePageInformation class.
     * @var _resultStack Array to hold fetched data from database.
    **/
    protected $_resultStack = [];

    /**
     * Constructor creates a reference to the Database singleton-class, and
     * instantiates the class PageInformation.
     **/
    public function __construct()
    {
        Database::CreateNewConnection('default');
        $this->_resultStack['settings'] = $this->setSiteSettings();
    }

    /**
     *  @return mysqli_object with all user-defined settings of this website.
     **/
    private function setSiteSettings() : Array
    {
        $sql = 'SELECT * FROM settings';
        $result = Database::Connection('default')->Query($sql);
        return $result->fetch_assoc();
    }
}
