<?php
namespace designetecnologia\main\exception;

/**
 * Describes a basic Exception trait for Letbit Framework
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
trait NoLoggedTrait
{
  public function __construct($message = null, $code = 0)
  {
    parent::__construct($message, $code);
    $_SESSION['error'] = $message;
  }
}
