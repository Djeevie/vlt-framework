<?php
/**
 * This file is part of the VLT Framework.
 *
 * (C) Davey Velthove <davey@velthove.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
**/

final class VideoModel extends Model
{
    public function Index() : array
    {
        $this->_resultStack['page_title'] =
            $this->_pageInformation->GetPageInformation('video', 'index');

        return $this->_resultStack;
    }

    public function Page(int $page) : array
    {
        $this->_resultStack['page_title'] =
            $this->_pageInformation->GetPageInformation('video', 'page');
    }
}
