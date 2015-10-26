<?php
/**
 * ATTENTION: you will need carefully do changes to add lines to these next block to make it useful
 * The routes follows the name detailed like the example below
 *
 * @example the following line is a example of a route definition
 * --URL mysite/mycontroller calls App/main/controllers/MyController--
 * $router->route['mycontroller'] = 'App'.DS.'controllers'.DS.'Controller'
 *
 * @example the following line is another example
 * --URL mysite/controller calls App/Main/App controller--
 * $router->route['controller'] = APP.DS.'App';
 *
 * @category   Framework
 * @author     Elionai Moura <eli.embits@gmail.com>
 * @copyright  2015 Design e Tecnologia by Elionai Moura <http://designetecnologia.com.br>
 * @license    The MIT license <https://opensource.org/licenses/MIT>
 * @version    0.1
 * @link       https://github.com/elionaimc/letbit-for-php
 *
 */
// Pointing to {root} redirects to App/Main/App->index() function
$router->route[''] = APP.DS.'App';
$router->route['index'] = APP.DS.'App';

/**
 * Routes defined by you can come bellow,
 * what will facilitate your job for debugging or maintenance
 * +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
 */


/**
 * +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
 * End of your personal routes definition
 */
