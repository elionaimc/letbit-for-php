<?php
/**
 *  Object-oriented PHP Framework
 *
 * For PHP versions 5.4+
 *
 * The MIT license
 * Copyright (c) 2015
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @category   Framework
 * @author     Elionai Moura <eli.embits@gmail.com>
 * @copyright  2015 Design e Tecnologia by Elionai Moura <http://designetecnologia.com.br>
 * @license    The MIT license <https://opensource.org/licenses/MIT>
 * @version    0.1
 * @link       https://github.com/elionaimc/letbit-for-php
 *
 */

/**
 * Starts the $_SESSION variable, usable alot at this project as
 * flah() messages, user control, etc
 */
session_start();

/**
 * The next lines describes minimal stuff required on index of project
 * Don't change this block unless you REALLY KNOW what you are doing
 */
require 'definitions.php';
require 'lib'.DS.'designetecnologia'.DS.'main'.DS.'Autoload.php';

use designetecnologia\main\Router;

$autoLoad = new Autoload();
$autoLoad->setPath(ROOT);
$autoLoad->setExt('php');

spl_autoload_register(array($autoLoad, 'loadApp')); // Load files from app
spl_autoload_register(array($autoLoad, 'loadModules')); // Load files from app/modules directly
spl_autoload_register(array($autoLoad, 'loadCore')); // Load files from lib folder
spl_autoload_register(array($autoLoad, 'load')); // Load files from root folder

/**
 * Do not change the next lines
 * they are necessary to interpreting routes and render the results of requests
 * Instantiating designetecnologia\main\Router for handling URIs
 */
$router = Router::getInstance();
include_once 'routes.php';
$router->route();
$router->getBody();
if(isset($_SESSION['error']) && !is_array($_SESSION['error'])) {
    echo $_SESSION['error'];
    unset($_SESSION['error']);
}
