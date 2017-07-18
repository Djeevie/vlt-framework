<?php
/**
 * This file is part of the VLT Framework.
 *
 * (C) Davey Velthove <davey@velthove.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
**/

final class HomeModel extends Model
{
    public function Index() : Array
    {
        $this->_resultStack['page_title'] =
            Page::GetPageInformation('home', 'index');
        echo '<pre>',print_r($this->_resultStack),'</pre>';
        return $this->_resultStack;
    }
}
