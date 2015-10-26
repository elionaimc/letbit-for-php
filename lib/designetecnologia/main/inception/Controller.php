<?php
namespace designetecnologia\main\inception;

use designetecnologia\main\exception\UndefinedActionException;
use designetecnologia\main\Inflector;
use designetecnologia\main\Router;
use app\main\App;

/**
 * Describes an abstract Controller for Letbit Framework
 *
 * For PHP versions 5.4+
 *
 * @abstract
 * @category   Framework
 * @author     Elionai Moura <eli.embits@gmail.com>
 * @copyright  2015 Design e Tecnologia by Elionai Moura <http://designetecnologia.com.br>
 * @license    The MIT license <https://opensource.org/licenses/MIT>
 * @version    0.1
 * @link       https://github.com/elionaimc/letbit-for-php
 *
 */
abstract class Controller
{
  protected $model;
  protected $view;
  protected $data;
  public $router;
  public $params;
  public $format;

  public function __construct()
  {
    $this->model = new Model();
    $this->view = new View($this->model);
    $this->router = Router::getInstance();
    $this->params = $this->router->getParams();
    $this->format = '';
  }

  /**
   * Intercepts a non-existent action and throws a exception for it
   * @param string $action
   * @param unknown $vars
   * @throws UndefinedActionException
   */
  public function __call($action, $vars)
  {
    throw new UndefinedActionException($action);
  }

  /**
   * @return \designetecnologia\main\inception\Model
   */
  public function getModel()
  {
    return $this->model;
  }

  /**
   * @return \designetecnologia\main\inception\View
   */
  public function getView()
  {
    return $this->view;
  }

  /**
   * @method index
   * Need to be overwitten
   */
  abstract public function index();

  /**
   * Function who will get all requisition who could throw 404 NOT FOUND message
   */
  public function notFound($msg = "ERROR"){
    $_SESSION['error'][] = $msg.': action notFound!';
    (new App())->index();
  }

  /**
   * Function to print into json or xml format the array "$this->data" based in the @param format
   */
  public function printer(){
    if (isset($this->params['format'])) {
      $this->format = ($this->params['format'])?: null;
      unset($this->params['format']);
    }

    if ($this->format == "xml" && is_array($this->data)) {
      header("Content-Type: text/xml; charset=UTF-8");
      echo self::toXML();
    } elseif (is_array($this->data)) {
      header("Content-Type: application/json; charset=UTF-8");
      echo self::toJSON();
    } else $this->notFound("Data not Found - {$this->router->getController()} ERROR");
  }

  /**
   * Organize and returns the $data content in JSON format
   */
  public function toJSON()
  {
    foreach ($this->data as $d) {
      $vars = get_class_vars(get_class($d));
      foreach ($vars as $k => $v) {
        $d[$k] = ($k == "id")? intval($d->$k) : $d->$k;
      }
    }
    return json_encode($this->data);
  }

  /**
   * Organize and returns the $data content in XML format
   */
  public function toXML()
  {
  	$table = constant(get_class($this->data[0])."::TABLENAME");
    $xml = new \XMLWriter();
    $xml->openMemory();
    $xml->setIndent(true);
    $xml->startDocument('1.0', 'UTF-8');
    $xml->startElement(Inflector::pluralize($table));// root element
    foreach ($this->data as $d) {
      $xml->startElement($table);
      $vars = get_class_vars(get_class($d));
      foreach ($vars as $k => $v) {
        $xml->writeElement($k, $d->$k);
      }
      $xml->endElement();
    }
    $xml->endElement(); // end root
    return $xml->outputMemory();
  }
}
