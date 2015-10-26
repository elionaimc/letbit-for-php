<?php
namespace designetecnologia\main;

use designetecnologia\main\exception\LoggedException;

/**
 * Describes a basic Router for Letbit Framework
 *
 * It´s used parsing the requests URIs
 * like /controller/action/param_1/value_1/(...)/param_N/value_N
 *
 * For PHP versions 5.4+
 *
 * @category   Framework
 * @author     Elionai Moura <eli.embits@gmail.com>
 * @copyright  2015 Design e Tecnologia by Elionai Moura <http://designetecnologia.com.br>
 * @license    The MIT license <https://opensource.org/licenses/MIT>
 * @version    0.1
 * @link       https://github.com/elionaimc/letbit-for-php
 *
 */
class Router
{
    protected $controller;
    protected $action;
    protected $params;
    protected $body;
    protected $view;

    public $request;
    public $route = array();

    static $instance;

    /**
     * Public static method that calls the Router instance
     * @return Router
     */
    public static function getInstance()
    {
        if (!(self::$instance instanceof self)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct()
    {
        $request = ($this->request) ? $this->request : $_SERVER['REQUEST_URI']; // Address of request
        $slices = explode('/', trim($request, '/')); // Splits the request in well known parts

        // Identifies the controller's calling, otherwise calls index controller (default)
        if (!empty($slices[0])) {
            $directory = array_reverse(explode('/', URL_BASE));
            if ($slices[0] == $directory[0]) {
                array_shift($slices);
            }
            $this->controller = (!empty($slices[0]))? $slices[0] : 'index';
        } else $this->controller = 'index';

        // Identifies the action's call otherwise calls {$Controller}->index();
        $this->action = !empty($slices[1])? $slices[1] : 'index';

        // Identifies the calling parameters, if exists
        if(!empty($slices[2])){
            $ks = $vls = array();
            $total = count($slices);
            for ($i=2; $i < $total; $i++) {
                if ($i % 2 == 0) {
                    $ks[] = $slices[$i]; // if even is key
                } else {
                    $vls[] = $slices[$i]; // If odd is value
                }
            }
            if (count($ks) != count($vls)) $vls[] = '';
            $this->params = array_combine($ks, $vls);
        }
    }

    /**
     * Uses reflection to get classes, methods and others necessary stuff
     * @throws Exception
     */
    public function route()
    {
        if (!isset($this->route[$this->controller])){
            if(SHOW_ROUTE_ERRORS){
                $rerror = 'Router Error at url: '.$_SERVER['REQUEST_URI'].' <br/>';
                $rerror .= ' controller: '.$this->controller.', action: '.$this->action;
                $_SESSION['error'][] = $rerror;
            }
            $this->controller = APP.DS.'App';
            $this->action = 'notFound';
            } else {
                $this->controller =  $this->route[$this->controller];
        }

        try {
            $this->controller = str_replace("/", "\\", $this->getController());
            $rc = new \ReflectionClass($this->getController());
                if($rc->isSubclassOf('designetecnologia\main\inception\Controller')){
                    if($rc->hasMethod($this->getAction())){
                        $controller = $rc->newInstance();
                        $method = $rc->getMethod($this->getAction());
                        $method->invoke($controller);
                    } else {
                        $controller = $rc->newInstance();
                        $method = $rc->getMethod('notFound');
                        $method->invoke($controller);
                    }
                } else {
                    throw new LoggedException($this->getController().' not a subclass of Controller');
                }
        } catch (LoggedException $e) {
            $msg = "Controller {$this->getController()} or action {$this->action} don't exists!";
            $_SESSION['error'][] = $msg;
            echo 'Some error ocurred: ';
        } catch (\ReflectionException $e) {
            $msg = "Controller {$this->getController()} or action {$this->action} don't exists!";
            $_SESSION['error'][] = $msg;
            $this->controller = APP.DS.'App';
            self::route();
        } catch (LoggedException $e) {
            $_SESSION['error'] = $e->__toString();
            echo 'Some error ocurred. Go to Log table in database '.DBNAME.' and see warning message';
        }
    }

    /**
     * Return the identified params
     * @return multitype: <Array> | string
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Returns the controller's name
     * @return string
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * Returns the action called name
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Returns the renderized result
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Defines the controller call for the renderization of resulting
     * @param string $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }
}
