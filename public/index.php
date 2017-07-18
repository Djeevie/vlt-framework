<?php
/**
 * This file is part of the VLT Framework.
 *
 * (C) Davey Velthove <davey@velthove.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
**/

require '../config.php';
require '../lib/autoloader.php';

// Create new instance of the bootstrapper
$app = new Bootstrap();

// Run the application
$app->Run();
