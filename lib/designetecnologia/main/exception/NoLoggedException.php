<?php
namespace designetecnologia\main\exception;

use Exception;

/**
 * Describes a basic Exception class for Letbit Framework
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
class NoLoggedException extends \Exception
{
  use NoLoggedTrait;
}
