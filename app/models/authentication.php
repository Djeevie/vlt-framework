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
 *
 */
final class Authentication extends Passport
{
    // DO NOT USE @TIME FUNCTION
    public function CreateToken($time = null)
    {
        $this->_token = Token::GenerateToken(1024);
        //$this->addToDatabase();
        $_SESSION['sessid'] = $this->_token;
        $this->sendSessionCookie();
        //var_dump($_SESSION);
    }

    // DO NOT USE
    private function addToDatabase()
    {
        (string)$sql = "SELECT `id` FROM `users` WHERE `email`='$this->_email'";

        (object)$result = Database::Connection('login')->Query($sql);
        $this->_userID = $result->fetch_object()->id;

        (string)$sql = "INSERT INTO `login_tokens` (`user`, `token`)
                        VALUES ('$this->userID','$this->_token')";

        $result = Database::Connection('login')->Query($sql);
    }

    private function sendSessionCookie($time = null)
    {
        if (!isset($time))
        {
            $time = time() + (52*7*24*60*60);
        }

        $session = new Cookie('sessid');

        $session->value = $this->_token;

        $session->Save($time);
        //$session->Remove();
    }
}
