<?php
namespace app\main;

use designetecnologia\main\Router;
use designetecnologia\main\inception\Controller;
use designetecnologia\main\exception\UndefinedActionException;

//The template will be generated by models/Layout object
use app\main\models\Layout;

/**
 * Describes App main controller for handling requests
 *
 * For PHP versions 5.4+
 *
 * @category   Framework
 * @author     Elionai Moura <eli.embits@gmail.com>
 * @copyright  2015 Design e Tecnologia by Elionai Moura <http://designetecnologia.com.br>
 * @license    The MIT license <https://opensource.org/licenses/MIT>
 * @version    0.2
 * @link       https://github.com/elionaimc/letbit-for-php
 *
 */
class App extends Controller
{

  public function __construct()
  {
    //creates a new Layout object based at the /model/Layout
    //so we can use the facilities of a template engine
    $this->layout = new Layout();
    parent::__construct();
  }

  /**
   * Implements the abstract Controller::index() function
   */
  public function index()
  {
    //defines default file for index() and default actions
    $result = $this->layout->render(dirname(__FILE__).DS.'views/main.php');
    $router->setBody($result);
  }

  public function notFound($msg = null)
  {
    /*
     * we can trigger a 404 error and render a 404 page OR
     * outputs a flash message while redirecting for index page as below
     * parent::notFound("Requisition failed. 404 ERROR!");
     */
    //defines default file for 404 ERROR page
    $result = $this->layout->render(dirname(__FILE__).DS.'views/404.php', $this->params);
    $router->setBody($result);
  }
}
